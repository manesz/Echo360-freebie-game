<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };

class userClass{

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function getUserProfileAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getUserProfileAll]()}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $num = 0;
        while($result = sqlsrv_fetch_array($query)){
//            var_dump($result);
            $arrResult[] = array(
                "id"=>$result['id'],
                "userFName"=>$result['firstname'],
                "userLName"=>$result['surname'],
                "userEmail"=>$result['email'],
                "userMobile"=>$result['mobile'],
                "userDepartmentId"=>$result['department_id'],
                "userPositionId"=>$result['position_id'],
                "userPermissionId"=>$result['permission_id'],
                "userDepartment"=>$result['department'],
                "userPosition"=>$result['position'],
                "userPermission"=>$result['permission'],
                "userPasswordMd5"=>$result['pass_md5'],
                "userCreateDateTime"=>$result['create_datetime'],
                "userUpdateDateTime"=>$result['update_datetime'],
                "userCreateBy"=>$result['create_by'],
                "userUpdateBy"=>$result['update_by'],
                "userPublish"=>$result['publish']
            );
            $num++;
        }
//        var_dump($arrResult);exit();
        return $arrResult;
    }//END: getAllUserProfile()

    public function getRowUserProfile($username = null, $password = null){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getRowUserProfile]('$username', '$password')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getRowUserProfile()

    public function getRowUserProfileById($id = null){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getRowUserProfileById]($id)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getRowUserProfileById()

    public function insertUserProfile($userProfile = null){
        $conn = $this->connClass->sqlsrv_connection();
//        var_dump($userProfile);
        $userFName = $userProfile['userFName'];
        $userLName = $userProfile['userLName'];
        $userEmail = $userProfile['userEmail'];
        $userMobile = $userProfile['userMobile'];
        $userDepartment = intval($userProfile['userDepartment']);
        $userPosition = intval($userProfile['userPosition']);
        $userPermission = intval($userProfile['userPermission']);
        $userPasswordMd5 = $userProfile['userPasswordMd5'];
        $userPasswordFull = $userProfile['userPasswordFull'];

        $sql = "{CALL [RSS_insertUserProfile]('$userFName' , '$userLName', '$userEmail', '$userMobile', $userDepartment, $userPosition, $userPermission, '$userPasswordMd5', '$userPasswordFull')}";

        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        return $query;
    }//END: insertUser()

    public function updateUserProfile($userProfile = null){
        $conn = $this->connClass->sqlsrv_connection();

        $userId = $userProfile['userId'];
        $userFName = $userProfile['userFName'];
        $userLName = $userProfile['userLName'];
        $userEmail = $userProfile['userEmail'];
        $userMobile = $userProfile['userMobile'];
        $userDepartment = intval($userProfile['userDepartment']);
        $userPosition = intval($userProfile['userPosition']);
        $userPermission = intval($userProfile['userPermission']);
        $userPasswordMd5 = $userProfile['userPasswordMd5'];
        $userPasswordFull = $userProfile['userPasswordFull'];

        $sql = 'UPDATE [dbo].[rss_user] SET ';
        if( !empty($userFName) ): $sql.= "[firstname] = '".$userFName."'" ; endif;
        if( !empty($userLName) ): $sql.= ",[surname] = '".$userLName."'" ; endif;
        if( !empty($userEmail) ): $sql.= ",[email] = '".$userEmail."'"; endif;
        if( !empty($userMobile) ): $sql.= ",[mobile] = '".$userMobile."'"; endif;
        if( !empty($userDepartment) ): $sql.= ",[department_id] = ".$userDepartment.""; endif;
        if( !empty($userPosition) ): $sql.= ",[position_id] = ".$userPosition.""; endif;
        if( !empty($userPermission) ): $sql.= ",[permission_id] = ".$userPermission.""; endif;
        if( !empty($userPasswordMd5) ): $sql.= ",[pass_md5] = '".$userPasswordMd5."'"; endif;
        if( !empty($userPasswordFull) ): $sql.= ",[pass_full] = '".$userPasswordFull."'"; endif;
        $sql.= ",[update_datetime] = '".date('Y-m-d')."'";
        $sql.= ",[update_by] = '".$_SESSION['user_id']."'";
        $sql.= " WHERE [id]=".$userId;

        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        return $query;
    }

    public function updateInterActProfile($accountId = null){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_CAMDESDB_SpUpdateInteractProfile]($accountId)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        return $query;
    }//END : updateInterActProfile()

}//END: userClass
?>