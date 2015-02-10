<?php
/**
 * Site álláshirdetés list model
 */
class Ceg_Telephely_SiteList_Model extends Page_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg_telephely';
    /**
     * Mezők.
     * @var string
     */
    public $_fields = 'ceg_telephely.ceg_telephely_id, co.nev AS orszag, cm.cim_megye_nev AS megye, 
        cv.cim_varos_nev AS varos, ci.iranyitoszam AS iranyitoszam, ceg_telephely.utca, ceg_telephely.hazszam';
    /**
     * JOIN
     * @var string
     */
    public $_join = 'INNER JOIN cim_orszag co ON ceg_telephely.cim_orszag_id = co.cim_orszag_id
                    INNER JOIN cim_megye cm ON ceg_telephely.cim_megye_id = cm.cim_megye_id 
                    INNER JOIN cim_varos cv ON ceg_telephely.cim_varos_id = cv.cim_varos_id 
                    INNER JOIN cim_iranyitoszam ci ON ceg_telephely.cim_iranyitoszam_id = ci.cim_iranyitoszam_id';
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->listWhere['active'] = 'ceg_telephely.ceg_telephely_aktiv = 1';
    }
    /**
     * 
     */
    public function __addForm()
    {
        parent::__addForm();
    }
}