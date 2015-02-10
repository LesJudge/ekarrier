<?php
class Banner_List_Model extends Admin_List_Model {
    public $_tableName = "banner";
    public $_fields = "banner.banner_id AS ID, 
                       banner_nev AS elso, 
                       banner_link, 
                       banner_kep_nev,
                       banner_pozicio,
                       banner_aktiv AS Aktiv,
                       banner_kod,
                       DATE_FORMAT(banner_megjelenes,'%Y-%m-%d %H:%i') AS megjelenes,
                       IF(banner_lejarat='0000-00-00 00:00:00','Nincs',DATE_FORMAT(banner_lejarat,'%Y-%m-%d %H:%i')) AS lejarat
    ";
    public $_join = " INNER JOIN banner_attr_oldal ON banner.banner_id = banner_attr_oldal.banner_id ";                       
    
    public function __addForm(){
      
        parent::__addForm();
        $this->tableHeader = array(
            "banner_nev" => array("label" => "Név", "width" => 24),
            "banner_kep" => array("label" => "Kép", "width" => 10),
            "banner_link" => array("label" => "Link", "width" => 15),
            "banner_pozicio" => array("label" => "Hely", "width" => 15),
            "banner_megjelenes" => array("label" => "Megjelenési dátum", "width" => 14),
            "banner_lejarat" => array("label" => "Lejárati dátum", "width" => 14),
            "banner_aktiv" => array("label" => "Közzétéve", "width" => 8)
        );
        $this->_params["TxtSort"]->_value = "banner_megjelenes__DESC";
        $this->addItem("FilterStatus")->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        $this->addItem("FilterDatumTol");
        $this->addItem("FilterDatumIg");
        $oldal_filter = $this->addItem("FilterOldal");
        $oldal_filter->_select_value = $this->getOldalSelectValues();
        $filter_pozicio = $this->addItem("FilterPozicio");
        $filter_pozicio->_select_value = Rimo::$_config->POZICIO_AZ_OLDALON;
    }
    
    private function getOldalSelectValues() {
        $selectValues = Rimo::$_config->OLDALSELECT;
        $tartalmak = $this->getSelectValues("tartalom","tartalom_cim","AND tartalom_default=0","ORDER BY tartalom_cim");
        foreach($tartalmak as $key=>$val){
            $selectValues["Tartalmak"]["tart__{$key}"] = $val;
        }
        
        $hir_kategoriak = $this->getKategoria("hir_kategoria","kategoria_cim","hk__");
        if($hir_kategoriak){
            $selectValues["Hír kategóriák"] = $hir_kategoriak; 
        }
        $termek_kategoriak = $this->getKategoria("termek_kategoria","kategoria_cim","tk__");
        if($termek_kategoriak){
            $selectValues["Termék kategóriák"] = $termek_kategoriak; 
        }
        return $selectValues;
    }
    
    private function getKategoria($table, $name_field, $added_id, $where="" ) {
        try {
            $query = "
                 SELECT {$table}_id AS id,   
                        {$name_field} AS name,    
                        szint AS depth,
                        baloldal as bal,
                        jobboldal AS jobb
                 FROM {$table}         
                 WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                       {$where}    
                 GROUP BY {$table}_id   
                 ORDER BY baloldal
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while ($adat = $obj->query_fetch_array()) {
                $added = "";
                for ($i = 0; $i < $adat["depth"]+1; $i++) {
                    $added .= "--";
                }
                if($adat["depth"]==0){
                    $list[$added_id.$adat["id"]] = "<".$adat["name"].">";    
                }
                else{
                    $list[$added_id.$adat["id"]] = $added." ".$adat["name"];
                }
            }
            return $list;
        }
        catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
        catch (Exception_MYSQL $e) {
            return array("0" => "HIBA");
        }
    }     
}
?>