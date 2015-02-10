<?php

class AttachedUser extends \DbInjectAbstract implements \AttachedUserInterface
{
    /**
     * Site user edit helper.
     * @var \ModelEditHelper
     */
    protected $modelEditHelper;
    
    public function __construct(\MYSQL_DB $db, \ModelEditHelper $modelEditHelper)
    {
        $this->setDb($db);
        $this->setModelEditHelper($modelEditHelper);
    }
    
    public function save(array &$params, $userId, $id)
    {
        $this->overrideParams($params);
    }
    
    public function overrideParams(&$params)
    {
        // Paraméterek felülírása, ha szükséges.
    }
    
    public function getModelEditHelper()
    {
        return $this->modelEditHelper;
    }
    
    public function setModelEditHelper(\ModelEditHelper $modelEditHelper)
    {
        $this->modelEditHelper = $modelEditHelper;
    }
}