<?php
class connectionClass {

    var $lastError; // Holds the last error

    var $hostname; // MySQL Hostname
    var $username; // MySQL Username
    var $password; // MySQL Password
    var $database; // MySQL Database

    public function __construct(){
        $database = 'RSS-DEV';
        $username = 'sa';
        $password = 'c43w13@2013!';
        $hostname = '10.10.120.112';
//        $port = 3306;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
//        $this->hostname = $hostname . ':' . $port;
        $this->hostname = $hostname;
    }

// *******************************************************************************************   connect database 10.10.120.112function

    public function sqlsrv_connection(){
        //$serverName = "10.10.120.112"; //serverName\instanceName
        $connectionInfo = array(
            "Database"=>$this->database
            , "UID"=>$this->username
            , "PWD"=>$this->password
            , "CharacterSet" => "UTF-8"
        );
        $conn = sqlsrv_connect( $this->hostname, $connectionInfo);
        return $conn;
    }//END: sqlsrv_connection

// *******************************************************************************************   offer function list



// *******************************************************************************************   user function list

}
?>