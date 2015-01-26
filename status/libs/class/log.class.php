<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };

class logClass{

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function insertLog($logTitle, $logDescription, $logAction, $logActionValue){

//        echo $logTitle; echo "<br/>";
//        echo $logDescription; echo "<br/>";
//        echo $logAction; echo "<br/>";
//        echo $logActionValue; echo "<br/>";

//        exit();

        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_insertLog]('$logTitle', '$logDescription', '$logAction', '$logActionValue')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END : insertLog()

    public function getLogAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getLog]()}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array($result[1], $result[2], $result[3], $result[4], $result[5] );
        }

        return $arrResult;
    }//END : getLogAll()

}//END: userClass
?>