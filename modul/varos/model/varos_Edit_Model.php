<?php

class Varos_Edit_Model extends Admin_Edit_Model
{
    public $_tableName = 'cim_varos';
    
    public $_bindArray = array(
        'kod' => 'TxtRovidites',
        'cim_varos_nev' => 'TxtNev'
    );

    public function __addForm()
    {
        $rovidites = $this->addItem('TxtRovidites');
        $rovidites->_verify['string'] = true;
        $rovidites->_verify['unique'] = array(
            'table' => 'cim_varos', 
            'field' => 'kod', 
            'modify' => $this->modifyID, 
            'DB' => $this->_DB
        );
        $this->addItem('TxtNev')->_verify['string'] = true;
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
