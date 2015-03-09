<?php
class Allaskereses_Show_Model extends Admin_List_Model
{
        
    public $_tableName = 'allashirdetes';
    public $_fields = 'allashirdetes.allashirdetes_id,
                      allashirdetes.link,
                      allashirdetes.megnevezes,
                      allashirdetes.ellenorzott,
                      cm.cim_megye_nev';
    public $_join = 'INNER JOIN cim_megye cm ON allashirdetes.cim_megye_id = cm.cim_megye_id';
    public $listWhere = array(
        'allashirdetes_aktiv = 1',
        'allashirdetes_torolt = 0'
    );
    
    public function __addForm()
    {
        parent::__addForm();
        // Szektor Filter
        $this->addItem('FilterSector')->_select_value = $this->getSelectValues(
            'szektor',
            'szektor_nev',
            ' AND szektor_aktiv = 1 AND szektor_torolt = 0',
            ' ORDER BY szektor_nev ASC',
            false,
            array(
                '' => '--Válasszon szektort!--'
            )
        );
        // Pozíció filter
        $this->addItem('FilterPosition')->_select_value = $this->getSelectValues(
            'pozicio',
            'pozicio_nev',
            ' AND pozicio_aktiv = 1 AND pozicio_torolt = 0',
            ' ORDER BY pozicio_nev ASC',
            false, 
            array(
                '' => '--Válasszon pozíciót!--'
            )
        );
        // Munkakör Filter
        $this->addItem('FilterJob')->_select_value =  $this->getSelectValues(
            'munkakor',
            'munkakor_nev',
            ' AND munkakor_aktiv = 1 AND munkakor_torolt = 0',
            ' ORDER BY munkakor_nev ASC',
            false,
            array(
                '' => '--Válasszon munkakört!--'
            )
        );
        // Megye Filter
        try {
            $countyQuery = "SELECT cim_megye_id, cim_megye_nev FROM cim_megye ORDER BY cim_megye_nev ASC";
            $countyResult = $this->_DB->prepare($countyQuery)->query_select();
            $counties = array();
            while ($data = $countyResult->query_fetch_array()) {
                $counties[$data['cim_megye_id']] = $data['cim_megye_nev'];
            }
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            $counties = array();
        }
        $this->addItem('FilterCounty')->_select_value = array('' => '--Válasszon megyét!--') + $counties;
        // Város Filter
        $this->addItem('FilterCity');
    }
}