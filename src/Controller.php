<?php
include 'Requester.php';
if (isset($_REQUEST['request-uri'])) {        
    $options = [];
    $params = [];
    if (isset($_REQUEST['request-followredirections'])) {
        $options['setopt'][CURLOPT_FOLLOWLOCATION] = 1;
    }    
    if (isset($_REQUEST['request-utf8encode'])) {
        $options['utf8_encode'] = 1;
    }
    if (isset($_REQUEST['request-utf8decode'])) {
        $options['utf8_decode'] = 1;
    }
    $res = Requester::get($_REQUEST['request-uri'],$params,$options);      
    print_r($res);die();    
}
