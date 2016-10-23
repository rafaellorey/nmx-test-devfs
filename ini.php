<?php
//BASES
mb_internal_encoding('UTF-8');
date_default_timezone_set('America/Mexico_City');
defined("ROOT") or define('ROOT', str_replace('\\', '/', dirname(__FILE__)). '/');
defined("RES") or define('RES', str_replace('\\', '/', dirname(__FILE__)). '/res/');
require_once(RES .'class/base.php');
require_once(RES .'class/config.php');
//CONFIGURACION Y CONSTANTES
$config = Config::read('config');
$env = $config['application']['environment'];
defined("ENV")
or define('ENV',$env);
defined("URL")
or define('URL',$config['url'][ENV]);
//LIBRERIAS
require_once(RES .'lib/session.php');
require_once(RES .'lib/utils.php');
require_once(RES .'lib/html.php');
require_once(RES .'lib/input.php');
require_once(RES .'lib/medoo.php');
require_once(RES .'lib/uploadFile.php');
require_once(RES .'lib/paginate.php');
require_once(RES .'lib/antiXss.php');
//AUTO CARGA DE CLASES
foreach(glob(RES.'class/c*.php') as $file)
{
    if(!is_dir($file)){
        require_once($file);
    }
}
//CONTEXTO -> INTRANET
$cur = basename($_SERVER['PHP_SELF']);
if(strtolower($cur) == 'admin.php'){
    //verifica session 
    if(!Session::has('CMS_id')){
        Utils::redirectTo("index.php");
    }else{
        //USUARIO ACTUAL EN SESION
        $cUser = new cUsuario();
        if(!$cUser->get(Session::get('CMS_id'))){
            Utils::redirectTo("index.php");
        }
    }
}
//ERROR REPORTING
//error_reporting(0);
//AUTO CARGA ARCHIVO INCLUDE DE LA PAGINA ACTUAL
if(file_exists(RES .'inc/'.$cur)){
    include(RES .'inc/'.$cur);
}