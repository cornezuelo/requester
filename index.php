<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="ISO-8859-1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

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
                      <option value="GET">GET</option>
                      <option value="POST">POST</option>
                      <option value="PUT">PUT</option>
                      <option value="PATCH">PATCH</option>
                      <option value="HEAD">HEAD</option>
                      <option value="OPTIONS">OPTIONS</option>
                      <option value="DELETE">DELETE</option>
                    </select>
                  </div>                  
                  <div class="form-group col-md-8">
                    <label for="request-uri">URI</label>
                    <input type="text" class="form-control" id="request-uri" name="request-uri" aria-describedby="request-uri" placeholder="http://www.uri.com...">                  
                  </div>                
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="request-followredirections" name="request-followredirections" value="1">
                  <label class="form-check-label" for="request-followredirections">Follow redirections</label>
                </div>          
                <hr>                
                <h4>Headers</h4>                
                <div class="form-group">
                    <div class="form-row">                      
                      <div class="col">
                        <input type="text" class="form-control" name="request-header-keys[]" placeholder="Key...">
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="request-header-values[]" placeholder="Value...">
                      </div>
                    </div>                                                          
                </div>                
                <div class="row">
                    <div class="col-sm-12" align="right">
                        <button type="button" class="btn btn-primary btn-sm" title="Add" id="btn-add-header"><i class="fas fa-plus-square"></i> Add</button>          
                    </div>
                </div>
                <hr>
                <h4>Parameters</h4>                
                <div class="form-group">
                    <div class="form-row">                      
                      <div class="col">
                        <input type="text" class="form-control" name="request-param-keys[]" placeholder="Key...">
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="request-param-values[]" placeholder="Value...">
                      </div>
                    </div>                                                          
                </div>                
                <div class="row">
                    <div class="col-sm-12" align="right">
                        <button type="button" class="btn btn-primary btn-sm" title="Add" id="btn-add-param"><i class="fas fa-plus-square"></i> Add</button>          
                    </div>
                </div>
                <hr>
                <div class="row">                    
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Save"><i class="fas fa-save"></i> Save</button>          
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Load"><i class="fas fa-folder-open"></i> Load</button>          
                    </div>
                    <div class="col-sm-8" align="right">                    
                        <button type="submit" class="btn btn-success btn-lg" id="btn-submit" title="Send"><i class="fas fa-share-square"></i> Send</button>
                    </div>
                </div>
                <div>                                        
              </form>                                         
        </div>
      </div>
      <div class="col-sm-1"></div>
    </div>
    <hr>
    <div class="form-group" id="div-content">        
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>        
        $( "#form-main" ).submit(function( event ) {
           event.preventDefault(); 
           $('#div-content').html('<div align="center"><i class="fas fa-cog fa-spin fa-10x"></i></div>');
           $('#btn-submit').attr('disabled',true);
           var jqxhr = $.post('controller.php', $('#form-main').serialize());
           jqxhr.always(function(e) {
              $('#div-content').html('<textarea class="form-control" rows="10" style="width:100%" id="textarea-content">'+e+'</textarea>');
              $('#btn-submit').attr('disabled',false);
           });
        });        
    </script>    
  </body>
</html>