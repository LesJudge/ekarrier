<?php
class SablonShow_Admin_Controller extends RimoController {
    public $_name = "HirShowReszletes";
    
    public function __construct() {
        $this->__loadModel("_Show");
        $this->__run();
    }
    
    public function __show(){
        try{
            print $this->_model->getSablon($_REQUEST["id"]);
            die();
        }catch(Exception_MYSQL $e){          
        }
    }
}
?>