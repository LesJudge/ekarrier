<?php
class {$modulnevUpper}{$modelnev}_Edit_Model extends Admin_Edit_Model{
    
    public $_tableName = '{$tablanev}';
    
    public $_bindArray = array(
        '{$tablanev}_nev' => 'TxtNev',
        '{$tablanev}_aktiv' => 'ChkAktiv',
        {$bindArray}
    );
    
    /**
     * Ez a metódus új elem felvitelénél mindig lefut.
     */
    public function __newData() {
        parent::__newData();
    }
    
    /**
     * Ez a metódus módosítás esetén mindig lefut.
     * @return array => Adatokat tartalmazó tömb.
     */
    public function __editData() {
        parent::__editData();
    }
    
    /**
     * Elemek hozzáadása a formhoz.
     */
    public function __addForm(){
        parent::__addForm();
        $nev = $this->addItem('TxtNev');
        $nev->_verify['string'] = true;
        {$addForm}
    }
    
    /**
     * Az itt megadott form elemeinek beállítja az értékét.
     * Sor betöltés query generálása és végrehajtása. Ezeket az értékeket beállítja a form elemeknek. 
     * 
     * @uses Model::getItemValue()
     * @uses Create::query_load_sets()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_fetch_array()
     */
    public function __formValues() {
        parent::__formValues();
    }
    
    public function __insert(){
        parent::__insert(",{$tablanev}_letrehozas_datum = NOW() 
                          ,{$tablanev}_letrehozo = ".(int)UserLoginOut_Admin_Controller::$_id);
    }
    
    public function __update(){
        parent::__update(",{$tablanev}_modositas_datum = NOW() 
                          ,{$tablanev}_modosito = ".(int)UserLoginOut_Admin_Controller::$_id." 
                          ,{$tablanev}_javitas_szama = ({$tablanev}_javitas_szama+1)");
    }

}
?>