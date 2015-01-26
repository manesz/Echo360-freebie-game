<?php
class sessionClass{

    function insertUserSession($id, $name, $department, $position, $permission){
        $_SESSION['id'] = session_id();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_department'] = $department[0];
        $_SESSION['user_position'] = $position[0];
        $_SESSION['user_permission'] = $permission[0];
    }//END: userSession

    function destroySession(){
        if( session_destroy() == TRUE ){ header('Location: signin.php'); } else { echo "<h1>Session isn't destroy</h1>"; };
    }

    function isSignin(){
        $string = 'please signin system before.';
        if(empty($_SESSION['id'])){header('Location: signin.php?alert='.$string.'');exit();}
    }

}//END: session Class
?>