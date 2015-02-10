<?php

abstract class AttachedUserUpdate extends \AttachedUser implements \AttachedUserUpdateInterface
{
    public function overrideParams(&$params)
    {
        $password = null;
        if ($params['Password']->_value != '') {
            $password = Create::passwordGenerator($params['Password']->_value, Rimo::$_config->SALT);
        }
        $params['Password']->_value = $password;
    }
    
    public function save(array &$params, $userId, $id)
    {
        parent::save($params, $userId, $id);
        $this->updateUser(
            $params['TxtFnev']->_value,
            $params['Password']->_value,
            $params['TxtEmail']->_value,
            $params['TxtVnev']->_value,
            $params['TxtKnev']->_value,
            $userId
        );
        $this->updateAttached($params, $userId, $id);
        return $userId;
    }
    
    public function updateUser($username, $password, $email, $lastname, $firstname, $userId)
    {
        $query = "UPDATE user SET 
            user_fnev = '" . mysql_real_escape_string($username) . "', 
            user_email = '" . mysql_real_escape_string($email) . "', 
            user_vnev = '" . mysql_real_escape_string($lastname) . "', 
            user_knev = '" . mysql_real_escape_string($firstname) . "'";
        if (!is_null($password)) {
            $query .= ", user_jelszo = '" . mysql_real_escape_string($password) . "'";
        }
        $query .= " WHERE user_id = " . (int)$userId . " LIMIT 1";
        $this->db->prepare($query)->query_execute();
    }
}