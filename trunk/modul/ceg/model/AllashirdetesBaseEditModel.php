<?php
abstract class AllashirdetesBaseEditModel extends Admin_Edit_Model
{

    public $_tableName = 'allashirdetes';
    public $_bindArray = array(
        'ceg_id' => 'SelCeg',
        'megnevezes' => 'TxtNev',
        'link' => 'TxtLink',
        'ismerteto' => 'TxtIsmerteto',
        'ellenorzott' => 'ChkEllenorzott',
        'allashirdetes_aktiv' => 'ChkAktiv',
    );

    public function __addForm()
    {
        parent::__addForm();
        // Név
        $this->addItem('TxtNev')->_verify['string'] = true;
        // Link
        $link = $this->addItem('TxtLink');
        $link->_verify['string'] = true;
        $link->_verify['unique'] = array(
            'table' => 'allashirdetes',
            'field' => 'link',
            'modify' => $this->modifyID,
            'DB' => $this->_DB
        );
        // Tartalom
        $this->addItem('TxtIsmerteto')->_verify['string'] = true;
        // Cég
        $this->addItem('SelCeg');
        // Ellenőrzött álláshirdetés
        $this->addItem('ChkEllenorzott')->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }
    /**
     * SEO URL elkészítése.
     */
    public function removeAccentsFromLink()
    {
        $this->_params['TxtLink']->_value = Create::remove_accents($this->_params['TxtLink']->_value);
    }
    /**
     * Eltávolítja az elválasztókat a kulcsszóból.
     */
    public function removeDelimitterFromKulcsszo()
    {
        while (strpos($this->_params['TxtKulcsszo']->_value, ',,') !== false) {
            $this->_params['TxtKulcsszo']->_value = str_replace(',,', ',', $this->_params['TxtKulcsszo']->_value);
        }
    }
    public function __formValues()
    {
        parent::__formValues();
    }
    public function __update()
    {
        parent::__update(',modositas_timestamp=now()
                                              ,modositas_szama=modositas_szama+1
                                              ,modosito=' . UserLoginOut_Controller::$_id
        );
    }
    public function __insert()
    {
        parent::__insert(',letrehozo=' . UserLoginOut_Controller::$_id);
    }
}