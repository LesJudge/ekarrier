<?php
include_once "page/all/model/page.list_model.php";
class Kereso_ShowList_Model extends Page_List_Model {
    public $_fields = "id, cim, link, leiras, nyelv, kep_nev
                       ";
    
    public function __addForm(){
    	parent::__addForm();
    }
    
    public function __construct(){
    	parent::__construct();
    	$szo = mysql_real_escape_string($_REQUEST["szo"]);
    	$this->listWhere["szo"] = "cim LIKE '%{$szo}%' OR leiras LIKE '%{$szo}%' OR tartalom LIKE '%{$szo}%' OR kulcsszo LIKE '%{$szo}%'"; 
    }
    
    public function __loadList() {
        $order = " ORDER BY sorrend ASC, rendezes ASC";
        $query =  "
			SELECT {$this->_fields} 
			FROM
	        (
	            (
	            	SELECT hir.hir_id AS id,
						   hir_cim AS cim, 
						   CONCAT('hirek/',hir_link) AS link,
						   hir_leiras AS leiras, 
						   hir_meta_kulcsszo AS kulcsszo, 
						   hir_tartalom AS tartalom,
						   hir.nyelv_id AS nyelv,
						   CONCAT('hir/',hir_kep_nev) AS kep_nev,
						   3 AS sorrend,
						   hir_megjelenes AS rendezes 
	                FROM hir
	                INNER JOIN hir_attr_kategoria ON hir_attr_kategoria.hir_id=hir.hir_id 
			 		INNER JOIN hir_kategoria ON hir_attr_kategoria_id=hir_kategoria_id AND hir_kategoria_aktiv=1 AND hir_kategoria_torolt=0
	                WHERE hir_aktiv=1 AND 
						  hir_torolt=0 AND 
						  ( (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR   (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') ) AND  
						  hir_kategoria.nyelv_id={$this->nyelvID}  
				  GROUP BY id
	            )
	            UNION
	            (
	                SELECT tartalom_id AS id,
						   tartalom_cim AS cim, 
						   tartalom_link AS link,
						   tartalom_leiras AS leiras, 
						   tartalom_meta_kulcsszo AS kulcsszo, 
						   tartalom_tartalom AS tartalom,
						   nyelv_id AS nyelv,
						   CONCAT('tartalom/',tartalom_kep_nev) AS kep_nev,
						   2 AS sorrend,
						   tartalom_cim AS rendezes 
	                FROM tartalom
	                WHERE tartalom_aktiv=1 AND
	                      tartalom_torolt=0 
                    GROUP BY id
	            )
	            UNION
	            (
	                SELECT termek.termek_id AS id,
						   termek_cim AS cim, 
						   CONCAT('termekek/',termek_link) AS link,
						   termek_leiras AS leiras, 
						   termek_meta_kulcsszo AS kulcsszo, 
						   termek_tartalom AS tartalom,
						   termek.nyelv_id AS nyelv,
						   CONCAT('termek/',termek_kep_nev) AS kep_nev,
						   1 AS sorrend,
						   termek_cim AS rendezes 
	                FROM termek
	                INNER JOIN termek_attr_kategoria ON termek_attr_kategoria.termek_id=termek.termek_id 
					INNER JOIN termek_kategoria ON termek_attr_kategoria_id=termek_kategoria_id AND termek_kategoria_aktiv=1 AND termek_kategoria_torolt=0
	                WHERE termek_aktiv=1 AND
	                      termek_torolt=0 AND 
	                      termek_kategoria.nyelv_id={$this->nyelvID} 
                    GROUP BY id
	            )
	        ) AS adathalmaz 
			{$this->listWhere} 
			{$order} 
			{$this->limit}
		";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function __loadListCount() {        
    	$this->__createWhere();
		$this->listWhere = str_replace("_torolt=0 AND","",$this->listWhere);
		$this->listWhere = str_replace(".nyelv_id={$this->nyelvID}","nyelv={$this->nyelvID}",$this->listWhere);
        $cnt = $this->cntHir();
		$cnt += $this->cntTartalom();
		$cnt += $this->cntTermek();
        return $cnt;
    }
    
    private function cntHir(){
    	$szo = mysql_real_escape_string($_REQUEST["szo"]);
		$query = "
			SELECT COUNT(DISTINCT(`hir`.hir_id)) AS cnt 
			FROM `hir`
			INNER JOIN hir_attr_kategoria ON hir_attr_kategoria.hir_id=hir.hir_id 
			INNER JOIN hir_kategoria ON hir_attr_kategoria_id=hir_kategoria_id AND hir_kategoria_aktiv=1 AND hir_kategoria_torolt=0 
			WHERE hir_aktiv=1 AND 
				  hir_torolt=0 AND 
				  ( (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') ) AND 
				  hir_kategoria.nyelv_id={$this->nyelvID} AND 
				  hir.nyelv_id={$this->nyelvID} AND (
				  hir_cim LIKE '%{$szo}%' OR hir_leiras LIKE '%{$szo}%' OR hir_tartalom LIKE '%{$szo}%' OR hir_meta_kulcsszo LIKE '%{$szo}%')
		";
		return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
    }
    
    private function cntTartalom(){
    	$szo = mysql_real_escape_string($_REQUEST["szo"]);
		$query = "
			SELECT COUNT(DISTINCT(`tartalom`.tartalom_id)) AS cnt 
			FROM `tartalom`
			WHERE tartalom_aktiv=1 AND 
				  tartalom_torolt=0 AND 
				  tartalom_default=0 AND 
				  tartalom.nyelv_id={$this->nyelvID} AND (
				  tartalom_cim LIKE '%{$szo}%' OR tartalom_leiras LIKE '%{$szo}%' OR tartalom_tartalom LIKE '%{$szo}%' OR tartalom_meta_kulcsszo LIKE '%{$szo}%')
		";
		return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
	}
	
	private function cntTermek(){
		$szo = mysql_real_escape_string($_REQUEST["szo"]);
		$query = "
			SELECT COUNT(DISTINCT(`termek`.termek_id)) AS cnt 
			FROM `termek` 
			INNER JOIN termek_attr_kategoria ON termek_attr_kategoria.termek_id=termek.termek_id 
			INNER JOIN termek_kategoria ON termek_attr_kategoria_id=termek_kategoria_id AND termek_kategoria_aktiv=1 AND termek_kategoria_torolt=0
			WHERE termek_aktiv=1 AND 
				  termek_torolt=0 AND  
				  termek.nyelv_id={$this->nyelvID} AND 
				  termek_kategoria.nyelv_id={$this->nyelvID} AND (
				  termek_cim LIKE '%{$szo}%' OR termek_leiras LIKE '%{$szo}%' OR termek_tartalom LIKE '%{$szo}%' OR termek_meta_kulcsszo LIKE '%{$szo}%')
		";
		return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
	}
}
?>