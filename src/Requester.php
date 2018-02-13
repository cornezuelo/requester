<?php
/**
 * Class to send curl requests
 * @author Oscar Aviles <emeeseka01@gmail.com>
 */
namespace AppBundle\Util;
class Requester {
    /**
     * Performs a get curl petition
     * @param string $uri The uri for doing the request
     * @param array $params An array of parameters for sending to the request
     * @param array $options An array of possible options to enable on the request
     * @return array It returns an array by default, but also could send a json with the json option enabled
     */
    public static function get($uri,$params=[],$options=[]) {
        return self::request('GET',$uri,$params,$options);
    }
    
    /**
     * Performs a post curl petition
     * @param string $uri The uri for doing the request
     * @param array $params An array of parameters for sending to the request
     * @param array $options An array of possible options to enable on the request
     * @return array It returns an array by default, but also could send a json with the json option enabled
     */
    public static function post($uri,$params=[],$options=[]) {
        return self::request('POST',$uri,$params,$options);
    }
    
    /**
     * Performs any kind of petition
     * @param string $method The method of the request
     * @param string $uri The uri for doing the request
     * @param array $params An array of parameters for sending to the request
     * @param array $options An array of possible options to enable on the request
     * @return array It returns an array by default, but also could send a json with the json option enabled
     */
    public static function request($method='GET',$uri,$params,$options=[]) {                                  
        $ch = curl_init();        
        
        if (!isset($options['no_return'])) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);       
        }
        
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; CrawlBot/1.0.0)');                
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
        curl_setopt($ch, CURLOPT_MAXREDIRS, 15);     
        
        if (isset($options['setopt']) && !empty($options['setopt'])) {
            foreach ($options['setopt'] as $k => $v) {
                curl_setopt($ch, $k, $v);       
            }
        }
        
        if (isset($options['timeout'])) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']); //timeout in seconds
        }
        
        if (isset($options['connect_timeout'])) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $options['connect_timeout']);
        }
        
        if (isset($options['keep_alive'])) {
            curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, 1);
            curl_setopt($ch, CURLOPT_TCP_KEEPIDLE, $options['keep_alive']);
            curl_setopt($ch, CURLOPT_TCP_KEEPINTVL, 15);
        }
        
        if (isset($options['headers']) && !empty($options['headers'])) {
            $aux_headers = [];
            foreach ($options['headers'] as $k_h => $v_h) {
                if (!empty($v_h)) {
                    $aux_headers[] = $k_h.': '.$v_h;
                }
            }                        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aux_headers);
        }
        
        if (isset($options['httpquery']) && !empty($options['httpquery'])) {
            $httpquery = $options['httpquery'];
        } 
        elseif (!empty($params)) {
            $httpquery = http_build_query($params);
        }
        
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        
        if ($method == "POST" || $method = "PUT") {                        
            if (!empty($httpquery)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $httpquery);
            }
        } elseif ($method != "GET") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        
        if ($method == 'GET' && !empty($httpquery)) {
            if (empty(parse_url($uri,PHP_URL_QUERY))) {
                $uri .= '?'.$httpquery;
            } else {
                $uri .= '&'.$httpquery;
            }
        }
        
        curl_setopt($ch, CURLOPT_URL, $uri);
        
        $start = microtime(true); 
        if (isset($options['bg']) && $options['bg'] == 1) {
            $extra_curl = '';
            if (isset($options['timeout'])) {
                $extra_curl .= ' --max-time '.$options['timeout'];
            }
            if (isset($options['connect_timeout'])) {
                $extra_curl .= ' --connect-timeout '.$options['connect_timeout'];
            }
            if (isset($options['keep_alive'])) {
                $extra_curl .= ' --keepalive-time '.$options['keep_alive'];
            }
            if (isset($options['headers'])) {
                foreach ($options['headers'] as $k => $v) {
                    $extra_curl .= ' -H "'.$k.': '.$v.'"';
                }
                
            }
            $curl = 'curl -s'.$extra_curl.' "'.$uri.'" > /dev/null 2>&1 &';            
            $output = shell_exec($curl);
        } else {
            $output = curl_exec($ch);        
        }
        $end = (microtime(true) - $start);
        $getinfo = curl_getinfo($ch);
        $getinfo['curl_exec_timing_ms'] = $end;
        if (!empty($httpquery)) {
            $getinfo['http_query'] = $httpquery;
        }
        if (!empty($aux_headers)) {            
            $getinfo['headers'] = implode(', ',$aux_headers);
        }
        if (isset($curl) && !empty($curl)) {
            $getinfo['curl'] = $curl;
        }
        
        curl_close($ch);                              
        
        if (isset($options['jsondecode_output'])) {
            $aux = @json_decode($output);
            if ($aux === null && json_last_error() !== JSON_ERROR_NONE) {
                $output = 'JSON Decode Error: '.json_last_error_msg();
            } else {
                $output = print_r($aux,true);
            }
        }
        
        if ($getinfo['http_code'] != 200) {
            $return = ['result' => false, 'info' => $getinfo, 'output' => $output];            
        }
        else $return = ['result' => true, 'info' => $getinfo, 'output' => $output];                            
        
        if (isset($options['json'])) {
            $aux = json_encode($return);        
            if ($aux === false && json_last_error() == JSON_ERROR_UTF8) {
                $output = utf8_encode($output);
                $aux = json_encode(['result' => $return['result'], 'info' => $return['info'], 'output' => $output]);
            }
            $return = $aux;            
        }
        return $return;
    }
}