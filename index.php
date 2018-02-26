<?php
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'load' && isset($_REQUEST['file'])) {
    $load = json_decode(file_get_contents('json/'.$_REQUEST['file']),true);
    //echo '<pre>';print_r($load);die();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <style>
        .response {
            background: #212121 !important;
            color: #E3F3FF !important;
        }
    </style>
    <title>Requester</title>
  </head>
  <body>    
    <div class="container">
      <div class="row">        
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <h1 align="center">Requester</h1>          
          <hr>                      
              <form id="form-main">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="request-method">Method</label>
                    <select id="request-method" name="request-method" class="form-control">                      
                      <option value="GET"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'GET') { echo ' selected'; }?>>GET</option>
                      <option value="POST"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'POST') { echo ' selected'; }?>>POST</option>
                      <option value="PUT"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'PUT') { echo ' selected'; }?>>PUT</option>
                      <option value="PATCH"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'PATCH') { echo ' selected'; }?>>PATCH</option>
                      <option value="HEAD"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'HEAD') { echo ' selected'; }?>>HEAD</option>
                      <option value="OPTIONS"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'OPTIONS') { echo ' selected'; }?>>OPTIONS</option>
                      <option value="DELETE"<?php if (isset($load) && isset($load['request-method']) && $load['request-method'] == 'DELETE') { echo ' selected'; }?>>DELETE</option>
                    </select>
                  </div>                  
                  <div class="form-group col-md-8">
                    <label for="request-uri">URI</label>
                    <input type="text" class="form-control" id="request-uri" name="request-uri" aria-describedby="request-uri" placeholder="http://www.uri.com..."<?php if (isset($load) && isset($load['request-uri'])) { echo ' value="'.$load['request-uri'].'"'; }?>>                  
                  </div>                
                </div>
                <div class="form-check form-check-inline">
                  <input type="checkbox" class="form-check-input" id="request-followredirections" name="request-followredirections" value="1"<?php if (isset($load) && isset($load['request-followredirections']) && $load['request-followredirections'] == 1) { echo ' checked'; }?>>
                  <label class="form-check-label" for="request-followredirections">Follow redirections</label>
                </div>                
                <div class="form-check form-check-inline">
                  <input type="checkbox" class="form-check-input" id="request-jsondecodeoutput" name="request-jsondecodeoutput" value="1"<?php if (isset($load) && isset($load['request-jsondecodeoutput']) && $load['request-jsondecodeoutput'] == 1) { echo ' checked'; }?>>
                  <label class="form-check-label" for="request-jsondecodeoutput">JSON Decode Output</label>
                </div>                
                <hr>                
                <h4>Headers</h4>                
                <div id="div-header">
                    <div class="form-group" id="template-header" style="display:none">
                        <div class="form-row">                      
                          <div class="col">
                            <input type="text" class="form-control request-header-keys" name="request-header-keys[]" placeholder="Key...">
                          </div>
                          <div class="col">
                            <input type="text" class="form-control request-header-values" name="request-header-values[]" placeholder="Value...">
                          </div>
                          <div class="col-auto">
                              <button type="button" class="btn btn-outline-danger btn btn-remove-headers" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                          </div>
                        </div>                                                          
                    </div>   
                    <?php if (isset($load) && (isset($load['request-header-keys']) && !empty($load['request-header-keys'])) || (isset($load['request-header-values']) && !empty($load['request-header-values']))) { ?>
                        <?php 
                        foreach($load['request-header-keys'] as $k => $v) { 
                            if (empty($v) && (!isset($load['request-header-values'][$k]) || empty($load['request-header-values'][$k]))) {
                                continue;
                            }
                        ?>
                            <div class="form-group" id="template-header">
                                <div class="form-row">                      
                                  <div class="col">
                                    <input type="text" class="form-control request-header-keys" name="request-header-keys[]" placeholder="Key..."<?php if (!empty($v)) { echo ' value="'.$v.'"'; } ?>>
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control request-header-values" name="request-header-values[]" placeholder="Value..."<?php if (!empty($load['request-header-values'][$k])) { echo ' value="'.$load['request-header-values'][$k].'"'; } ?>>
                                  </div>
                                  <div class="col-auto">
                                      <button type="button" class="btn btn-outline-danger btn btn-remove-headers" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                                  </div>
                                </div>                                                          
                            </div>                         
                        <?php } ?>
                    <?php } else { ?>
                    <div class="form-group" id="template-header">
                        <div class="form-row">                      
                          <div class="col">
                            <input type="text" class="form-control request-header-keys" name="request-header-keys[]" placeholder="Key...">
                          </div>
                          <div class="col">
                            <input type="text" class="form-control request-header-values" name="request-header-values[]" placeholder="Value...">
                          </div>
                          <div class="col-auto">
                              <button type="button" class="btn btn-outline-danger btn btn-remove-headers" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                          </div>
                        </div>                                                          
                    </div>     
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-sm-12" align="right">
                        <button type="button" class="btn btn-primary btn" title="Add" id="btn-add-header"><i class="fas fa-plus-square"></i> Add</button>          
                    </div>
                </div>
                <hr>
                <h4>Parameters</h4> 
                <input type="hidden" name="type-params" id="type-params" value="<?php if (isset($load) && isset($load['type-params'])) { echo $load['type-params']; } else { echo 'simple'; }?>">
                <nav>
                  <div class="nav nav-tabs" id="nav-params-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-params-simple-tab" data-toggle="tab" href="#nav-params-simple" role="tab" aria-controls="nav-params-simple" aria-selected="true">Simple</a>
                    <a class="nav-item nav-link" id="nav-params-httpquery-tab" data-toggle="tab" href="#nav-params-httpquery" role="tab" aria-controls="nav-params-httpquery" aria-selected="false">HTTP Query</a>                
                  </div>
                </nav>
                <div class="tab-content" id="nav-paramstabContent">                                        
                    <div class="tab-pane fade show active" id="nav-params-simple" role="tabpanel" aria-labelledby="nav-params-simple-tab">
                        <div id="div-param">
                            <br>
                            <div class="form-group" id="template-param" style="display:none">
                                <div class="form-row">                      
                                  <div class="col">
                                    <input type="text" class="form-control request-params-keys" name="request-params-keys[]" placeholder="Key...">
                                  </div>
                                  <div class="col">
                                    <input type="text" class="form-control request-param-values" name="request-params-values[]" placeholder="Value...">
                                  </div>
                                  <div class="col-auto">
                                      <button type="button" class="btn btn-outline-danger btn btn-remove-params" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                                  </div>
                                </div>                                                          
                            </div>     
                            <?php if (isset($load) && (isset($load['request-params-keys']) && !empty($load['request-params-keys'])) || (isset($load['request-params-values']) && !empty($load['request-params-values']))) { ?>
                                <?php 
                                foreach($load['request-params-keys'] as $k => $v) { 
                                    if (empty($v) && (!isset($load['request-params-values'][$k]) || empty($load['request-params-values'][$k]))) {
                                        continue;
                                    }
                                ?>
                                    <div class="form-group" id="template-param">
                                        <div class="form-row">                      
                                          <div class="col">
                                            <input type="text" class="form-control request-params-keys" name="request-params-keys[]" placeholder="Key..."<?php if (!empty($v)) { echo ' value="'.$v.'"'; } ?>>
                                          </div>
                                          <div class="col">
                                            <input type="text" class="form-control request-param-values" name="request-params-values[]" placeholder="Value..."<?php if (!empty($load['request-params-values'][$k])) { echo ' value="'.$load['request-params-values'][$k].'"'; } ?>>
                                          </div>
                                          <div class="col-auto">
                                              <button type="button" class="btn btn-outline-danger btn btn-remove-params" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                                          </div>
                                        </div>                                                          
                                    </div>   
                                <?php } ?>
                            <?php } else { ?>
                                <div class="form-group" id="template-param">
                                    <div class="form-row">                      
                                      <div class="col">
                                        <input type="text" class="form-control request-params-keys" name="request-params-keys[]" placeholder="Key...">
                                      </div>
                                      <div class="col">
                                        <input type="text" class="form-control request-param-values" name="request-params-values[]" placeholder="Value...">
                                      </div>
                                      <div class="col-auto">
                                          <button type="button" class="btn btn-outline-danger btn btn-remove-params" title="Remove"><i class="fas fa-trash-alt"></i></button>          
                                      </div>
                                    </div>                                                          
                                </div>     
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" align="right">
                                <button type="button" class="btn btn-primary btn" title="Add" id="btn-add-param"><i class="fas fa-plus-square"></i> Add</button>          
                            </div>
                        </div>                        
                    </div>
                    <div class="tab-pane fade" id="nav-params-httpquery" role="tabpanel" aria-labelledby="nav-params-httpquery-tab">
                        <br>
                        <textarea class="form-control" rows="5" style="width:100%" name="textarea-params-httpquery-content" id="textarea-params-httpquery-content" placeholder="param1=value1&param2=value2&param3[]=value3..."><?php if (isset($load) && isset($load['textarea-params-httpquery-content'])) { echo $load['textarea-params-httpquery-content'];}?></textarea>
                    </div>
                </div>                                    
                <hr>
                <div class="row">                    
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Save" data-toggle="modal" data-target="#saveModal"><i class="fas fa-save"></i> Save</button>          
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Load" data-toggle="modal" data-target="#loadModal"><i class="fas fa-folder-open"></i> Load</button>          
                    </div>
                    <div class="col-sm-8" align="right">                    
                        <button type="submit" class="btn btn-success btn-lg" id="btn-submit" title="Send"><i class="fas fa-share-square"></i> Send</button>
                    </div>
                </div>                
              </form>                                         
        </div>
      </div>
      <div class="col-sm-1"></div>
    </div>
    <hr>
    <div class="container" id="div-content">            
        <div class="row">
            <div class="col">
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-response-tab" data-toggle="tab" href="#nav-response" role="tab" aria-controls="nav-response" aria-selected="true">Response</a>
                    <a class="nav-item nav-link" id="nav-curlinfo-tab" data-toggle="tab" href="#nav-curlinfo" role="tab" aria-controls="nav-curlinfo" aria-selected="false">Curl Info</a>                
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-response" role="tabpanel" aria-labelledby="nav-response-tab"><br><i class="fas fa-plug fa-5x"></i></div>
                    <div class="tab-pane fade" id="nav-curlinfo" role="tabpanel" aria-labelledby="nav-curlinfo-tab"><br><i class="fas fa-plug fa-5x"></i></div>
                </div>            
            </div>
        </div>
    </div>
    
    <!-- Modal Save -->
    <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Save Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-group row">
              <label class="col-form-label col-sm-1" for="save-title">Title</label>
              <div class="col-sm-11">
                <input type="text" class="form-control" id="save-title" placeholder="Request example #3...">                           
              </div>
            </form>              
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" id="result-save"></div>
                <div class="col-sm-1"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            <button type="button" class="btn btn-primary" id="btn-save-request"><i class="fas fa-save"></i> Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal Load -->
    <div class="modal fade" id="loadModal" tabindex="-1" role="dialog" aria-labelledby="loadModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Load Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
                <div id="table-load">
                    <div align="center"><i class="fas fa-cog fa-spin fa-10x"></i></div>
                </div>
            </div>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>            
          </div>
        </div>
      </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script defer src="js/fontawesome.all.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="js/jquery.serialize.json.min.js"></script>
    <script>        
        $( "#form-main" ).submit(function( event ) {
           event.preventDefault(); 
           $('#nav-curlinfo').html('');
           $('#nav-response').html('');
           _html = $("#div-content").html();
           $('#div-content').html('<div align="center"><i class="fas fa-cog fa-spin fa-10x"></i></div>');
           $('#btn-submit').attr('disabled',true);
           var _data = {'action' : 'request', 'data' : $('#form-main').serialize()};
           var jqxhr = $.post('src/Controller.php', _data, function(){}, 'json');
           jqxhr.always(function(e) {               
            $('#div-content').html(_html);            
            if (typeof(e.output) !== 'undefined') {                
                var _info = '<br><ul>';                
                for (var prop in e.info) {                    
                    _info += '<li><b>'+prop+'</b>: '+e.info[prop]+'</li>'                    
                }                
                _info += '</ul>';                
                $('#nav-curlinfo').html(_info);
                $('#nav-response').html('<br><textarea class="form-control response" rows="25" style="width:100%" id="textarea-content" onclick="$(this).select()">'+e.output+'</textarea>');                
            } else {                
                $('#nav-curlinfo').html('<br><h3 align="center">Oooppssss... Error on json response! Maybe enconding problem?</h3>');
                $('#nav-response').html('<br><h3 align="center">Oooppssss... Error on json response! Maybe enconding problem?</h3><textarea class="form-control response" rows="25" style="width:100%" id="textarea-content">'+e.responseText+'</textarea>');
            }                        
            $('#btn-submit').attr('disabled',false);
           });
        });
        
        $('#btn-add-param').click(function (e) {
            var cloned = $( "#template-param" ).clone(true).appendTo( "#div-param" );
            cloned.show();
        });
        
        $('#btn-add-header').click(function (e) {
            var cloned = $( "#template-header" ).clone(true).appendTo( "#div-header" );
            cloned.show();
        });
        
        $('#btn-save-request').on('click',function(e) {
            var _data = {'action' : 'save', 'data' : JSON.stringify($('#form-main').serializeJSON()), 'title' : $('#save-title').val()};
            var jqxhr = $.post('src/Controller.php', _data, function(){}, 'json');
            jqxhr.always(function(e) {
                if (typeof(e.result) !== 'undefined') {
                    if (e.result === true) {
                        if (typeof(e.error) === 'undefined') {
                            $('#result-save').html('<span style="color:green"><b>OK!</b> Saved succesfully!</span>');
                        } else {
                            $('#result-save').html(e.error);
                        }
                    } else if (typeof(e.error) === 'undefined') {
                        $('#result-save').html('<span style="color:red"><b>Error!</b> Undefined error at saving!</span>');
                    } else {
                        $('#result-save').html(e.error);
                    }
                } else {
                    $('#result-save').html('<span style="color:red"><b>Error!</b> Error on response from controller!</span>');
                }                                
            });
        });        
        
        $('#saveModal').on('hidden.bs.modal', function () {            
            $('#save-title').val('');
            $('#result-save').html('');
        });
        
        $('#loadModal').on('hidden.bs.modal', function () {            
            $('#table-load-inner').html('<div align="center"><i class="fas fa-cog fa-spin fa-10x"></i></div>');
        });                
        
        $('#loadModal').on('shown.bs.modal', function () {
            $('#table-load-inner').html('<div align="center"><i class="fas fa-cog fa-spin fa-10x"></i></div>');
            var _data = {'action' : 'load_list'};
            var jqxhr = $.post('src/Controller.php', _data, function(){});
            jqxhr.always(function(e) {                
                $('#table-load').html(e);                
                $('#table-load-inner').DataTable({responsive: true});
            });
        });
        
        $('.btn-remove-params').on('click',function(e) {            
            $(this).parent().parent().parent().remove();
        });
        
        $('.btn-remove-headers').on('click',function(e) {
            $(this).parent().parent().parent().remove();
        });
        
        $('#nav-params-simple-tab').click(function(e) {
            $('#type-params').val('simple');
        });
        
        $('#nav-params-httpquery-tab').click(function(e) {
            $('#type-params').val('httpquery');            
        });                                        
        <?php if (isset($load) && isset($load['type-params']) && $load['type-params'] == 'httpquery') { ?>
            $( document ).ready(function() {
                $('#nav-params-httpquery-tab').click();
            });
        <?php } ?>
    </script>    
  </body>
</html>