<?php
class Config
{
    protected static $_vars = array();
    public static function get($var)
    {
        $namespaces = explode('.', $var);
        switch (count($namespaces)) {
            case 3:
                if (isset(self::$_vars[$namespaces[0]][$namespaces[1]][$namespaces[2]])) {
                    return self::$_vars[$namespaces[0]][$namespaces[1]][$namespaces[2]];
                }
                break;
            case 2:
                if (isset(self::$_vars[$namespaces[0]][$namespaces[1]])) {
                    return self::$_vars[$namespaces[0]][$namespaces[1]];
                }
                break;
            case 1:
                if (isset(self::$_vars[$namespaces[0]])) {
                    return self::$_vars[$namespaces[0]];
                }
                break;
        }
        return NULL;
    }
    public static function set($var, $value)
    {
        $namespaces = explode('.', $var);
        switch (count($namespaces)) {
            case 3:
                self::$_vars[$namespaces[0]][$namespaces[1]][$namespaces[2]] = $value;
                break;
            case 2:
                self::$_vars[$namespaces[0]][$namespaces[1]] = $value;
                break;
            case 1:
                self::$_vars[$namespaces[0]] = $value;
                break;
        }
    }
    public static function & read($file, $force = FALSE)
    {
        if (isset(self::$_vars[$file]) && !$force) {
            return self::$_vars[$file];
        }

        self::$_vars[$file] = parse_ini_file(RES."conf/$file.ini", TRUE);
        return self::$_vars[$file];
    }

}
