<?php

abstract class AttachedUserInsert extends \AttachedUser implements \AttachedUserInsertInterface
{
    public function overrideParams(&$params)
    {
        $params['Password']->_value = Create::passwordGenerator($params['Password']->_value, Rimo::$_config->SALT);
    }
    
    public function save(array &$params, $userId, $id)
    {
        parent::save($params, $userId, $id);
        $userId = $this->insertUser(
            $params['TxtFnev']->_value,
            $params['Password']->_value,
            $params['TxtEmail']->_value,
            $params['TxtVnev']->_value,
            $params['TxtKnev']->_value
        );
        $this->insertRightGroup($userId, $this->rightGroupId());
        $attachedId = $this->insertAttachable($params, $userId, $id);
        $this->attachTo($userId, $attachedId);
        return $userId;
    }
    /**
     * Menti a felhasználót a paraméterül adott jogcsoportba.
     * @param int $userId Felhasználó azonosító.
     * @param int $rightGroupId Jogcsoport azonosító.
     */
    public function insertRightGroup($userId, $rightGroupId)
    {
        $this->db->prepare("INSERT INTO user_jogcsoport 
            (user_id, user_jogcsoport_id) 
            VALUES 
            (" . (int)$userId . ", " . (int)$rightGroupId . ")")->query_insert();
    }
    /**
     * Menti a felhasználót.
     * @param type $username
     * @param type $password
     * @param type $email
     * @param type $lastname
     * @param type $firstname
     * @return int
     */
    public function insertUser($username, $password, $email, $lastname, $firstname)
    {
        return $this->db->prepare("INSERT INTO user 
            (
                user_fnev, 
                user_email, 
                user_jelszo, 
                user_vnev, 
                user_knev, 
                user_reg_date, 
                user_megerositve,
                user_megerositve_date, 
                user_last_login, 
                user_szum_login, 
                user_aktiv,
                user_torolt
            ) 
            VALUES 
            (
                '" . mysql_real_escape_string($username) . "', 
                '" . mysql_real_escape_string($email) . "', 
                '" . mysql_real_escape_string($password) . "',
                '" . mysql_real_escape_string($lastname) . "', 
                '" . mysql_real_escape_string($firstname) . "', 
                '" . date('Y-m-d H:i:s') . "',
                0,
                0,
                0, 
                0, 
                1,
                0
            )")->query_insert();
    }
}