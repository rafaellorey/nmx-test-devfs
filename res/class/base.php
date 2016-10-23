<?php
class base {
    public $id;
    public $tabla;
    public $error;
    
    public function __construct() {
        $argv = func_get_args();
        $this->id = NULL;
        $this->tabla = $argv[0];
        switch( func_num_args() ) {
            case 2:
                self::__construct1($argv[1]);
                break;
        }
    }
    public function __construct1($aVals=array())
    {
        $this->loadFromArray($aVals);
    }

    public function loadFromArray($result){
        if (is_array($result)) {
            foreach ($result as $k => $r) {                
                if (!is_numeric($k)) {
                    $this->$k = stripslashes($r);                                           
                }
            }
        }   
    }    
    public function loadFromPost($exclude = array()){
        $exclude = array_merge(array("tabla","error"),$exclude);
        $fields = Utils::removeKeys(get_object_vars($this), $exclude);
        foreach ($fields as $k => $r) {
            if (Input::postHasVal($k)) {
                $this->$k = Input::post($k);
            }
            else{$this->$k = NULL;}
        }
        return empty($this->error);
    }

    public function loadFromPut($exclude = array()){
        $error = false;
        $request_params = array();
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
        }
        $fields = Utils::removeKeys(get_object_vars($this), $exclude);
        foreach ($fields as $k => $r) {
            if (!isset($request_params[$k]) || strlen(trim($request_params[$k])) <= 0) {
                $error = true;
            }else{
                $this->$k = $request_params[$k];
            }
        }
        return empty($this->error);
    }
    //**** CRUD ****
    //GET
    public function get($id){
        if(is_numeric($id))
        {
            $dbm = new medoo();
            $oUs = $dbm->get($this->tabla,"*",array('id' => $id));        
            if(!empty($oUs)){                     
                $this->loadFromArray($oUs);       
            } 
        }
        return (!empty($this->estatus));
    }       
    //CREA-ACTUALIZA
    public function insertUpdate(){
        if(!empty($this->id)){
            return $this->update();
        }else{
            return $this->insert();
        }
    }    
    //ACTUALIZA
    public function update() {
        if(!empty($this->id)){
            $dbm = new medoo();
            $data = Utils::removeKeys(get_object_vars($this), $this->getExclude());  
            //OPERA DB
            $dbm->update($this->tabla, $data, array('id' => $this->id));  
            //echo var_dump($dbm->last_query());
            //exit(0);
            $this->error = $dbm->error();
            //echo var_dump($dbm->error());
            //exit(0);            
            return TRUE; //isNoE($this->error);            
        }else{
            $this->error = "Faltan datos requeridos.";
            return FALSE;
        }
    }  
    //CREA
    public function insert() {
        if ($this->chkRequired())
        {
            $dbm = new medoo();
            $data = Utils::removeKeys(get_object_vars($this), $this->getExclude());
            $this->id = $dbm->insert($this->tabla, $data);                             
            $this->error = $dbm->error();
            return ($this->id > 0);
        }else{ 
            $this->error = "Faltan datos requeridos.";
            return FALSE;
        }
    }      
    //CAMPOS REQUERIDOS PARA EL INSERT
    public function chkRequired(){
        return TRUE;
    }
    //CAMPOS QUE SE EXCLUYEN DE OPERACIONES DE INSERT / UPDATE
    public function getExclude(){
        return array('id','tabla','error','login_date','create_date','orden','estatus');
    }      
}