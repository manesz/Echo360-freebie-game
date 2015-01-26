<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class pathClass {

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function getRoot(){
        $result = 'http://localhost:1100/project/echo360/experience';
        return  $result;
}

}//END: pathClass()
