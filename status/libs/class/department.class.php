<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };

class departmentClass{

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function getDepartmentAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getDepartmentAll]()}";
        $query = sqlsrv_query($conn, $sql);
        $num = 0;
        while($result = sqlsrv_fetch_array($query)){
            $arrResult[] = array( "id"=>$result[0], "title"=>$result[1], "description"=>$result[2], );
            $num++;
        }
        return $arrResult;
    }

}//END: departmentClass
?>