<?php
class AntiXss {
    public static function antiInjectionSQL($string) {
        $string = trim($string);
        $string = strip_tags($string);
        $string = preg_replace(AntiXss::my_Sql_regcase("/(from|select|insert|delete|where|drop|drop table|show tables|#|\*|--|\\\\)/"), "", $string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = stripslashes($string);
        //$string = mysql_real_escape_string($string);
        return $string;
    }    
    public function characterDanger($value) {
        $character = str_replace("%", "", $value);
        $character = trim($character);
        $character = str_replace("|", "", $character);
        $character = str_replace("*", "", $character);
        $character = str_replace("&", "", $character);
        $character = str_replace("!", "", $character);
        $character = str_replace('"', '', $character);
        $character = str_replace("'", "", $character);
        $character = str_replace("#", "", $character);
        $character = str_replace("%", "", $character);
        $character = str_replace("/", "", $character);
        $character = str_replace("(", "", $character);
        $character = str_replace(")", "", $character);
        $character = str_replace("=", "", $character);
        $character = str_replace("?", "", $character);
        $character = str_replace("$", "", $character);
        $character = str_replace("\\", "", $character);
        $character = str_replace("¡", "", $character);
        $character = str_replace(";", "", $character);
        $character = str_replace("SELECT", "", $character);
        $character = str_replace("DROP", "", $character);
        $character = str_replace("INSERT", "", $character);
        $character = str_replace("-", "", $character);
        return $character;
    }
    //PARA ARREGLOS
    public function filterXSSmail($val) {
        $val = strip_tags($val);
        $val = htmlspecialchars($val, ENT_QUOTES);
        return $val;
    }
    public function filterXSS($val) {
        if (is_array($val)) {
            foreach ($val as $key => $value) {
                //Esta función intenta devolver un string con todos los bytes NUL y las etiquetas HTML y PHP retirados de un str dado. 
                $value = strip_tags($value);
                //Esta función es idéntica a htmlspecialchars() en todos los aspectos, excepto que con htmlentities(), todos los caracteres que tienen equivalente HTML son convertidos a esas entidades. 
                //$value = htmlentities($value,ENT_NOQUOTES,"UTF-8");
                //Limpiamos el valor
                $value = AntiXss::characterDanger($value);
                //Asignamos los valores de nuevo
                $val[$key] = $value;
            }
        } else {
            //Comenzamos la libreria de Limpieza de cadenas
            $val = strip_tags($val);
            $val = htmlspecialchars($val, ENT_QUOTES);
        }
        return $val;
    }
    function charPwd($val) {
        $val = strip_tags($val);
        $val = htmlspecialchars($val, ENT_QUOTES);
        $val = str_replace("SELECT", "", $val);
        $val = str_replace("DROP", "", $val);
        $val = str_replace("INSERT", "", $val);
        $val = str_replace("AND", "", $val);
        $val = str_replace("-", "", $val);
        return $val;
    }
    public static function my_Sql_regcase($str){
        $res = "";
        $chars = str_split($str);
        foreach($chars as $char){
            if(preg_match("/[A-Za-z]/", $char))
                $res .= "[".mb_strtoupper($char, 'UTF-8').mb_strtolower($char, 'UTF-8')."]";
            else
                $res .= $char;
        }
        return $res;
    }    
}