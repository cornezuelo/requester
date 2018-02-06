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
              <form m>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="request-method">Method</label>
                    <select id="request-method" name="request-method" class="form-control">                      
                      <option value="GET"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "GET") echo ' selected'; ?>>GET</option>
                      <option value="POST"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "POST") echo ' selected'; ?>>POST</option>
                      <option value="PUT"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "PUT") echo ' selected'; ?>>PUT</option>
                      <option value="PATCH"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "PATCH") echo ' selected'; ?>>PATCH</option>
                      <option value="HEAD"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "HEAD") echo ' selected'; ?>>HEAD</option>
                      <option value="OPTIONS"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "OPTIONS") echo ' selected'; ?>>OPTIONS</option>
                      <option value="DELETE"<?php if (isset($_REQUEST['request-method']) && $_REQUEST['request-method'] == "DELETE") echo ' selected'; ?>>DELETE</option>
                    </select>
                  </div>                  
                  <div class="form-group col-md-8">
                    <label for="request-uri">URI</label>
                    <input type="text" class="form-control" id="request-uri" name="request-uri" aria-describedby="request-uri" placeholder="http://www.uri.com..." value="<?php if (isset($_REQUEST['request-uri'])) echo $_REQUEST['request-uri']; ?>">                  
                  </div>                
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="request-followredirections" name="request-followredirections"<?php if (isset($_REQUEST['request-followredirections']) && $_REQUEST['request-followredirections'] == 1) echo ' checked'; ?> value="1">
                  <label class="form-check-label" for="request-followredirections">Follow redirections</label>
                </div>          
                <hr>
                <h4>Authentication</h4>
                <hr>
                <div class="form-group">                  
                </div>
                <hr>
                <h4>Headers</h4>
                <hr>
                <div class="form-group">                  
                </div>                
                <hr>
                <h4>Parameters</h4>
                <hr>
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
                <hr>
                <div class="row">                    
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Save"><i class="fas fa-save"></i> Save</button>          
                        <button type="button" class="btn btn-outline-primary btn-sm" title="Load"><i class="fas fa-folder-open"></i> Load</button>          
                    </div>
                    <div class="col-sm-8" align="right">                    
                        <button type="submit" class="btn btn-primary btn-lg" title="Send"><i class="fas fa-share-square"></i> Send</button>
                    </div>
                </div>
                <div>                                        
              </form>                                         
        </div>
      </div>
      <div class="col-sm-1"></div>
    </div>
<?php
  include 'src/Requester.php';
  if (isset($_REQUEST['request-uri'])) {
      echo '<hr>';
      //echo '<pre>';print_r($_REQUEST);echo '</pre>';
      $options = [];
      $params = [];
      if (isset($_REQUEST['request-followredirections'])) {
          $options['setopt'][CURLOPT_FOLLOWLOCATION] = 1;
      }
      echo '<div class="form-group"><textarea class="form-control" rows="10" style="width:100%">';
      print_r(Requester::get($_REQUEST['request-uri'],$params,$options));
      echo '</textarea></div>';
  }
?>        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>