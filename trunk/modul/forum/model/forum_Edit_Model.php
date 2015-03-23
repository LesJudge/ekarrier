<?php
class Forum_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "forum";
    public $_bindArray = array("forum_nyelv" => "SelNyelv", 
                               "forum_bekuldo" => "TxtBekuldo", 
                               "forum_targy" => "TxtTargy",
                               "forum_tartalom" => "TxtTartalom",
                               "forum_aktiv" => "ChkAktiv",
                               "checked" => "ChkChecked"
    );

    public function __addForm(){
        parent::__addForm();
        $nyelv = $this->addItem("SelNyelv");
        $nyelv->_verify["select"] = true;
        $nyelv->_select_value = $this->getSelectValues("nyelv", "nyelv_nev", "", "", false);                
        $this->addItem("TxtBekuldo")->_verify["string"] = true;
        $this->addItem("TxtTargy")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("ChkChecked")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }   
    public function __insert($sets="") {
        parent::__insert(",forum_bekuldve_date=now() {$sets}");
    }
}
?>