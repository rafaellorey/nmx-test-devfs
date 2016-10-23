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
}