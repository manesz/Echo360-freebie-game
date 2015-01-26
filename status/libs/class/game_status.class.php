<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class gameStatusClass {
    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }//END: __construct()

    public function getStatusAction(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [SP_GAME_getStatusAction]}";
        sqlsrv_query($conn, 'SET NAMES utf8');
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while($result = sqlsrv_fetch_array($query)):
            $arrResult[] = array(
                $result[0] // id
                , $result[1] // description
            );
        endwhile;
        return $arrResult;
    }// getProfileInfo()

    public function getStatusFeeling(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [SP_GAME_getStatusFeeling]}";
        sqlsrv_query($conn, 'SET NAMES utf8');
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while($result = sqlsrv_fetch_array($query)):
            $arrResult[] = array(
                $result[0] // id
                , $result[1] // description
            );
        endwhile;
        return $arrResult;
    }// getStatusFeeling()

    public function getStatusPerson(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [SP_GAME_getStatusPerson]}";
        sqlsrv_query($conn, 'SET NAMES utf8');
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while($result = sqlsrv_fetch_array($query)):
            $arrResult[] = array(
                $result[0] // id
                , $result[1] // description
            );
        endwhile;
        return $arrResult;
    }// getStatusPerson()

    public function getStatusPlace(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [SP_GAME_getStatusPlace]}";
        sqlsrv_query($conn, 'SET NAMES utf8');
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while($result = sqlsrv_fetch_array($query)):
            $arrResult[] = array(
                $result[0] // id
                , $result[1] // description
            );
        endwhile;
        return $arrResult;
    }// getStatusPlace()


}
?>