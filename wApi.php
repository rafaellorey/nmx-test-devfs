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

