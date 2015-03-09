<?php
/**
 * Verify
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 * 
 * @todo Nem br-tag-eket kellene betenni az alap és a hozzáadott error közé
 */
class Verify {
    /**
     * @var Item Vizsgálni kívánt objektum
     */
    private $verify_object;
    /**
     * @var array JQUERY validate scripthez a php -- validator megfelelőség.
     */
    public static $validate = array(
                             "string" => "required",
                             "required" => "",
                             "number" => "number",
                             "select" => "required",
                             "multiSelect" => "required",
                             "file" => "required",
                             "maxlength" => "maxlength",
                             "maxsize" => "",
                             "date" => "date",
                             "datetime" => "datetime",
                             "datetimegreaterthan" => "",
                             "dategreaterthan" => "dategreaterthan",
                             "unique" => "",
                             "equalTo" => "equalTo",
                             "equalToCaptcha" => "",
                             "email" => "email",
                             "picture" => "accept",
                             "keywords" => "keywords",
                             "notNumber" => "notNumber",
                             "pattern" => "pattern",
                             "fileExists" => "fileExists",
                             "isDir" => "isDir",
                             "tableExists" => "tableExists",
    );
    /**
     * Megvizsgálja, hogy az adott input értéke nem szám-e.
     * @return mixed (false|string)
     * @author Petró Balázs Máté <balazs@uniweb.hu>
     */
    public function notNumber() {
        if(is_numeric($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_notNumber"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Megvizsgálja, hogy az adott input értéke illik-e a paraméterül adott reguláris kifejezésre.
     * @param string $data => A reguláris kifejezés, amire illenie kell a mintának. 
     * @return mixed (false|string)
     * @author Petró Balázs Máté <balazs@uniweb.hu>
     */
    public function pattern($data){
        if (!isset($data['allowEmpty'])) {
            $data['allowEmpty'] = false;
        }
        if($data['allowEmpty'] === false && preg_match($data['pattern'], $this->verify_object->_value) != $data['value']){
            $message = isset($data['message']) ? $data['message'] : Rimo::$_config->FORM_ERROR['form_mess_pattern'];
            return $message.' '.$this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott fájl már létezik-e.
     * @param array $data
     * @return mixed (false|string)
     * @author Petró Balázs Máté <balazs@uniweb.hu>
     */
    public function fileExists($data){
        if(file_exists($data['fileRoute'].$this->verify_object->_value) != $data['value']){
            $message = isset($data['message']) ? $data['message'] : Rimo::$_config->FORM_ERROR['form_mess_fileExists'];
            return $message.' '.$this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott fájl könyvtár-e
     * @param array $data
     * @return mixed (false|string)
     * @author Petró Balázs Máté <balazs@uniweb.hu>
     */
    public function isDir($data){
        if(is_dir($data['dirRoute'].$this->verify_object->_value) != $data['value']){
            $message = isset($data['message']) ? $data['message'] : Rimo::$_config->FORM_ERROR['form_mess_isDir'];
            return $message.' '.$this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Megvizsgálja, hogy létezik-e a tábla az adatbázisban.
     * @param object $db => Adatbázis objektum
     * @return mixed (false|string)
     * @author Petró Balázs Máté <balazs@uniweb.hu>
     */
    public function tableExists(&$db){
        try{
            $query = "SHOW TABLES LIKE '".mysql_real_escape_string($this->verify_object->_value)."'";
            $db->prepare($query)->query_select()->query_result_array();
            return Rimo::$_config->FORM_ERROR['form_mess_tableExists'].' '.$this->verify_object->_error;
        }
        catch(Exception_MYSQL_Null_Rows $e){
            return $this->verify_object->_error;
        }
        catch(Exception_MYSQL $e){
            return $e->getMessage();
        }
        return $this->verify_object->_error;
    }
    /**
     * Item object beállítása, amelyen a vizsgálat végrehajtódik
     * 
     * @param Item $verify_object
     */
    public function setObject(Item &$verify_object) {
        $this->verify_object = $verify_object;		        
    }
     /**
     * Kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function required() {
        if (empty($this->verify_object->_value) AND !is_numeric($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_kotelezo"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function keywords() {
        if (empty($this->verify_object->_value) AND !is_numeric($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_kotelezo"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * String kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function string() {    	
        if (empty($this->verify_object->_value) AND !is_numeric($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_kotelezo"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Szám kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function number() {
        if (!is_numeric($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_number"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }  
    /**
     * Select kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function select() {
        if (!isset($this->verify_object->_select_value[$this->verify_object->_value]) or !$this->verify_object->_value) {
            return Rimo::$_config->FORM_ERROR["form_mess_select"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }   
    /**
     * MultiSelect kötelezőség vizsgálat
     * 
     * @return error|object error
     */
    public function multiSelect() {
        if (!count($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_select"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * File kötelezőség vizsgálat.
     * 
     * 
     * @return error|object error
     */
    public function file() {
        if (empty($this->verify_object->_value["name"]) OR !is_uploaded_file($this->verify_object->_value["tmp_name"])) {
            return Rimo::$_config->FORM_ERROR["form_mess_file"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    
    /**
     * Csak képet tölthet fel.
     * 
     * 
     * @return error|object error
     */
    public function picture(){
        if($this->verify_object->_value["error"]==4 OR empty($this->verify_object->_value))
            return $this->verify_object->_error;
        $file_infos = getimagesize($this->verify_object->_value["tmp_name"]);
        $mime_type = $file_infos['mime'];
        if (!preg_match ("/jpg|jpeg|gif|png/i", $mime_type)) {
            return Rimo::$_config->FORM_ERROR["form_mess_kep"] . " " . $this->verify_object->_error;
        }
        if (empty($this->verify_object->_value["name"])) {
            return Rimo::$_config->FORM_ERROR["form_mess_kep"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Maximum string hossz vizsgálat.
     * 
     * @param int $maxlength
     * @return  error|object error
     */
    public function maxlength($maxlength){
        if (strlen($this->verify_object->_value)>$maxlength) {
            return Rimo::$_config->FORM_ERROR["form_mess_maxchar_start"].$maxlength.Rimo::$_config->FORM_ERROR["form_mess_maxchar_end"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Maximum file méret vizsgálat. Figyelembe veszi a {@link ini_get('upload_max_filesize')} méretet is.
     * 
     * @param mixed $maxsize
     * @return  error|object error
     */
    public function maxsize($maxsize){
        if ($this->verify_object->_value["size"]>$maxsize+1) {
            return Rimo::$_config->FORM_ERROR["form_mess_maxfile_start"].Create::byte_converter($maxsize).Rimo::$_config->FORM_ERROR["form_mess_maxfile_end"] . " " . $this->verify_object->_error;
        }
        elseif($this->verify_object->_value["error"]==1){
            return Rimo::$_config->FORM_ERROR["form_mess_maxfile_start"].ini_get("upload_max_filesize").Rimo::$_config->FORM_ERROR["form_mess_maxfile_end"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Kezdő dátum nem lehet nagyobb mint a vég dátum. Percet is figyelembe veszi
     * 
     * @param Item $item
     * @return  error|object error
     */
    public function datetimegreaterthan($item){
        if (strtotime($this->verify_object->_value)<strtotime($item->_value) AND !empty($this->verify_object->_value) AND strpos($this->verify_object->_value,"0000")===false) {
            return Rimo::$_config->FORM_ERROR["form_mess_datetimegreaterthan"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Kezdő dátum nem lehet nagyobb mint a vég dátum.
     * 
     * @param Item $item
     * @return  error|object error
     */
    public function dategreaterthan($item){
        if (strtotime($this->verify_object->_value)<strtotime($item->_value) AND strtotime($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_datetimegreaterthan"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Dátum + idő ellenőrzés
     * 
     * @return  error|object error
     */
    public function datetime(){
        if (strtotime($this->verify_object->_value)===false) {
            return Rimo::$_config->FORM_ERROR["form_mess_datetime"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Dátum ellenőrzés
     * 
     * @return  error|object error
     */
    public function date(){
        if (strtotime($this->verify_object->_value)===false AND !empty($this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_date"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * A két mezőnek megegyezőnek kell lennie.
     * 
     * @param Item $item
     * @return error|object error
     */
    public function equalTo($item){
        if ($this->verify_object->_value!==$item->_value) {
            return Rimo::$_config->FORM_ERROR["form_mess_equalTo"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * A két mezőnek megegyezőnek kell lennie.
     * 
     * @param Item $item
     * @return error|object error
     */
    public function equalToCaptcha($item){
        if ($this->verify_object->_value!==$item->_value) {
            return Rimo::$_config->FORM_ERROR["form_mess_equalToCaptcha"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * E-mail formátum vizsgálat
     * 
     * @return error|object error
     */
    public function email() {
        if (!preg_match('/^([a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,}){0,}$/',$this->verify_object->_value)) {
            return Rimo::$_config->FORM_ERROR["form_mess_email"] . " " . $this->verify_object->_error;
        }
        return $this->verify_object->_error;
    }
    /**
     * Egyediség ellenőrzése.
     * 
     * @param array("table, field, modify")
     * 
     * @return error|object error
     */
    public function unique(array &$data){        
        $value = mysql_real_escape_string($this->verify_object->_value);
        if(($data["modify"])){
            $where = " AND {$data["table"]}_id<>{$data["modify"]}";
        }
        $query = "
            SELECT {$data["table"]}_id 
            FROM {$data["table"]} 
            WHERE {$data["table"]}_torolt=0 AND 
                  {$data["field"]}='{$value}'
                  {$where} 
                  {$data["where"]}
            LIMIT 1
        ";
        try{
            $data["DB"]->prepare($query)->query_select()->query_fetch_array();
            return Rimo::$_config->FORM_ERROR["form_mess_unique"] . " " . $this->verify_object->_error;
        }
        catch(Exception_MYSQL_Null_Rows $e){
            return $this->verify_object->_error;
        }
        catch(Exception_MYSQL $e){
            return $e->getMessage();
        }
        return $this->verify_object->_error;
    }
}