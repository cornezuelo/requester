<?php
include 'Requester.php';
if (isset($_REQUEST['request-uri'])) {        
    $options = ['json' => 1];
    $params = [];
    if (isset($_REQUEST['request-followredirections'])) {
        $options['setopt'][CURLOPT_FOLLOWLOCATION] = 1;
    }    
    if (isset($_REQUEST['request-header-keys']) && !empty($_REQUEST['request-header-keys'])) {
       foreach ($_REQUEST['request-header-keys'] as $k => $v) {
           if (!empty($v) && isset($_REQUEST['request-header-values'][$k])) {
               $options['headers'][$v] = $_REQUEST['request-header-values'][$k];
           }
       } 
    }
    if (isset($_REQUEST['request-params-keys']) && !empty($_REQUEST['request-params-keys'])) {
        foreach ($_REQUEST['request-params-keys'] as $k => $v) {
           if (!empty($v) && isset($_REQUEST['request-params-values'][$k])) {
               $params[$v] = $_REQUEST['request-params-values'][$k];
           }
       }         
    }
    
    if ($_REQUEST['type-params'] == 'httpquery' && !empty($_REQUEST['textarea-params-httpquery-content'])) {
        $options['httpquery'] = $_REQUEST['textarea-params-httpquery-content'];
    }
    
    $res = Requester::request($_REQUEST['request-method'],$_REQUEST['request-uri'],$params,$options);      
    print_r($res);die();    
}
