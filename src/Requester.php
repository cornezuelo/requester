<?php
/**
 * Class to send curl requests
 * @author Oscar Aviles <emeeseka01@gmail.com>
 */
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
        
        if (isset($options['setopt']) && !empty($options['setopt'])) {
            foreach ($options['setopt'] as $k => $v) {
                curl_setopt($ch, $k, $v);       
            }
        }
        
        if (isset($options['headers']) && !empty($options['headers'])) {
            $aux_headers = [];
            foreach ($options['headers'] as $k_h => $v_h) {
                $aux_headers[] = $k_h.': '.$v_h;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aux_headers);
        }
        
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (!empty($params)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            }
        } elseif ($method != "GET") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        }
        
        if ($method == 'GET' && !empty($params)) {
            $uri .= '?'.http_build_query($params);
        }
        
        curl_setopt($ch, CURLOPT_URL, $uri);
        
        $output = curl_exec($ch);        
        $getinfo = curl_getinfo($ch);
        curl_close($ch);      
        
        if (isset($options['utf8_encode'])) {
            $output = utf8_encode($output);
        }        
        
        if (isset($options['utf8_decode'])) {
            $output = utf8_decode($output);
        }
        
        if ($getinfo['http_code'] != 200) {
            $return = ['result' => false, 'info' => $getinfo, 'output' => htmlentities($output)];            
        }
        else $return = ['result' => true, 'info' => $getinfo, 'output' => htmlentities($output)];            
                
        if (isset($options['json'])) {
            $return = json_encode($return);
        }
        return $return;
    }
}