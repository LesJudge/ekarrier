<?php
/**
 * Item
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Item {
    /**
     * @var string Egyedi azonosító
     */
     public $_name;
     /**
     * @var string Title
     */
     public $_title;
     /**
     * @var string Hiba esetén a Verify objekt definiált hibájához hozzáfűzi 
     */   
     public $_error_message;
     /**
     * @var string Tartalmazza az elem hibájának szövegét (Verify $error.$_error_message).  
     */ 
     public $_error=null;
     /**
     * @var mixed Érték 
     */
     public $_value;
     /**
     * @var array Választható értékek 
     */
     public $_select_value;
     /**
     * @var array $_REQUEST|$_GET|$_POST|$_SESSION|$_FILE
     */
     public $_action_type=null;
     /**
     * @var string A vizsgálat típusa. {@link Verify::$validate}
     */
     public $_verify;
        
     /**
     * @var boolean true|false. Vizsgálja-e azt hogy csak olyan értéket adhatunk az elemnek, amely szerepel a $_select_value tömbben.
     * {@link RimoController::__setParamValue()}
     */
     public $_verify_multiple_values = false;
    /**
     * Név beállítása
     * 
     * @param mixed $item_name
     */
    public function __construct($item_name) {
         $this->_name = $item_name;
    }
    
    /**
     * Template változó (tömb) generálás
     * 
     * @return array
     */
    public function __show($added_name) {
    	if(!is_array($this->_value)) $this->_value = htmlspecialchars($this->_value);
        return array("name" => $added_name . $this->_name, "values" => $this->_select_value,
            "activ" => $this->_value, "error" => $this->_error, "title" => $this->_title);
    }
}