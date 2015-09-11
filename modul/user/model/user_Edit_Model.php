<?php

class User_Edit_Model extends BaseAdminUserEditModel
{
    /**
     * UserHirlevelHelper objektum.
     * @var \UserHirlevelHelper
     */
    protected $userHirlevelHelper;
    
    public function __construct()
    {
        parent::__construct();
        $this->userHirlevelHelper = new \UserHirlevelHelper($this->_DB);
    }
    
    public function __addForm()
    {
        parent::__addForm();
        $nyelv = $this->addItem('SelNyelv');
        $nyelv->_select_value = $this->getSelectValues(
            'nyelv', 
            'nyelv_nev', 
            '', 
            '', 
            false
        );
        if ($this->modifyID != 1) {
            //$jogcsoport_where = ' AND jogcsoport_id != 1';
            $jogcsoport_where = ' AND jogcsoport_id NOT IN (
                ' . RimoConfig::ROOT_RG . ', ' . RimoConfig::USER_RG . ', ' . RimoConfig::COMPANY_RG . ')';
        }
        $jogcsoport = $this->addItem('SelGroup');
        $jogcsoport->_select_value = $this->getSelectValues(
            'jogcsoport', 
            'jogcsoport_nev', 
            $jogcsoport_where, 
            '', 
            false
        );
        $jogcsoport->_verify['multiSelect'] = true;
        /* Hírlevél */
        $this->addItem('ChkHirlevel')->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        // Tanácsadó-e.
        $this->addItem('SelTanacsado')->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }

    public function __editData()
    {
        $query = "SELECT DATE_FORMAT( user_reg_date,'%Y-%m-%d %H:%i') AS  user_reg_date,
                         DATE_FORMAT(user_megerositve_date,'%Y-%m-%d %H:%i') AS user_megerositve_date,
                         user_megerositve, 
                         DATE_FORMAT(user_last_login,'%Y-%m-%d %H:%i') AS user_last_login, 
                         user_szum_login,
                         user_kep_nev
                  FROM {$this->_tableName}
                  WHERE user_id='{$this->modifyID}' LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        if (UserLoginOut_Controller::$_rights["__loadController"]["user_cim"])
            $data["cim_user_id"] = $this->modifyID;
        return $data;
    }

    public function __formValues()
    {
        parent::__formValues();
        $this->_params["SelGroup"]->_value = $this->getSelectAktivValues("user_jogcsoport");
    }

    public function __update($sets = "")
    {
        if (!empty($this->_params["Password"]->_value)) {
            $jelszo = " ,user_jelszo='" . Create::passwordGenerator($this->_params["Password"]->_value, Rimo::$_config->SALT) . "'";
        }
        $this->saveSelect("user_jogcsoport", $this->_params["SelGroup"]->_value, $this->modifyID);
        //$this->hirlevelUser($this->modifyID, $this->_params);
        $this->userHirlevelHelper->hirlevelUser($this->modifyID, $this->_params);
        parent::__update("{$sets} {$jelszo}");
    }

    public function __insert($sets = "")
    {
        $jelszo = " ,user_jelszo='" . Create::passwordGenerator($this->_params["Password"]->_value, Rimo::$_config->SALT) . "'";
        parent::__insert("{$sets} {$jelszo}, user_reg_date=now(), user_megerositve=1, user_megerositve_date=now()");
        $this->saveSelect("user_jogcsoport", $this->_params['SelGroup']->_value, $this->insertID);
        //$this->hirlevelUser($this->insertID, $this->_params);
        $this->userHirlevelHelper->hirlevelUser($this->insertID, $this->_params);
    }
}