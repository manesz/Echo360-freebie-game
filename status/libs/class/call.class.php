<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class callClass {

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }//END: __construct()

    public function getCallStat($backDate){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_viewCallStat]($backDate)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                $result[0]//Call Date
                , $result[1]// Call In
                , $result[2]// Imp
                , $result[3]// B Connected
                , $result[4]// Call Duration
                , $result[5]// Call Duration Round Up
                , $result[6]// Tale Time
                , $result[7] = $result[2]/$result[1] // Imp percent
                , $result[8] = $result[3]/$result[1] // Bconnected percent
                , $result[9] = $result[4]/$result[1] // Avg Call Duration
                , $result[10] = $result[5]/$result[1] // Avg Air Time
                , $result[11] = $result[6]/$result[1] // Avg Air Time2
            );
        }
        return $arrResult;
    }//END: getCallStat()

    public function getContactHistory(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getContactHistory_CAMDESDB]}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                $result[0]//Running Number
                , $result[1]// Customer ID
                , $result[2]// Offer Code
                , $result[3]// Event Type
                , $result[4]// Contact Date
                , $result[5]// Offer Limit
                , $result[6]// Subr Offer Limit
            );
        }
        return $arrResult;
    }//END: getContactHistory();

}