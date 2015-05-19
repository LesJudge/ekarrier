<?php
include_once "modul/kategoria/model/kategoria_Edit_Model.php";
class Hir_Kategoria_Admin_Edit_Model extends Kategoria_Edit_Model
{
public function __addForm() {
        parent::__addForm();
        $this->_bindArray["kategoria_ma"] = "ChkMunkaAdo";
        $this->addItem("ChkMunkaAdo")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        
    }
        

}