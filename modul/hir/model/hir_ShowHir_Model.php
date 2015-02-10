<?php
class Hir_ShowHir_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function getTartalom($link){
        $query = "
            SELECT hir_id,
                   hir_cim, 
                   hir_leiras, 
                   hir_meta_kulcsszo, 
                   hir_tartalom,
                   DATE_FORMAT(hir_megjelenes,'%Y-%m-%d %H:%i') AS megjelenes, 
                   hir_szerzo,  
                   hir_kep_nev, 
                   jogcsoport_id
            FROM hir 
            WHERE hir_link='".mysql_real_escape_string($link)."' AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND  
                  hir_aktiv=1 AND 
                  hir_torolt=0 AND 
                  ( 
                    (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR   
                    (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') 
                  ) 
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getKapcsolodo($id){
        try{
            $query = "
                SELECT hir_cim,
                       hir_link,
                       hir_kep_nev
                FROM hir_kapcsolodo 
                INNER JOIN hir
                    ON hir.hir_id=hir_kapcsolodo_id 
                INNER JOIN hir_attr_kategoria ON hir.hir_id=hir_attr_kategoria.hir_id
                INNER JOIN hir_kategoria ON hir_kategoria_id=hir_attr_kategoria_id
				WHERE hir_kapcsolodo.hir_id={$id} AND 
					  hir.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
					  hir_kategoria.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                      hir_aktiv=1 AND 
                      hir_torolt=0 AND 
                      hir_kategoria_aktiv=1 AND 
                      hir_kategoria_torolt=0 AND 
                      ( 
                        (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR   
                        (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') 
                      )  
       			GROUP BY hir.hir_id 
       			ORDER BY hir_megjelenes DESC
            ";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
    
    public function updateMegtekintes($id){
        $query = "
            UPDATE hir 
            SET hir_megtekintve=hir_megtekintve+1 
            WHERE hir_id={$id} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID
        ;
        $this->_DB->prepare($query)->query_update();
    }
}
?>