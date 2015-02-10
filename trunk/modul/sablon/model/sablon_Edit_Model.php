<?php
class sablon_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "sablon";
    public $_bindArray = array("sablon_nev" => "TxtNev", 
                               "sablon_tartalom" => "TxtTartalom",
                               "sablon_tipus" => "TxtTipus"
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtNev")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("TxtTipus")->_value = Rimo::$_config->SABLON_TYPE;
    }
}
?>