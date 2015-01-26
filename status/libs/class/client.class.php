<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class clientClass {

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function getClientAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [EXP_getClientAll]}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0] // Company Name
                , $result[1] // Address
                , $result[2] // Email
                , $result[3] // Tel/Mobile
                , $result[4] // Status
                , $result[5] // Note
                , $result[6] // Username
                , $result[7] // Password
//            , $result[8]->format('Y-m-d') // Create datetime
//            , $result[9]->format('Y-m-d') // Update datetime
            );
        endwhile;

        return $arrResult;
    }//END: getClientAll()

}//END : clientClass()