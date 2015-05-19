<?php
include_once "modul/kategoria/model/kategoria_Edit_Model.php";
class Munkakor_Kategoria_Admin_Edit_Model extends Kategoria_Edit_Model
{
public function __addForm() {
        parent::__addForm();
        
        $this->_bindArray["tartalom"] = "TxtTartalom";
        $this->addItem("TxtTartalom");
        
    }
        

}