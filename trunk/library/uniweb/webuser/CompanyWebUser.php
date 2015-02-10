<?php

class CompanyWebUser extends \SpecifiedWebUserAbstract
{
    public function findByUserId($userId)
    {
        return $this->findId('user_ceg', 'ceg_id', $userId);
    }
}