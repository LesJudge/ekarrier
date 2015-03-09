<?php
/**
 * Event
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Event {
    /**
     * @var string Egyedi azonosító
     */
    public $_name;
    /**
     * @var array $_REQUEST vagy $_GET  vagy $_POST  vagy $_SESSION  vagy $_FILE
     */
    public $_action_type=null;
    /**
     * @var mixed Érték 
     */
    public $_value=null;
    /**
     * Név beállítása
     * 
     * @param string $item_name
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
        return array("name" => $added_name . $this->_name, "value" => $this->_value);
    }
}