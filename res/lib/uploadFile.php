<?php
class uploadFile
{
    protected $_name;
    protected $_allowScripts = FALSE;
    protected $_minSize = NULL;
    protected $_maxSize = NULL;
    protected $_types = NULL;
    protected $_extensions = NULL;
    protected $_overwrite = TRUE;
    protected $_checkAni = FALSE;
    protected $_path;   
    public $name;
    public $error;

    public function __construct($path,$name,$types="",$extensions="",$maxSize="150m",$checkAni = FALSE)
    {
        //$types="image/gif|image/jpeg|image/jpg|image/png",$extensions="gif|jpg|jpeg|png"
        $this->_name = $name;
        $this->_path = $path;
        if(!empty($types))
            $this->setTypes($types);
        if(!empty($extensions))
            $this->setExtensions($extensions);
        $this->setMaxSize($maxSize);
        $this->setCheckAni($checkAni);
    }
    public function setCheckAni($checkAni)
    {
        $this->_checkAni = trim($checkAni);
    }
    public function setMinSize($size)
    {
        $this->_minSize = trim($size);
    }
    public function setMaxSize($size)
    {
        $this->_maxSize = trim($size);
    }
    public function setTypes($value)
    {
        if (!is_array($value))
            $value = explode('|', $value);
        $this->_types = $value;
    }
    public function setExtensions($value)
    {
        if (!is_array($value))
            $value = explode('|', $value);
        $this->_extensions = $value;
    }
    public function save($name = NULL)
    {
        if (!$this->isUploaded()) {
            return FALSE;
        }
        if (!$name) {
            $name = $_FILES[$this->_name]['name'];
        } else {
            $name = $name . $this->_getExtension();
        }
        // Guarda el archivo
        if ($this->_overwrite($name) && $this->_validates() && $this->_saveFile($name)) {
            $this->name = $name;
            return TRUE;
        }
        return FALSE;
    }
    public function isUploaded()
    {
        // Verifica si ha ocurrido un error al subir
        if ($_FILES[$this->_name]['error'] > 0) {
            $error = array(
                UPLOAD_ERR_INI_SIZE => 'el archivo excede el tamaño máximo (' . ini_get('upload_max_filesize') . 'b) permitido por el servidor',
                UPLOAD_ERR_FORM_SIZE => 'el archivo excede el tamaño máximo permitido',
                UPLOAD_ERR_PARTIAL => 'se ha subido el archivo parcialmente',
                UPLOAD_ERR_NO_FILE => 'no se ha subido ningún archivo',
                UPLOAD_ERR_NO_TMP_DIR => 'no se encuentra el directorio de archivos temporales',
                UPLOAD_ERR_CANT_WRITE => 'falló al escribir el archivo en disco',
                UPLOAD_ERR_EXTENSION => 'una extensión de php ha detenido la subida del archivo'
            );
            $this->error = $error[$_FILES[$this->_name]['error']];
            return FALSE;
        }
        return TRUE;
    }
    protected function _validates()
    {
        // Denegar subir archivos de scripts ejecutables
        if (!$this->_allowScripts && preg_match('/\.(php|phtml|php3|php4|js|shtml|pl|py|rb|rhtml)$/i', $_FILES[$this->_name]['name'])) {
            $this->error = 'no esta permitido subir scripts ejecutables';
            return FALSE;
        }

        // Valida el tipo de archivo
        if ($this->_types !== NULL && !$this->_validatesTypes()) {
            $this->error = 'el tipo de archivo no es válido';
            return FALSE;
        }

        // Valida extensión del archivo
        if ($this->_extensions !== NULL && !preg_match('/\.(' . implode('|', $this->_extensions) . ')$/i', $_FILES[$this->_name]['name'])) {
            $this->error = 'la extensión del archivo no es válida';
            return FALSE;
        }

        // Verifica si es superior al tamaño indicado
        if ($this->_maxSize !== NULL && $_FILES[$this->_name]['size'] > $this->_toBytes($this->_maxSize)) {
            $this->error = "no se admiten archivos superiores a $this->_maxSize" . 'b';
            return FALSE;
        }

        // Verifica si es inferior al tamaño indicado
        if ($this->_minSize !== NULL && $_FILES[$this->_name]['size'] < $this->_toBytes($this->_minSize)) {
            $this->error = "no se admiten archivos inferiores a $this->_minSize" . 'b';
            return FALSE;
        }
        
        //verifica si es un gif animado
        if($this->_checkAni){
            $res = $this->is_animated();
            if(!$res){
                $this->error = "el archivo no es animado.";
            }
            return $res;
        }
        
        return TRUE;
    }

    protected function _validatesTypes()
    {
        return in_array($_FILES[$this->_name]['type'], $this->_types);
    }
    protected function _getExtension()
    {
        if($ext = pathinfo($_FILES[$this->_name]['name'], PATHINFO_EXTENSION)){
            return '.'. $ext;
        }
        return NULL;
    }
    protected function _overwrite($name)
    {
        if ($this->_overwrite) {
            return TRUE;
        }
        if (file_exists("$this->_path/$name")) {
            $this->error = 'ya existe este fichero. Y no se permite reescribirlo';
            return FALSE;
        }
        return TRUE;
    }
    protected function _toBytes($size)
    {
        if (is_int($size) || ctype_digit($size)) {
            return (int) $size;
        }

        $tipo = strtolower(substr($size, -1));
        $size = (int) $size;

        switch ($tipo) {
            case 'g': //Gigabytes
                $size *= 1073741824;
                break;
            case 'm': //Megabytes
                $size *= 1048576;
                break;
            case 'k': //Kilobytes
                $size *= 1024;
                break;
            default :
                $size = -1;
                $this->error = 'el tamaño debe ser un int para bytes, o un string terminado con K, M o G. Ej: 30k , 2M, 2G';
        }

        return $size;
    }
    protected function _saveFile($name){
        return move_uploaded_file($_FILES[$this->_name]['tmp_name'], "$this->_path/$name");
    }
    protected function is_animated() {
        if(!($fh = @fopen($_FILES[$this->_name]['tmp_name'], 'rb')))
            return false;
        $count = 0;
        //an animated gif contains multiple "frames", with each frame having a
        //header made up of:
        // * a static 4-byte sequence (\x00\x21\xF9\x04)
        // * 4 variable bytes
        // * a static 2-byte sequence (\x00\x2C)

        // We read through the file til we reach the end of the file, or we've found
        // at least 2 frame headers
        while(!feof($fh) && $count < 2) {
            $chunk = fread($fh, 1024 * 100); //read 100kb at a time
            $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk, $matches);
        }

        fclose($fh);
        return $count > 1;
    }
}
