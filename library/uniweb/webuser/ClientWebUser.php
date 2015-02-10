<?php

class ClientWebUser extends \SpecifiedWebUserAbstract
{
    /**
     * Lekérdezi a felhasználóhoz tartozó ügyfél azonosítót.
     * @param int $userId Felhasználó azonosító.
     * @return int
     * @throws \Exception_MYSQL_Null_Rows
     */
    public function findByUserId($userId)
    {
        return $this->findId('user_ugyfel', 'ugyfel_id', $userId);
    }
}