<?php
class Hirlevel_Usercsoport_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hirlevel_csoport";
    public $_bindArray = array("hirlevel_csoport_nev" => "TxtNev", 
                               "hirlevel_csoport_nyelv_id" => "SelKapcsolatNyelv"
    );

    public function __addForm(){
        $this->addItem("TxtNev")->_verify["string"] = true;
        $kapcsolat_nyelve = $this->addItem("SelKapcsolatNyelv");
        $kapcsolat_nyelve->_select_value = $this->getSelectValues("nyelv","nyelv_nev","","",false);
        $kapcsolat_nyelve->_value = 1;
    }
      
    public function __newData(){
        parent::__newData();
        $this->_params["SelKapcsolatNyelv"]->_value = 1;
    }
    
    public function __update(){
        parent::__update();
    }
    
    public function __insert(){
        parent::__insert();  
    }
}
?>