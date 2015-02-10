<?php
class Orszag_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "orszag";
    public $_bindArray = array("orszag_rovidites" => "TxtRovidites",
                               "orszag_nev" => "TxtNev"
    );

    public function __addForm(){
        $rovidites = $this->addItem("TxtRovidites");
        $rovidites->_verify["string"] = true;
        $rovidites->_verify["unique"] = array("table" => "orszag", "field" => "orszag_rovidites", "modify" => $this->modifyID, "DB" => $this->_DB);
        $this->addItem("TxtNev")->_verify["string"] = true; 
    }
}
?>