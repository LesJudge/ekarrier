<?php
/**
 * Model
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Model {
    /**
     * @var array Item objektumokat gyűjtő tömb
     */
    public $_params = array();
    
     /**
     * @var array Item és adatbázismező megfeleltetést leíró tömb
     */
    public $_bindArray = array();
    
     /**
     * @var mixed Tábla neve
     */
    public $_tableName;
    
    /**
     * @var Adatbázis objektum
     */
    public $_DB;  
    
    /**
     * Item object hozzáadása a formhoz
     *
     * @param string $item_name
     * @uses Item
     * 
     * @return Item
     */
     
    public function addItem($item_name) {
        $this->_params[$item_name] = new Item($item_name);
        return $this->_params[$item_name];
    }
    
    public function addDB($class_name){
    	$this->_DB = Rimo::__getSingletonDatabase($class_name);
        $this->create_connect();
    }  
    
    /**
     * Adatbáziskapcsolat és adatbáziskiválasztás.
     * 
     * @uses MYSQL_DB::dbConnect()
     * @uses MYSQL_DB::dbSelectDb()
     */
    private function create_connect() {
        $this->_DB->dbConnect();
        $this->_DB->dbSelectDb();
    }
    
    /**
     * Item object lekérdezése a {@link $__params} tömbből. A $function az Exception generálásnál fontos, hogy tudjuk mely függvényben keletkezett kivétel.
     * 
     * @access public
     * @param string $item_name
     * @param string $function
     * 
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Item_error Ha nem létező elemre hivatkozunk
     * 
     * @return Item
     */
    public function getItemObject($item_name, $function = "getItemObject") {
        if (!array_key_exists($item_name, $this->_params)) {
            throw Exception_Form::Create_Error("ITEM", $function, $item_name);
        }
        return $this->_params[$item_name];
    }
    
    /**
     * Item object értékének lekérdezése a {@link $__params} tömbből. A  $function az Exception generálásnál fontos, hogy tudjuk mely függvényben keletkezett kivétel.
     * 
     * @access public
     * @param mixed $item_name
     * @param string $function
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Item_error  Ha nem létező elemre hivatkozunk
     * 
     * @return Item::$_value
     */
    public function getItemValue($item_name, $function = "getItemValue") {
        if (!array_key_exists($item_name, $this->_params)) {
            throw Exception_Form::Create_Error("ITEM", $function, $item_name);
        }
        return $this->_params[$item_name]->_value;
    }
}