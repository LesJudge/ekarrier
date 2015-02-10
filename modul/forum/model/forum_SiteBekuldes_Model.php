<?php
class Forum_SiteBekuldes_Model extends Page_Edit_Model {
    public $_tableName = "forum";
    public $_bindArray = array("forum_nyelv" => "Nyelv", 
                               "forum_bekuldo" => "TxtBekuldo", 
                               "forum_targy" => "TxtTargy",
                               "forum_tartalom" => "TxtTartalom",
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("Nyelv");                
        $this->addItem("TxtBekuldo")->_verify["string"] = true;
        $this->addItem("TxtTargy")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("SessCaptcha");
        
		$captcha = $this->addItem("TxtCaptcha");
		$captcha->_verify["string"] = true;
        $captcha->_verify["equalToCaptcha"] = $this->_params["SessCaptcha"];
    }   
    
    public function __insert(){
        //$this->_params["TxtTartalom"]->_value = strip_tags($this->_params["TxtTartalom"]->_value);
    	parent::__insert(",forum_bekuldve_date=now()");    
    }
}
?>