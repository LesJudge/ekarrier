<?php

abstract class AttachableUserModelAbstract extends \BaseAdminUserEditModel implements \AttachableUserModelInterface
{
    /**
     *
     * @var int
     */
    protected $attachedId;
    /**
     *
     * @var \AttachedUserInsertInterface
     */
    protected $attacher;
    /**
     *
     * @var \AttachedUserUpdateInterface
     */
    protected $attached;
    /**
     *
     * @var \AttachedUserFinderInterface
     */
    protected $finder;
    
    public function __formValues()
    {
        $user = $this->findUser($this->getUserId());
        $this->_params['TxtFnev']->_value = $user['user_fnev'];
        $this->_params['TxtVnev']->_value = $user['user_vnev'];
        $this->_params['TxtKnev']->_value = $user['user_knev'];
        $this->_params['TxtEmail']->_value = $user['user_email'];
        $this->_params['ChkHirlevel']->_value = $user['user_hirlevel'];
        $this->finder->findAndSet($this->attachedId, $this->_params);
    }
    /**
     * Visszatér a felhasználó azonosítóval.
     * @return int
     */
    public function getUserId()
    {
        return UserLoginOut_Site_Controller::$_id;
    }
    /**
     * Felhasználó azonosító alapján lekérdezi a felhasználó adatait.
     * @param int $userId Felhasználó azonosító.
     * @return array
     */
    public function findUser($userId)
    {
        $query = "SELECT 
            user_id, nyelv_id, user_fnev, user_email, user_vnev, user_knev, user_kep_nev, user_hirlevel
            FROM user WHERE user_id = " . (int)$userId . " AND 
                user_megerositve = 1 AND 
                user_aktiv = 1 AND 
                user_torolt = 0";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function setAttacher(\AttachedUserInsertInterface $attacher)
    {
        $this->attacher = $attacher;
    }
    
    public function setAttached(\AttachedUserUpdateInterface $attached)
    {
        $this->attached = $attached;
    }
    
    public function setFinder(\AttachedUserFinderInterface $finder)
    {
        $this->finder = $finder;
    }
    
    public function getAttachedId()
    {
        return $this->attachedId;
    }
    
    public function setAttachedId($id)
    {
        $this->attachedId = (int)$id;
    }
}