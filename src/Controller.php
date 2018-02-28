<?php
include 'Requester.php';
if (!isset($_REQUEST['action'])) {
    die('No action sent.');
}
switch ($_REQUEST['action']) {
    case 'request':        
        parse_str($_REQUEST['data'],$data);                        
        if (isset($data['request-uri'])) {        
            $options = ['json' => 1];
            $params = [];
            if (isset($data['request-followredirections'])) {
                $options['follow'] = 1;
            }    
            if (isset($data['request-jsondecodeoutput'])) {
                $options['jsondecode_output'] = 1;
            }
            if (isset($data['request-header-keys']) && !empty($data['request-header-keys'])) {                
               foreach ($data['request-header-keys'] as $k => $v) {
                   if (!empty($v) && isset($data['request-header-values'][$k])) {
                       $options['headers'][$v] = $data['request-header-values'][$k];
                   }
               } 
            }
            if (isset($data['request-params-keys']) && !empty($data['request-params-keys'])) {
                foreach ($data['request-params-keys'] as $k => $v) {
                   if (!empty($v) && isset($data['request-params-values'][$k])) {
                       $params[$v] = $data['request-params-values'][$k];
                   }
               }         
            }

            if ($data['type-params'] == 'httpquery' && !empty($data['textarea-params-httpquery-content'])) {
                $options['httpquery'] = $data['textarea-params-httpquery-content'];
            }            
            $res = Requester::request($data['request-method'],$data['request-uri'],$params,$options);                         
            print_r($res);die();    
        }    
        break;
    case 'save':
        createRoute('../json');
        $path = '../json/'.$_REQUEST['title'].'.json';
        if (empty($_REQUEST['title'])) {
            $return = ['result' => false, 'error' => '<span style="color:red"><b>Error!</b> The file name can\'t be empty.</span>'];
        }
        else {
            if (file_exists($path)) {
                $pathaux = $path.'.'.date('YmdHis').'.bkp';
                copy($path,$pathaux);
                $msg = '<span style="color:#F26D00"><b>Warning!</b> The file name already existed and was overwritted.<br>A copy was made as <a href="'.str_replace('../json/', 'json/', $pathaux).'" target="_blank">'.str_replace('../json/', '', $pathaux).'</a> just in case of recovery.</span>';
            } else {
                $msg = '<span style="color:green"><b>OK!</b> Saved succesfully!</span>';
            }
            file_put_contents($path, $_REQUEST['data']);
            $return = ['result' => true, 'error' => $msg];
        }
        echo json_encode($return); die();
        break;
    case 'load_list':
        $files = '<table id="table-load-inner" class="display" style="width: 100% !important"><thead><tr><th>File</th></tr></thead><tbody id="body-load">';                    
        createRoute('../json');        
        foreach (new DirectoryIterator('../json') as $fileInfo) {            
            if($fileInfo->isDot()) continue;
            if ($fileInfo->getExtension() == 'json') {
                $files .= '<tr><td><a href="?action=load&file='.$fileInfo->getFilename().'">'.$fileInfo->getFilename().'</a></td></tr>';
            }
        }        
        $files .= '</tbody></table>';
        echo $files;die();
        break;
    default:
        die('The action doesn\'t exist.');
        break;
}

function createRoute($dir,$mode=02775) {
    if(!$dir) {
        return;	
    }		
    $output=false;
    if (!file_exists($dir)) {
        if (isset($_SERVER["WINDIR"])) $output=@mkdir($dir);//windows
        else
        {
            $output=@mkdir($dir, $mode, true);//no windows and recursive
            exec("chown -R www-data:www-data $dir");
        }
    }
    return $output;
}