<?php
class Nyelv_Szotar_List_Model extends Admin_List_Model {
    public $_tableName = "nyelv_szotar";
    public $_fields = "nyelv_szotar_id AS ID, nyelv_szotar_szo AS elso,
                       nyelv_szotar_azon
    ";
    public $tableHeader  = array(
            "nyelv_szotar_szo" => array("label" => "Szó", "width" => 60),
            "nyelv_szotar_azon" => array("label" => "Azonosító", "width" => 40)
    );
    
    public function __addForm(){
        parent::__addForm();
        $this->addItem('FilterModul')->_select_value = $this->getSelectValues("modul", "modul_nev", "","",false,array(0=>"--Válasszon modult--",9999=>"Site elemek",9998=>"Form üzenetek"));
    }
}
?>