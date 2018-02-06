<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Follow redirections</label>
                </div>          
                <hr>
                <div class="form-group">
                  AUTHENTICATION
                </div>
                <div class="form-group">
                  HEADERS
                </div>
                <div class="form-group">
                  PARÁMETROS
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
      <?php
        include 'src/Requester.php';
        if (isset($_REQUEST['request-uri'])) {
            echo '<hr>';
            echo '<pre>';
            print_r(Requester::get($_REQUEST['request-uri']));
        }
      ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>