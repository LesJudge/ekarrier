<?php
/**
 * Alap felhasználó listázás.
 */
abstract class BaseAdminUserListModel extends DynamicFiltersModel
{
    /**
     * Tábla neve.
     * @var string 
     */
    public $_tableName = 'user';
    /**
     * Kiválasztott mezők.
     * @var string 
     */
    public $_fields = 'user.user_id AS ID, user_fnev AS elso, user_email, CONCAT(user_vnev,\' \', user_knev) AS Nev, 
                       user_reg_date, user_last_login, user_megerositve, user_megerositve_date, user_aktiv AS Aktiv';

    public function __construct($sessionKey)
    {
        parent::__construct($sessionKey);
        $this->initModel();
        $this->tableHeader = $this->tableHeader();
    }
    /**
     * Szokásos __addForm() metódus.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->_params['TxtSort']->_value = 'user_reg_date__DESC';
        $this->addItem('FilterStatus')->_select_value = array(
            0 => '--Válasszon állapotot--',
            1 => 'Teljes körű tag',
            2 => 'Nem teljes körű tag'
        );
    }
    /**
     * Törli a felhasználót a hírlevélre feliratkozottak közül.
     * @param int $user_id Felhasználó azonosító.
     */
    public function delHirlevelUser($user_id)
    {
        $query = "UPDATE hirlevel_user SET hirlevel_user_torolt = 1 WHERE user_id = " . (int)$user_id . " LIMIT 1";
        $this->_DB->prepare($query)->query_update();
    }
    /**
     * A $tableHeader attribútum értékének beállítása.
     * @return array
     */
    protected function tableHeader()
    {
        return array(
            'user_fnev' => array('label' => 'Felhasználónév', 'width' => 25),
            'user_email' => array('label' => 'E-mail cím', 'width' => 15),
            'user_vnev' => array('label' => 'Név', 'width' => 25),
            'user_reg_date' => array('label' => 'Regisztráció dátuma', 'width' => 10),
            'user_last_login' => array('label' => 'Utoljára belépve', 'width' => 10),
            'user_megerositve' => array('label' => 'Megerősítés', 'width' => 10),
            'user_aktiv' => array('label' => 'Státusz', 'width' => 8)
        );
    }
    /**
     * Cég kapcsolat LEFT JOIN hozzáadása a lekérdezéshez.
     */
    protected function joinUserCompany()
    {
        $this->_join = $this->_join . ' LEFT JOIN user_ceg uc ON user.user_id = uc.user_id';
    }
    /**
     * Jogcsoport kapcsoalt INNER JOIN hozzáadása a lekérdezéshez.
     */
    protected function joinRightgroup()
    {
        $this->_join = $this->_join . ' INNER JOIN user_jogcsoport ug ON user.user_id = ug.user_id';
    }
    /**
     * Model inicializálása.
     */
    abstract protected function initModel();
}