<?php

class BaseAdminUserEditModel extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'user';
    /**
     * _bindArray
     * @var array
     */
    public $_bindArray = array(
        'user_vnev' => 'TxtVnev',
        'user_knev' => 'TxtKnev',
        'user_fnev' => 'TxtFnev',
        'user_email' => 'TxtEmail',
        'user_hirlevel' => 'ChkHirlevel',
        'user_aktiv' => 'ChkAktiv',
        'nyelv_id' => 'SelNyelv'
    );
    
    public function __addForm()
    {
        parent::__addForm();
        // Vezetéknév.
        $lastname = $this->addItem('TxtVnev');
        $lastname->_verify['string'] = true;
        $firstname = $this->addItem('TxtKnev');
        $firstname->_verify['string'] = true;
        // Kapcsolat nyelve.
        $this->addItem('SelNyelv');
        // Felhasználónév.
        $username = $this->addItem('TxtFnev');
        $username->_verify['string'] = true;
        $username->_verify['unique'] = array(
            'table' => 'user',
            'field' => 'user_fnev',
            'modify' => $this->modifyID, 
            'DB' => $this->_DB
        );
        // Jelszó.
        $this->addItem('Password');
        $this->addItem('Password2');
        // E-mail cím.
        $email = $this->addItem('TxtEmail');
        $email->_verify['string'] = true;
        $email->_verify['email'] = true;
        $email->_verify['unique'] = array(
            'table' => 'user',
            'field' => 'user_email',
            'modify' => $this->modifyID, 
            'DB' => $this->_DB
        );
        // Hírlevél.
        $newsletter = $this->addItem('ChkHirlevel');
        $newsletter->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
    public function __newData()
    {
        parent::__newData();
        $this->_params['ChkHirlevel']->_value = 1;
        $this->_params['SelNyelv']->_value = Rimo::$_config->ADMIN_NYELV_ID;
    }
    /**
     * Jelszó ellenőrzés.
     * @return array
     */
    public function verifyPw()
    {
        $this->_params['Password']->_verify['string'] = true;
        $this->_params['Password2']->_verify['string'] = true;
        $this->_params['Password2']->_verify['equalTo'] = $this->_params['Password'];
        return array($this->_params['Password2'], $this->_params['Password']);
    }
    /**
     * Felhasználóhoz tartozó kép törlése.
     * @param string $file_name Kép neve.
     */
    public function deleteKep($file_name)
    {
        $query = "UPDATE {$this->_tableName} SET user_kep_nev='' WHERE user_id = '{$this->modifyID}' LIMIT 1";
        $this->_DB->prepare($query)->query_update();
        @unlink("modul/" . Rimo::$_config->APP_PATH . "/upload/" . $file_name);
    }
}