<?php
/**
 * Elem szerkesztése, új felvitele
 * 
 * @package Admin
 * @subpackage Model
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Admin_Edit_Model extends Page_Edit_Model {
    public $nyelvID;
    public $modifyID;
    public $insertID;
    
    public function __addForm(){
        $this->addItem("ChkAktiv")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
    public function __newData() {
        parent::__newData();
        $this->_params["ChkAktiv"]->_value = 1;
    }
}