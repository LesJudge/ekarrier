<?php
class HirlevelMegnyitas_Site_Controller extends RimoController {
    public $_name = "HirlevelMegnyitas";
    
    public function __construct() {
        $this->__loadModel("_Megnyitas");
        $this->__run();
    }
    
    public function __show(){
        try{
            $this->_model->megnyitasSzamlalo($_REQUEST["hirlevel_id"], $_REQUEST["user_id"]);
            $this->_model->updateHirlevel($_REQUEST["hirlevel_id"]);
        }
        catch(Exception $e){
        }
        header('Content-Type: image/jpeg');
        echo file_get_contents("modul/hirlevel/images/blank.gif");
        die();
    }
}
?>