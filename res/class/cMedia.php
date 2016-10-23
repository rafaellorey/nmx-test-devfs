<?php
class cMedia extends base {
    public $archivo;
    public $create_date;
    public $estatus;
    public function __construct()
    {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                parent::__construct("media");
                break;
            case 1:
                parent::__construct("media",$argv[0]);
        }
    }
    //**** OVERRIDE ***
    public function chkRequired(){
        return (!isNoE($this->archivo));
    }      
    //**** BL ***
    public function saveGif(&$error){
        $error='';
        if(!empty($_FILES["gifFile"]["name"]))
        {           
            $uGif = new uploadFile(ROOT."content/gifs", "gifFile", "image/gif", "gif", "2m", TRUE);
            $nameUnik = date("dmyhis");
            if($uGif->save($nameUnik)){
                $this->archivo = "content/gifs/".$uGif->name;
                $opRes = $this->insert();
                $error = $this->error;
                return $opRes;
            }else{
                $error = $uGif->error;
                return FALSE;
            }                
        }          
    }    
    public function upStatus($id,$stat){
        if(is_numeric($id) && $stat >=0 && $stat <= 1){
            $dbm = new medoo();
            if($dbm->has($this->tabla, array('id' => $id))){ 
                $rowsAfec = $dbm->update($this->tabla, array("estatus"=>$stat), array("id"=>$id));                
                return ($rowsAfec > 0);                
            }else{
                $this->error = "Datos incorrectos, verifique.";
            }    
        }else{
            $this->error = "Faltan datos requeridos.";
        }
    }
}