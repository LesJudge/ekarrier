<?php

class ugyfellinkek_Site_Model extends Model
{
    const USE_DEFAULT_LANG_ID = 0;
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    
    public static function model()
    {
        return new self;
    }
    
    protected function chooseLangId($langId)
    {
        return ((int)$langId > self::USE_DEFAULT_LANG_ID) ? $langId : Rimo::$_config->SITE_NYELV_ID;
    }
   
    public function findLinks($category,$id)
    {
        try {
            $query = "SELECT link_nev AS nev, link_url AS link
                     FROM ugyfel_attr_linkek 
                     WHERE category ='".  mysql_real_escape_string($category)."' AND id_in_category = ".(int)$id." AND ugyfel_attr_linkek_aktiv = 1
                     AND ugyfel_attr_linkek_torolt = 0 AND checked = 1";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function saveLink($uID,$name,$url,$cat,$idInCat)
    {
        try {
            $query = "INSERT INTO ugyfel_attr_linkek
                     SET ugyfel_id = ".(int)$uID.", link_nev = '".mysql_real_escape_string($name)."', link_url = '".mysql_real_escape_string($url)."',
                         category = '".mysql_real_escape_string($cat)."', id_in_category = ".(int)$idInCat.",
                         letrehozas_timestamp = NOW(), checked=0, ugyfel_attr_linkek_aktiv = 0, ugyfel_attr_linkek_torolt = 0, tipus = 'ugyfel', letrehozo_id = ".(int)$uID."
                    ";
            $this->_DB->prepare($query)->query_insert();
            throw new Exception_Form_Message("Sikeresen hozzáadva!");
        } catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    /*
    public function deleteLink($uID,$url)
    {
        try {
            $query = "DELETE FROM ugyfel_attr_linkek
                     WHERE ugyfel_id = ".(int)$uID." AND link_url = '".  mysql_real_escape_string($url)."'
                    ";
            $this->_DB->prepare($query)->query_execute();
            throw new Exception_Form_Message("Sikeresen törölve!");
        } catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    */
    public function validateSaveLink($uID,$name,$url,$cat,$idInCat)
    {
        if(empty($name) || strlen($name) < 5)
        {
            throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
        }
        elseif(empty($url) || !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url))
        {
            throw new Exception_Form_Error("Nem megfelelő URL!");
        }
        elseif($this->checkIfUrlExists($cat,$idInCat,$url) === true)
        {
            throw new Exception_Form_Error("Az adott URL már szerepel a rendszerben!");
        }
        elseif((int)$uID < 1 || empty($cat) || (int)$idInCat < 1)
        {
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    
    public function checkIfUrlExists($cat,$idInCat,$url)
    {
        try{
            $query = "SELECT ugyfel_attr_linkek_id
                      FROM ugyfel_attr_linkek
                      WHERE category = '".mysql_real_escape_string($cat)."'
                      AND id_in_category = ".$idInCat."
                      AND link_url = '".mysql_real_escape_string($url)."'
                      AND ugyfel_attr_linkek_torolt = 0
                    ";
            
            $this->_DB->prepare($query)->query_select()->query_result_array();
            return true;
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return false;
        }
    }
    
    
    /*
    public function validateDeleteLink($uID,$url)
    {
            if((int)$uID < 1 || empty($url))
            {
                throw new Exception_Form_Error("Hiba történt!");
            }   
    }
   */
    
    
    
}
