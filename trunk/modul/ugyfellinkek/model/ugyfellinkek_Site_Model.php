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
   
    public function findLinks($uID)
    {
        try {
            $query = "SELECT link_nev AS nev, link_url AS link
                     FROM ugyfel_attr_linkek 
                     WHERE ugyfel_id=" . (int)$uID;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function saveLink($uID,$name,$url)
    {
        try {
            $query = "INSERT INTO ugyfel_attr_linkek
                     SET ugyfel_id = ".(int)$uID.", link_nev = '".mysql_real_escape_string($name)."', link_url = '".mysql_real_escape_string($url)."'
                    ON DUPLICATE KEY UPDATE
                    link_nev = '".mysql_real_escape_string($name)."'
                    ";
            $this->_DB->prepare($query)->query_insert();
            throw new Exception_Form_Message("Sikeresen hozzáadva!");
        } catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    
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
    
    public function validateSaveLink($uID,$name,$url)
    {
        if(empty($name))
        {
            throw new Exception_Form_Error("Adjon meg nevet!");
        }else
        {
            if((int)$uID < 1 || empty($url))
            {
                throw new Exception_Form_Error("Hiba történt!");
            }
        }
    }
    
    public function validateDeleteLink($uID,$url)
    {
            if((int)$uID < 1 || empty($url))
            {
                throw new Exception_Form_Error("Hiba történt!");
            }   
    }
   
}
