<?php

class Varos_Edit_Model extends Admin_Edit_Model
{
    public $_tableName = 'cim_varos';
    
    public $_bindArray = array(
        'cim_varos_nev' => 'TxtNev',
        'cim_orszag_id' => 'SelOrszag'
    );

    public function __addForm()
    {
        $this->addItem('TxtNev')->_verify['string'] = true;
        
        $orszag = $this->addItem('SelOrszag');
        $orszag->_verify['select'] = true;
        $orszag->_select_value = $this->getSelectValues(
            'cim_orszag', 
            'nev', 
            ' AND cim_orszag_aktiv = 1 AND cim_orszag_torolt = 0', 
            ' ORDER BY nev ASC', 
            false, 
            array('' => '--Kérem, válasszon!--')
        );
    }
    
    public function verifyRow($nyelv = "")
    {
        return true;
    }
    
    public function __insert($sets = '')
    {
        $userId = (int)UserLoginOut_Controller::$_id;
        
        $sets = sprintf(
            ', letrehozo_id = %d, modosito_id = %d, modositas_szama = modositas_szama + 1',
            $userId,
            $userId
        );
        
        return parent::__insert($sets);
    }

    public function __update($sets = '')
    {
        $userId = (int)UserLoginOut_Controller::$_id;
        
        $sets = sprintf(
            ', modosito_id = %d, modositas_szama = modositas_szama + 1',
            $userId,
            $userId
        );
        
        parent::__update($sets);
    }
}
