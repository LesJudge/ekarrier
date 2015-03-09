<?php

class Hir_ShowList_Model extends Page_List_Model {
    public $_tableName = "hir";
    public $_fields = "hir_cim, hir_link, hir_leiras, DATE_FORMAT(hir_megjelenes,'%Y-%m-%d %H:%i') AS megjelenes,
                       hir_kep_nev
    ";
    public $_join = "LEFT JOIN hir_attr_kategoria ON hir_attr_kategoria.hir_id=hir.hir_id 
                     LEFT JOIN hir_kategoria ON hir_attr_kategoria_id=hir_kategoria_id
    ";
    
    
    public function __construct(){
        parent::__construct();
        $this->sortBY = "hir_megjelenes DESC";
        $this->listWhere=array(1=>"hir_aktiv=1",
                               3=>"( (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR   (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') )"
        );
        // DEBUG
        if(isset($_REQUEST["kategoria_id"])){
        // END DEBUG
            $_REQUEST["kategoria_id"] = mysql_real_escape_string($_REQUEST["kategoria_id"]);
            $this->listWhere["kategoria"] = "hir_attr_kategoria_id={$_REQUEST["kategoria_id"]}";
        }
        else{
            $_REQUEST["link"] = mysql_real_escape_string($_REQUEST["link"]);
            $this->listWhere["kategoria"] = "kategoria_full_link='{$_REQUEST["link"]}'";
        }
    
       if($_SESSION['type']==="ma"){
           $this->_join.=" AND hir_kategoria.kategoria_ma=1 ";
       }else{
           $this->_join.=" AND hir_kategoria.kategoria_ma=0 ";
       }
       
       
            }
    
     public function getTartalom($link){
        $query = "
            SELECT hir_kategoria_id,
                   kategoria_cim,
                   kategoria_leiras,	
                   kategoria_meta_kulcsszo,
                   jogcsoport_id,
                   kategoria_kep_nev
            FROM hir_kategoria
            WHERE kategoria_full_link='".mysql_real_escape_string($link)."' AND  
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND  
                  hir_kategoria_aktiv=1 AND 
                  hir_kategoria_torolt=0 
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
     public function updateMegtekintes($id){
        $query = "
            UPDATE hir_kategoria 
            SET kategoria_megtekintve=kategoria_megtekintve+1 
            WHERE hir_kategoria_id={$id} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID
        ;
        $this->_DB->prepare($query)->query_update();
    }
    
    public function getKapcsolodo($id){
        try{
            $query = "
                SELECT kategoria_cim,
               	       kategoria_full_link,
                       kategoria_kep_nev
                FROM hir_kategoria_kapcsolodo 
                INNER JOIN hir_kategoria
                    ON hir_kategoria.hir_kategoria_id=hir_kategoria_kapcsolodo_id 
                WHERE hir_kategoria_kapcsolodo.hir_kategoria_id={$id} AND 
                      nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                      hir_kategoria_aktiv=1 AND 
                      hir_kategoria_torolt=0 
            ";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
    
    public function loadTree($parent_id){
        $query = "
            SELECT baloldal, jobboldal 
            FROM hir_kategoria 
            WHERE hir_kategoria_id={$parent_id} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID  
        ;
        $parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        
        $query = "
            SELECT hir_kategoria_id AS id,   
                   kategoria_cim AS menu_nev,
                   szint,
                   kategoria_full_link AS link  
            FROM `hir_kategoria`  
            WHERE baloldal > {$parent["baloldal"]} AND 
                  jobboldal < {$parent["jobboldal"]} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  AND 
                  hir_kategoria_aktiv=1 
            GROUP BY hir_kategoria_id 
            ORDER BY baloldal ASC  
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function __getParent($id){
        try{
           $query = "
                SELECT baloldal, jobboldal,
                       kategoria_cim 
                FROM hir_kategoria 
                WHERE hir_kategoria_id={$id} AND 
                      nyelv_id=".Rimo::$_config->SITE_NYELV_ID  
           ;
           $aktual = $this->_DB->prepare($query)->query_select()->query_fetch_array();
           
           $query = "
                 SELECT kategoria_cim AS nev,
                        kategoria_full_link AS link   
                 FROM hir_kategoria        
                 WHERE baloldal < {$aktual["baloldal"]} AND jobboldal > {$aktual["jobboldal"]}  AND 
                       nyelv_id=".Rimo::$_config->SITE_NYELV_ID."
                 ORDER BY baloldal
           ";  
           $obj = $this->_DB->prepare($query)->query_select();
           while($indikator = $obj->query_fetch_array()){
                $list[] = array("nev"=>$indikator["nev"],"link"=>$indikator["link"]."/");
           }
           $list[] = array("nev"=>$aktual["kategoria_cim"],"link"=>"");
           return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array(array("nev"=>$aktual["kategoria_cim"]));
        }
    }
}
?>