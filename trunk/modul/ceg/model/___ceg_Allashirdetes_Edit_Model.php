<?php

class Ceg_Allashirdetes_Edit_Model extends AllashirdetesBaseEditModel
{
    public function __addForm()
    {
        parent::__addForm();
        $this->_params['SelCeg']->_verify['select'] = true;
        $this->_params['SelCeg']->_select_value = $this->getSelectValues(
            'ceg', 'ceg_nev', ' AND ceg_aktiv=1 AND ceg_torolt=0', ' ORDER BY ceg_nev ASC', false,
            array('' => '--Kérem, válasszon!--')
        );
    }
    public function verifyRow($nyelv = "")
    {
        return true;
    }
        public function __editData()
    {
        parent::__editData();
        $query = "SELECT num_megtekintve,
                                            modositas_szama, 
                                            DATE_FORMAT(letrehozas_timestamp,'%Y-%m-%d %H:%i') AS letrehozas_timestamp, 
                                            DATE_FORMAT(modositas_timestamp,'%Y-%m-%d %H:%i') AS modositas_timestamp, 
                                            u1.user_fnev AS letrehozo, 
                                            u2.user_fnev AS modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON modosito=u2.user_id
                               WHERE allashirdetes_id='{$this->modifyID}'
                               LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    public function allashirdetesAllapot()
    {
        if ($this->_params["ChkAktiv"]->_value != 1) {
            return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A cég nem publikus!'></span>";
        }
        return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
    }
}