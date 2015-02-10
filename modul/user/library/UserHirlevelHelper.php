<?php

class UserHirlevelHelper extends \DbInjectAbstract
{
    /**
     * Hírlevél fel-és leiratkozás.
     * @param int $userId Felhasználó azonosító.
     * @param \Item[] $params Item tömb.
     */
    public function hirlevelUser($userId, &$params)
    {
        $userId = (int)$userId;
        try {
            $this->updateNewsletterFieldByUserId($params['ChkHirlevel']->_value, $userId);
            $query = "SELECT hirlevel_user_id, hirlevel_user_torolt FROM hirlevel_user
                WHERE user_id = " . $userId . " LIMIT 1";
            $hirlevel_user = $this->db->prepare($query)->query_select()->query_fetch_array();
            if ($params['ChkHirlevel']->_value == 1 && $hirlevel_user['hirlevel_user_torolt'] == 1) {
                $query = "UPDATE hirlevel_user 
                    SET hirlevel_user_torolt = 0
                    WHERE hirlevel_user_id = {$hirlevel_user['hirlevel_user_id']} 
                    LIMIT 1";
                $this->db->prepare($query)->query_update();
            } elseif ($params['ChkHirlevel']->_value == 0 && $hirlevel_user['hirlevel_user_torolt'] == 0) {
                $query = "UPDATE hirlevel_user 
                    SET hirlevel_user_torolt = 1
                    WHERE hirlevel_user_id = {$hirlevel_user['hirlevel_user_id']} 
                    LIMIT 1";
                $this->db->prepare($query)->query_update();
            }
            $this->insertHirlevelCsoport($hirlevel_user['hirlevel_user_id']);
        } catch (Exception_MYSQL_Null_Rows $e) {
            if ($params['ChkHirlevel']->_value == 1) {
                $name = $params['TxtVnev']->_value . " " . $params['TxtKnev']->_value;
                $query = "INSERT INTO hirlevel_user 
                    SET hirlevel_user_nev = '" . mysql_real_escape_string($name) . "', 
                        hirlevel_user_email = '" . mysql_real_escape_string($params['TxtEmail']->_value) . "',
                        user_id = " . $userId . ",
                        /*hirlevel_nyelv_id_id = " . mysql_real_escape_string($params['SelNyelv']->_value) . ", */
                        hirlevel_nyelv_id_id = 1, 
                        hirlevel_user_feliratkozas = now()";
                $hirlevel_user_id = $this->db->prepare($query)->query_insert();
                $this->insertHirlevelCsoport($hirlevel_user_id);
            }
        }
    }
    /**
     * Felhasználó hírlevél csoportba tétele.
     * @param int $id Felhasználó azonosító.
     */
    public function insertHirlevelCsoport($id)
    {
        $id = (int)$id;
        try {
            $query = "SELECT hirlevel_csoport_id FROM hirlevel_csoport WHERE hirlevel_csoport_tipus='reg' AND 
                hirlevel_csoport_tipus_nyelv=" . Rimo::$_config->SITE_NYELV_ID . " LIMIT 1";
            $csoport_id = $this->db->prepare($query)->query_select()->query_fetch_array('hirlevel_csoport_id');
            $query = "INSERT INTO hirlevel_user_attr_csoport SET hirlevel_user_id = {$id}, 
                        hirlevel_user_attr_csoport_id = {$csoport_id}";
            $this->db->prepare($query)->query_insert();
        } catch (Exception_MYSQL $e) {
            
        }
    }
    
    public function updateNewsletterFieldByUserId($newsletter, $userId)
    {
        $query = "UPDATE user SET user_hirlevel = " . (int)$newsletter . " 
            WHERE user_id = " . (int)$userId . " LIMIT 1";
        $this->db->prepare("UPDATE user SET user_hirlevel = " . (int)$newsletter . " 
            WHERE user_id = " . (int)$userId . " LIMIT 1")->query_execute();
    }
}