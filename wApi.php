<?php
require_once 'ini.php';
//OPERACIONES POST
if(Input::postHasVal('oper')){
    $outJ = new stdClass();
    $error = "";
    $success = FALSE;
    $oper = Input::post('oper');
    switch($oper){
        case 'gifupload':
            if(isset($_FILES["gifFile"])){
                if(!is_array($_FILES["gifFile"]["name"])){
                    $oMedia = new cMedia();
                    $success = $oMedia->saveGif($error);
                }else{
                    $error = "Sólo se recibe un archivo a la vez.";
                }
            }else{
                $error = "Archivo requerido.";
            }
            break;   
        case 'login':            
            $email = Input::post('mail');
            $pass = Input::post('pass');
            $oUser = new cUsuario();
            $success = $oUser->login($email, $pass);
            $error = $oUser->error;
            break; 
        case 'logout':
            cUsuario::logout();           
            $success = TRUE;
            break;        
        case 'signin':
            $oUser = new cUsuario();
            if(!$oUser->emailExists(Input::post('mail'))){
                $oUser->nombre = Input::post('name');
                $oUser->pass = md5(Input::post('pass'));
                $oUser->email = Input::post('mail');
                $success = $oUser->insert();
                if($success){
                    Session::set('CMS_id', $oUser->id);
                    $oUser->sendEmailConfirm();
                }else{
                    $error = "No se pudo almacenar la información en la Base de Datos, inténtalo de nuevo.";
                }
            }else{
                $error = "Ya existe una cuenta con ese Correo electrónico.";               
            }
            break;        
        case 'passrecov':
            $oUser = new cUsuario();
            $email = Input::post('mail');
            $success = $oUser->resetPass($email);
            $error = $oUser->error;
            break; 
        case 'passchange':
            $oUser = new cUsuario();
            $token = Input::post('token');
            $pass = Input::post('pass');
            $success = $oUser->changePass($token, $pass);
            $error = $oUser->error;
            break;        
        default:
                $error = "Operación no válida.";
            break;
    }
    //out
    header("Content-type: application/json");     
    $outJ->success = $success;
    $outJ->error = $error;
    echo json_encode($outJ);    
}

