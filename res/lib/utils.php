<?php
class Utils 
{
    public static function emptyElementExists($arr) {
        return array_search("", $arr) !== false;
    }    
    public static function redirectTo($url,$num=200){
       static $http = array (
           100 => "HTTP/1.1 100 Continue",
           101 => "HTTP/1.1 101 Switching Protocols",
           200 => "HTTP/1.1 200 OK",
           201 => "HTTP/1.1 201 Created",
           202 => "HTTP/1.1 202 Accepted",
           203 => "HTTP/1.1 203 Non-Authoritative Information",
           204 => "HTTP/1.1 204 No Content",
           205 => "HTTP/1.1 205 Reset Content",
           206 => "HTTP/1.1 206 Partial Content",
           300 => "HTTP/1.1 300 Multiple Choices",
           301 => "HTTP/1.1 301 Moved Permanently",
           302 => "HTTP/1.1 302 Found",
           303 => "HTTP/1.1 303 See Other",
           304 => "HTTP/1.1 304 Not Modified",
           305 => "HTTP/1.1 305 Use Proxy",
           307 => "HTTP/1.1 307 Temporary Redirect",
           400 => "HTTP/1.1 400 Bad Request",
           401 => "HTTP/1.1 401 Unauthorized",
           402 => "HTTP/1.1 402 Payment Required",
           403 => "HTTP/1.1 403 Forbidden",
           404 => "HTTP/1.1 404 Not Found",
           405 => "HTTP/1.1 405 Method Not Allowed",
           406 => "HTTP/1.1 406 Not Acceptable",
           407 => "HTTP/1.1 407 Proxy Authentication Required",
           408 => "HTTP/1.1 408 Request Time-out",
           409 => "HTTP/1.1 409 Conflict",
           410 => "HTTP/1.1 410 Gone",
           411 => "HTTP/1.1 411 Length Required",
           412 => "HTTP/1.1 412 Precondition Failed",
           413 => "HTTP/1.1 413 Request Entity Too Large",
           414 => "HTTP/1.1 414 Request-URI Too Large",
           415 => "HTTP/1.1 415 Unsupported Media Type",
           416 => "HTTP/1.1 416 Requested range not satisfiable",
           417 => "HTTP/1.1 417 Expectation Failed",
           500 => "HTTP/1.1 500 Internal Server Error",
           501 => "HTTP/1.1 501 Not Implemented",
           502 => "HTTP/1.1 502 Bad Gateway",
           503 => "HTTP/1.1 503 Service Unavailable",
           504 => "HTTP/1.1 504 Gateway Time-out"
       );
       header($http[$num]);
       header ("Location: $url");
    }
    public static function erase_val(&$myarr) {
        $myarr = array_map(create_function('$n', 'return null;'), $myarr);
    }       
    public static function arrayFind($array, $searchIndex, $searchValue, $toObject=FALSE){
        if(is_array($array) && $searchIndex != ''){                        
            foreach ($array as $omR) {
                if ($omR[$searchIndex] == $searchValue) {
                    if($toObject){
                        return (object)$omR;
                    }else{
                        return $omR;
                    }
                }
            } 
        }
        return NULL;
    } 
    public static function listFilter($array, $searchProperty, $searchValue){
        if(is_array($array)) {
            $outArray = array_filter($array, function ($e) use ($searchProperty, $searchValue) {
                return $e[$searchProperty] == $searchValue;
            });
            return array_values($outArray);
        }
        return array();
    }
    public static function removeKeys($array,$keys){
        if(is_array($array) && is_array($keys)){
            foreach ($keys as $k) {
                unset($array[$k]);
            }               
        }
        return $array;
    }
    public static function preserveKeys($array,$keys){
        $out = array();
        if(is_array($array) && is_array($keys)){            
            foreach ($keys as $k) {
                $out[$k] = $array[$k];
            }             
        }
        return $out;
    }    
    public static function get_client_ip_server() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }    
    //Funcion que escapa todos los caracteres invalidos enviados como parametros
    public static function mysql_escape_mimic($inp) {
        if(is_array($inp))
            return array_map(__METHOD__, $inp);
        if(!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }
        return $inp;
    }    
    public static function getTxtFile($filePath){
        $htmlContent = "";
        $file = fopen($filePath, "r") or exit("Unable to open file!");
        while(!feof($file))
        {
            $htmlContent.= utf8_decode(fgets($file));
        }
        fclose($file);    
        return $htmlContent;
    }
    public static function isValidMd5($md5){
        return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
    }
    public static function cPhp(){
        return substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
    }
}
//DE IMPRESION / FORMATO
function h($s, $charset = 'UTF-8')
{
    return htmlspecialchars($s, ENT_QUOTES, $charset);
}
function eh($str,$upper=false, $charset = 'UTF-8')
{
    $str = str_replace(array("\r\n", "\n", "\r"), ' ', $str);
    $str = htmlspecialchars($str, ENT_QUOTES, $charset);
    echo ($upper ? mb_strtoupper($str, $charset) : $str);
}
function eDay($d,$lng=null, $charset = 'UTF-8'){
    $days = cPrograma::getDays($lng);
    $dd = $days[$d];
    echo mb_strtoupper($dd, $charset);   
}
function sHr($hr){
    $out = '';
    if($hr){
        $out = date("H:i",strtotime($hr)).' HRS';
    }  
    return $out;
}
function eHr($hr){
    echo sHr($hr);
}
function ehj($json,$k, $charset = 'UTF-8')
{
    $jS = json_decode($json,TRUE);
    if(!empty($jS)){
        $str = str_replace(array("\r\n", "\n", "\r"), ' ', $jS[$k]);
        echo htmlspecialchars($str, ENT_QUOTES, $charset);
    }else{
        echo "";
    }
}
function ehl($str)
{
    $str = str_replace(array("\r\n", "\n", "\r"), ' ', $str);
    return str_replace('"','\u0022',$str);
}
function eip($item,$prop,$upper=false, $charset = 'UTF-8'){
    if(is_array($item))
    {
        $lng = Session::get('LANG');
        $f = $prop.'_'.$lng;
        if(array_key_exists($f, $item)){
            echo $upper ? mb_strtoupper($item[$f], $charset) : $item[$f];
        }else{
            echo '';
        }
    }else{
        echo '';
    }
}
//AUX
function isNoE($var){
    if(is_array($var)){
        return (!isset($var) || empty($var));
    }else{
        return (!isset($var) || trim($var)==='');
    }
}
function isEmail($var){
    if(isNoE($var)){
        return FALSE;
    }else{
        return filter_var($var, FILTER_VALIDATE_EMAIL );
    }
}
function isImgFile($file){
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    return in_array($ext, array("gif","jpg","jpeg","png"));
}
function parse_youtube($link){
    $regexstr = '~
      # Match Youtube link and embed code
      (?:               # Group to match embed codes
        (?:&lt;iframe [^&gt;]*src=")?   # If iframe match up to first quote of src
        |(?:            # Group to match if older embed
          (?:&lt;object .*&gt;)?    # Match opening Object tag
          (?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
          (?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
        )?              # End older embed code group
      )?                # End embed code groups
      (?:               # Group youtube url
        https?:\/\/             # Either http or https
        (?:[\w]+\.)*            # Optional subdomains
        (?:                         # Group host alternatives.
        youtu\.be/                # Either youtu.be,
        | youtube\.com        # or youtube.com 
        | youtube-nocookie\.com   # or youtube-nocookie.com
        )             # End Host Group
        (?:\S*[^\w\-\s])?         # Extra stuff up to VIDEO_ID
        ([\w\-]{11})            # $1: VIDEO_ID is numeric
        [^\s]*            # Not a space
      )               # End group
      "?                # Match end quote if part of src
      (?:[^&gt;]*&gt;)?           # Match any extra stuff up to close brace
      (?:               # Group to match last embed code
        &lt;/iframe&gt;             # Match the end of the iframe 
        |&lt;/embed&gt;&lt;/object&gt;          # or Match the end of the older embed
      )?                # End Group of last bit of embed code
      ~ix';
    preg_match($regexstr, $link, $matches);
    return $matches[1];
}
function parse_vimeo($link){
    $regexstr = '~
      # Match Vimeo link and embed code
      (?:&lt;iframe [^&gt;]*src=")?   # If iframe match up to first quote of src
      (?:             # Group vimeo url
        https?:\/\/       # Either http or https
        (?:[\w]+\.)*      # Optional subdomains
        vimeo\.com        # Match vimeo.com
        (?:[\/\w]*\/videos?)? # Optional video sub directory this handles groups links also
        \/            # Slash before Id
        ([0-9]+)        # $1: VIDEO_ID is numeric
        [^\s]*          # Not a space
      )             # End group
      "?              # Match end quote if part of src
      (?:[^&gt;]*&gt;&lt;/iframe&gt;)?    # Match the end of the iframe
      (?:&lt;p&gt;.*&lt;/p&gt;)?            # Match any title information stuff
      ~ix';
    
    preg_match($regexstr, $link, $matches);
    
    return $matches[1];
}
function get_youtube_id_from_url($url){
    if (stristr($url,'youtu.be/'))
        {preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
    else 
        {@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
}
function get_words($sentence, $count = 10) {
  preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
  return $matches[0];
}
function pageName($page){
    if(strpos($page,"?") !== false) {
        $page = substr($page, 0, strpos($page, "?"));
    }
    return substr(strtolower(basename($page)),0,strlen(basename($page))-4);
}