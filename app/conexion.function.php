<?php

require_once 'minidesk.conf.php';

error_reporting(E_ALL ^ E_NOTICE);
class Conexion
{
    private static $instancia;
    private $dbh;
 
    private function __construct()
    {
        try {

            $host = HOST;
            $db =   DBDATA;
            $user = DBUSER;
            $pwd =  DBPASS;
            $this->dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pwd);
            $this->dbh->exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage();

            die();
        }
    }

    public function prepare($sql)
    {

        return $this->dbh->prepare($sql);

    }
 
    public static function singleton_conexion()
    {

        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;

        }

        return self::$instancia;
        
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }


     // Evita que el objeto se pueda clonar
    public function __clone()
    {

        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);

    }
}