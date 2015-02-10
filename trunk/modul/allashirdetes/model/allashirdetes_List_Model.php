<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Allashirdetes_List_Model extends Admin_List_Model
{
    public $_tableName = 'allashirdetes';
    public $_fields = 'allashirdetes.allashirdetes_id AS ID,
                       allashirdetes.megnevezes AS elso,
                       allashirdetes.egyedi,
                       allashirdetes.ellenorzott,
                       allashirdetes.hirdeto,
                       allashirdetes.letrehozas_timestamp,
                       allashirdetes.modositas_timestamp,
                       allashirdetes.num_megtekintve,
                       allashirdetes.allashirdetes_aktiv AS Aktiv,
                       c.nev,
                       p.pozicio_nev,
                       sz.szektor_nev,
                       COUNT(uaad.allashirdetes_id) AS count_user';
    public $_join = 'INNER JOIN user u1 ON allashirdetes.letrehozo = u1.user_id 
                     INNER JOIN user u2 ON allashirdetes.modosito = u2.user_id
                     LEFT JOIN ceg c ON allashirdetes.ceg_id = c.ceg_id
                     INNER JOIN szektor sz ON allashirdetes.szektor_id = sz.szektor_id
                     INNER JOIN pozicio p ON allashirdetes.pozicio_id = p.pozicio_id
                     LEFT JOIN user_attr_allashirdetes_doksi uaad ON 
                               allashirdetes.allashirdetes_id = uaad.allashirdetes_id';
    public function __construct()
    {
        parent::__construct();
        $this->_fields .= ',IF(' . UserLoginOut_Admin_Controller::$_id . ' IN (uaad.user_id), 1, 0) AS generated';
    }
    /**
     * Form elkészítése.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader = array(
            'allashirdetes.megnevezes' => array('label' => 'Név', 'width' => 30),
            'allashirdetes.egyedi' => array('label' => 'Típus'),
            'allashirdetes.ellenorzott' => array('label' => 'Ellenőrzött'),
            'allashirdetes.hirdeto' => array('label' => 'Hirdető'),
            'allashirdetes.szektor_id' => array('label' => 'Szektor'),
            'allashirdetes.pozicio_id' => array('label' => 'Pozíció'),
            'allashirdetes.letrehozas_timestamp' => array('label' => 'Létrehozás ideje'),
            'allashirdetes.modositas_timestamp' => array('label' => 'Módosítás ideje'),
            'allashirdetes.num_megtekintve' => array('label' => 'Megtekintve'),
            'generated' => array('label' => 'Generáltam doksit ?'),
            'allashirdetes.allashirdetes_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
        );
        $this->_params['TxtSort']->_value = 'allashirdetes.megnevezes__ASC';
        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        // Igen-nem
        $tofBase = array(1 => 'Igen', 2 => 'Nem');
        // Cég szűrő
        $comps = $this->addItem('FilterCeg');
        $comps->_select_value = $this->getSelectValues(
            'ceg',
            'nev',
            ' AND ceg_aktiv=1 AND ceg_torolt=0',
            ' ORDER BY nev ASC',
            false,
            array('' => '--Válasszon céget!--')
        );
        // Ellenőrzött álláshirdetés szűrő
        $this->addItem('FilterEllenorzott')->_select_value = array(0 => '--Ellenőrzött--') + $tofBase;
        // Egyedi álláshirdetés szűrő
        $this->addItem('FilterEgyedi')->_select_value = array(0 => '--Egyedi--') + $tofBase;
        // Más hirdetése szűrő
        $this->addItem('FilterMasHirdetes')->_select_value = array(0 => '--Más hirdetése--') + $tofBase;
    }
}