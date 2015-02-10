<?php
class Nyelv_Szotar_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "nyelv_szotar";
    public $_bindArray = array("nyelv_szotar_azon" => "TxtAzon", 
                               "nyelv_szotar_szo" => "TxtSzo",
                               "modul_id" => "TxtModul",
	);

    public function __addForm(){
        $azon = $this->addItem("TxtAzon");
        $azon->_verify["string"] = true;
        //$azon->_verify["unique"] = array("table" => "nyelv_szotar", "field" => "nyelv_szotar_azon", "modify" => $this->modifyID, "DB" => $this->_DB);
        $this->addItem("TxtSzo")->_verify["string"] = true;;
        $this->addItem("TxtModul");
        /*$modul = $this->addItem("SelModul");
        $modul->_select_value = $this->getSelectValues("modul", "modul_nev", "", "",false,array(9999=>"Site elemek",9998=>"Form üzenetek"));
        $modul->_verify["select"];*/ 
    }
        
    public function __update(){    
        parent::__update(); 
    }
    
    public function __insert(){   
        parent::__insert();  
    }
}
?>