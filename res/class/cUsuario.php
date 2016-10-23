<?php
//Clase de la Entidad Usuario en base de Datos.
class cUsuario extends base {
    public $nombre;
    public $email;
    public $pass;
    public $login_date;
    public $create_date;
    public $estatus;        
    //******* OVERRIDE ******/
    public function __construct()
    {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                parent::__construct("usuario");
                break;
            case 1:
                parent::__construct("usuario",$argv[0]);
        }
    }
    public function chkRequired(){
        return (!isNoE($this->email) && !isNoE($this->pass) && !isNoE($this->nombre));
    }         
    //***** BL ******/  
    //Inicia sesión
    public function login($email,$pass){
        $ret = FALSE;
        if(isEmail($email) && !isNoE($pass)){
            $dbm = new medoo();
            $oUs = $dbm->get($this->tabla,array("id"),
                array('AND' => array("email"=>$email,'pass'=>$pass, 'estatus'=>1)));
            if(is_array($oUs)){
                $dbm->update($this->tabla, array("#login_date"=>"NOW()"), array('id' => $oUs["id"]));
                Session::set('CMS_id', $oUs["id"]);
                $ret = true;
            }
        }
        return $ret;
    }
    //Termina sesión
    public static function logout(){
        Session::delete('CMS_id');
    }    
    //Verifica si el email ya fue registrado por otro usuario
    public function getUserByEmail($email){
        $ret = FALSE;
        if(isEmail($email)){
            $dbm = new medoo();
            $oUs = $dbm->get($this->tabla,array("api_key"), array('AND' => array("email"=>$email, 'estatus'=>1)));
        }
        return $oUs;
    }            
    //Envia nuevo password random
    public function resetPass($email){
        if(isEmail($email)){
            $dbm = new medoo();
            if($dbm->has($this->tabla, array('AND' => array("email"=>$email,'estatus'=>1)))){ 
                $guid = md5(uniqid('',TRUE));
                $passNew = $this->random_password();
                $rowsAfec = $dbm->update($this->tabla, array("pass"=>$passNew, "guid"=>$guid), array("email"=>$email));
                if($rowsAfec > 0){
                    $oUs = $dbm->get($this->tabla,array("id","nombre"),array('AND' => array("email"=>$email,'pass'=>$passNew, 'estatus'=>1)));   
                    $link = URL ."pass_reset.php?tk=$guid";
                    $oMail = new cMail();
                    $html = Utils::getTxtFile(ROOT . 'content/mailing/pass/nuevo.html');
                    $html = str_replace("#PASSWORD#", $passNew, $html);
                    $html = str_replace("#NOMBRE#", $oUs["nombre"], $html);
                    $html = str_replace("#LIGA#", $link, $html);
                    $html = str_replace("#PATH#", URL , $html);
                    $subject = "NURUM GIFS: Tu nueva Contraseña";
                    return $oMail->enviaTxt($email, $subject, $html);                                                            
                }
            }            
        }
        return FALSE;        
    }
    //Confirma cambio de password capturado por usuario
    public function changePass($guid, $pass){
        $ret = FALSE;
        if(!isNoE($guid) && !isNoE($pass)){
            $dbm = new medoo();
            if($dbm->has($this->tabla, array('AND' => array("guid"=>$guid, 'estatus'=>1)))){ 
                $rowsAfec = $dbm->update($this->tabla, array("pass"=>$pass), array("guid"=>$guid));
                $oUs = $dbm->get($this->tabla,array("id","nombre","email"),array('AND' => array("guid"=>$guid,'pass'=>$pass, 'estatus'=>1))); 
                $oMail = new cMail();
                $html = Utils::getTxtFile(ROOT . 'content/mailing/pass/confirma.html');
                $html = str_replace("#NOMBRE#", $oUs["nombre"], $html);
                $html = str_replace("#PATH#", URL , $html);
                $subject = "NURUM GIFS: Cambio de Contraseña";
                $ret = $oMail->enviaTxt($oUs["email"], $subject, $html);                                                           
            }            
        }
        return $ret;       
    }       
    //Genera password aleatorio
    public static function random_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&*=+";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }         
}