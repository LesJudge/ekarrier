<?php

class Ceg_Telephely_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg_telephely';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'ceg_telephely.ceg_telephely_id AS ID,
                      ci.iranyitoszam AS iranyitoszam,
                      cv.cim_varos_nev AS varos,
                      cm.cim_megye_nev AS megye,
                      ceg_telephely.utca,
                      ceg_telephely.hazszam,
                      IF(ceg_telephely.letrehozo_id IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                      IF(ceg_telephely.modosito_id IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                      ceg_telephely.letrehozas_timestamp AS letrehozva,
                      IF(ceg_telephely.modositas_timestamp=0,\'Nem lett módosítva!\',ceg_telephely.modositas_timestamp) AS modositva,
                      c.nev,
                      ceg_telephely_aktiv AS Aktiv';
    /**
     * JOIN.
     * @var string
     */
    public $_join = 'INNER JOIN cim_iranyitoszam ci ON ceg_telephely.cim_iranyitoszam_id = ci.cim_iranyitoszam_id
                    INNER JOIN cim_varos cv ON ci.cim_varos_id=cv.cim_varos_id
                    INNER JOIN cim_megye cm ON cv.cim_megye_id=cm.cim_megye_id
                    LEFT JOIN user u1 ON u1.user_id=ceg_telephely.letrehozo_id
                    LEFT JOIN user u2 ON u2.user_id=ceg_telephely.modosito_id
                    LEFT JOIN ceg c ON c.ceg_id=ceg_telephely.ceg_id';

    public function __construct()
    {
        parent::__construct();
        $this->sortBY = "nev DESC";
    }

    public function __addForm() 
    {
        parent::__addForm();
        $this->tableHeader = array(
            'c.nev' => array(
                'label' => 'Cég'
            ),
            'ci.iranyitoszam' => array(
                'label' => 'Irányítószám'
            ),
            'cm.cim_megye_nev' => array(
                'label' => 'Megye'
            ),
            'cv.cim_varos_nev' => array(
                'label' => 'Város'
            ),
            'ceg_telephely.utca' => array(
                'label' => 'Utca'
            ),
            'ceg_telephely.hazszam' => array(
                'label' => 'Házszám'
            ),
            'ceg_telephely.letrehozo_id' => array(
                'label' => 'Létrehozó'
            ),
            'ceg_telephely.letrehozas_timestamp' => array(
                'label' => 'Létrehozás ideje'
            ),
            'ceg_telephely.modosito_id' => array(
                'label' => 'Módosító'
            ),
            'ceg_telephely.modositas_timestamp' => array(
                'label' => 'Módosítás ideje'
            ),
            'ceg_telephely.ceg_telephely_aktiv' => array(
                'label' => 'Közzétéve',
                'width' => 8
            )
        );
        $this->_params['TxtSort']->_value = 'c.nev__ASC';

        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        // Cégek szűrő
        $comps = $this->addItem('FilterCeg');
        $comps->_select_value = $this->getSelectValues(
            'ceg',
            'nev',
            ' AND ceg_aktiv = 1 AND ceg_torolt = 0',
            ' ORDER BY nev ASC',
            false,
            array('' => '--Válasszon céget!--')
        );
    }

}
