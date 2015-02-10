<?php
class Tartalom_Show_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function getTartalom($link=""){
        $link = mysql_real_escape_string($link);
        if($link)
            $where = "tartalom_link='{$link}'";
        else
            $where = "tartalom_kezdolap='1'";
        $query = "
            SELECT tartalom_id,
                   tartalom_cim, 
                   tartalom_leiras, 
                   tartalom_meta_kulcsszo, 
                   tartalom_tartalom, 
                   tartalom_szerzo,  
                   tartalom_kep_nev, 
                   tartalom_kezdolap,
                   jogcsoport_id 
            FROM tartalom 
            WHERE {$where} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND  
                  tartalom_aktiv=1 AND 
                  tartalom_torolt=0 
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getTartalomFromID($id){
        $query = "
            SELECT tartalom_id,
                   tartalom_cim, 
                   tartalom_leiras, 
                   tartalom_meta_kulcsszo, 
                   tartalom_tartalom, 
                   tartalom_szerzo,  
                   tartalom_kep_nev, 
                   tartalom_kezdolap,
                   jogcsoport_id 
            FROM tartalom 
            WHERE tartalom_id=".mysql_real_escape_string($id)." AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND  
                  tartalom_aktiv=1 AND 
                  tartalom_torolt=0 AND 
                  tartalom_default=1
            LIMIT 1
        ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getTartalomByID($id){
        try
        {
                $query = "
                SELECT tartalom_id,
                       tartalom_cim, 
                       tartalom_leiras, 
                       tartalom_meta_kulcsszo, 
                       tartalom_tartalom, 
                       tartalom_szerzo,  
                       tartalom_kep_nev, 
                       tartalom_kezdolap,
                       jogcsoport_id 
                FROM tartalom 
                WHERE tartalom_id=".mysql_real_escape_string($id)." AND 
                      nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND  
                      tartalom_aktiv=1 AND 
                      tartalom_torolt=0
                LIMIT 1
            ";
        
                return $this->_DB->prepare($query)->query_select()->query_result_array();

        } catch (Exception_MYSQL_Null_Rows $e) {

        }
        
    }
    
    
    
    public function getKapcsolodo($id){
        try{
            $query = "
                SELECT tartalom_cim,
                       tartalom_link,
                       tartalom_kep_nev
                FROM tartalom_kapcsolodo 
                INNER JOIN tartalom
                    ON tartalom.tartalom_id=tartalom_kapcsolodo_id 
                WHERE tartalom_kapcsolodo.tartalom_id={$id} AND 
                      nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                      tartalom_aktiv=1 AND 
                      tartalom_torolt=0 
            ";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
    
    public function updateMegtekintes($id){
        $query = "
            UPDATE tartalom 
            SET tartalom_megtekintve=tartalom_megtekintve+1 
            WHERE tartalom_id={$id} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID
        ;
        $this->_DB->prepare($query)->query_update();
    }
    
    public function searchMvByMunkakor($str){
        try{
                
        //hány MV vette fel a keresett munkakört
        $query="SELECT munkakor.munkakor_nev, COUNT(munkakor.munkakor_nev) AS db
                FROM ugyfel
                INNER JOIN ugyfel_attr_munkakor ON ugyfel_attr_munkakor.ugyfel_id = ugyfel.ugyfel_id
                INNER JOIN munkakor ON ugyfel_attr_munkakor.munkakor_id = munkakor.munkakor_id
                WHERE munkakor.munkakor_nev LIKE '%".$str."%' AND ugyfel.ugyfel_aktiv = 1 AND ugyfel.ugyfel_torolt = 0
                GROUP BY munkakor.munkakor_nev";
        
        //hány MV vette fel a keresett munkakört - azt is listázza, amelyik munkakört még nem vette fel egy mv sem
        $query="SELECT munkakor.munkakor_nev, COUNT(ugyfel.ugyfel_id) AS db
                FROM munkakor
                LEFT JOIN ugyfel_attr_munkakor ON ugyfel_attr_munkakor.munkakor_id = munkakor.munkakor_id
                LEFT JOIN ugyfel ON ugyfel_attr_munkakor.ugyfel_id = ugyfel.ugyfel_id AND ugyfel.ugyfel_aktiv = 1 AND ugyfel.ugyfel_torolt = 0
                WHERE munkakor.munkakor_nev LIKE '%".$str."%'
                GROUP BY munkakor.munkakor_nev
                ORDER BY DB DESC";

        return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            
        }
    }
    
    public function getCountWorkingClients(){
        try{
           $query="SELECT COUNT(ugyfel.ugyfel_id) AS db
                   FROM ugyfel
                   INNER JOIN ugyfel_attr_mp_helyzet ON ugyfel_attr_mp_helyzet.ugyfel_id = ugyfel.ugyfel_id
                   WHERE ugyfel_attr_mp_helyzet.dolgozik = 1 AND ugyfel_aktiv = 1 AND ugyfel_torolt = 0";
           
           return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
    
    public function getCountAllClients(){
        try{
           $query="SELECT COUNT(ugyfel.ugyfel_id) AS db
                   FROM ugyfel
                   WHERE ugyfel_aktiv=1 AND ugyfel_torolt=0";
           
           return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>