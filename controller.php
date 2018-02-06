<?php
include 'src/Requester.php';
if (isset($_REQUEST['request-uri'])) {        
    $options = [];
    $params = [];
    if (isset($_REQUEST['request-followredirections'])) {
        $options['setopt'][CURLOPT_FOLLOWLOCATION] = 1;
    }    
    $res = Requester::get($_REQUEST['request-uri'],$params,$options);      
    print_r($res);die();    
}
