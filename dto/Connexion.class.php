<?php
class Database
{
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
     
       if ( null == self::$cont )
       {     
        try
        {
            self::$cont =  new PDO('mysql:host=localhost;dbname=comgocom;charset=utf8','root', 'arthuretmax2020');  
                     
           // self::$cont =  new PDO('mysql:host=localhost;dbname=essaiLogin;charset=utf8','essaiLogin', 'essaiLogin'); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
