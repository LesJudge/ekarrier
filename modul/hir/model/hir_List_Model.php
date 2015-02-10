<?php
class Hir_List_Model extends Admin_List_Model {
    public $_tableName = "hir";
    public $_fields = "hir.hir_id AS ID, hir_cim AS elso, hir_megtekintve, 
                       DATE_FORMAT(hir_megjelenes,'%Y-%m-%d %H:%i') AS megjelenes,
                       IF(hir_lejarat='0000-00-00 00:00:00','Nincs',DATE_FORMAT(hir_lejarat,'%Y-%m-%d %H:%i')) AS lejarat,
                       hir_aktiv AS Aktiv
    ";
    public $_join = "LEFT JOIN hir_attr_kategoria ON hir_attr_kategoria.hir_id=hir.hir_id";
    
    public function __addForm(){
        parent::__addForm();
        
        $this->tableHeader = array(
            "hir_cim" => array("label" => "Cím", "width" => 51),
            "hir_megtekintve" => array("label" => "Megtekintve", "width" => 10),
            "hir_megjelenes" => array("label" => "Megjelenési dátum", "width" => 14),
            "hir_lejarat" => array("label" => "Lejárati dátum", "width" => 14),
            "hir_aktiv" => array("label" => "Közzétéve", "width" => 8)
        );
        $this->_params["TxtSort"]->_value = "hir_megjelenes__DESC";
        $this->addItem("FilterStatus")->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        $kategoria_filter = $this->addItem("FilterKategoria");
        $kategoria_filter->_select_value = $this->getKategoriaSelectValues();
    }
    
    private function getKategoriaSelectValues() {
        try {
            $query = "
                 SELECT hir_kategoria_id AS id,   
                        kategoria_cim AS name,    
                        szint AS depth,
                        baloldal as bal,
                        jobboldal AS jobb
                 FROM  hir_kategoria    
                 WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                 GROUP BY hir_kategoria_id   
                 ORDER BY baloldal
            ";
            $list[0] = "--Válasszon kategóriát--";
            $obj = $this->_DB->prepare($query)->query_select();
            while ($adat = $obj->query_fetch_array()) {
                $added = "";
                for ($i = 0; $i < $adat["depth"]; $i++) {
                    $added .= "--";
                }
                if($adat["depth"]==0){
                    $list[$adat["id"]] = "<".$adat["name"].">";    
                }
                else{
                    $list[$adat["id"]] = $added." ".$adat["name"];
                }
            }
            return $list;
        }
        catch (Exception_MYSQL_Null_Rows $e) {
            return array("--Hírek oldal--");
        }
        catch (Exception_MYSQL $e) {
            return array("0" => "HIBA");
        }
    }
}
?>