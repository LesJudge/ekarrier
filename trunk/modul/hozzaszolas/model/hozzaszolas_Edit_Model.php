<?php
class hozzaszolas_Edit_Model extends Admin_Edit_Model {
	public $_bindArray = array("hozzaszolas_nyelv" => "SelNyelv", 
                               "hozzaszolas_bekuldo" => "TxtBekuldo", 
                               "hozzaszolas_tartalom" => "TxtTartalom"
    );

    public function __addForm(){
    	$this->_bindArray[$this->_tableName."_aktiv"] = "ChkAktiv";
        parent::__addForm();
        $nyelv = $this->addItem("SelNyelv");
        $nyelv->_verify["select"] = true;
        $nyelv->_select_value = $this->getSelectValues("nyelv", "nyelv_nev", "", "", false);                
        $this->addItem("TxtBekuldo")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
    }   
}
?>