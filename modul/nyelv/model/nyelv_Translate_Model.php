<?php
class nyelv_Translate_Model extends Model {
    private $szavak;
    private $modul_id;
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function translate($modul_id){
        try{
            $this->modul_id = $modul_id;
            $obj = $this->getSzavak($this->modul_id);
            while($szo = $obj->query_fetch_array()){
               $this->szavak[$szo["nyelv_szotar_azon"]] = $szo["nyelv_szotar_szo"];
            }
        }
        catch(Exception_MYSQL_Null_Rows $e){
            $this->szavak = array();
        }
        return $this;
    }
    
    public function __($azon){
        if(array_key_exists($azon,$this->szavak)){
            return $this->szavak[$azon];
        }
        $this->szavak[$azon] = $azon; 
        $this->insertSzo($azon);
        return $this->szavak[$azon];
    }
    
    private function insertSzo($azon){
        try{
            $query = "
                INSERT INTO nyelv_szotar
                SET nyelv_szotar_szo='{$azon}', 
                    nyelv_szotar_azon='{$azon}',
                    nyelv_id=".Rimo::$_config->SITE_NYELV_ID.", 
                    modul_id='{$this->modul_id}'
            ";
            $this->_DB->prepare($query)->query_insert();
        }catch(Exception_MYSQL $e){
            
        }
    }
    
    private function getSzavak($modul_id){
        $query = "
            SELECT 	nyelv_szotar_szo, nyelv_szotar_azon
            FROM nyelv_szotar
            WHERE nyelv_szotar_torolt=0 AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                  modul_id='{$modul_id}'
        ";
        return $this->_DB->prepare($query)->query_select();
    }
    
    public function translateFormMessage(){
    	$obj = $this->getSzavak("9998");
        while($szo = $obj->query_fetch_array()){
        	Rimo::$_config->FORM_ERROR[$szo["nyelv_szotar_azon"]] = $szo["nyelv_szotar_szo"];
        }
    }
}
?>