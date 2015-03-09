<?php
namespace Tests\Uniweb\TestCase;
use Tests\Uniweb\TestCase\DatabaseTestCase;
use ActiveRecord\Config;

abstract class ActiveRecordTestCase extends DatabaseTestCase
{
    protected $modelNames = array();
    
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->modelNames['Ugyfel.Client'] = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client';
        $this->modelNames['Ugyfel.BirthData'] = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\BirthData';
        $this->modelNames['Ugyfel.ClientStatus'] = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ClientStatus';
        $this->modelNames['Ugyfel.LaborMarket'] = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\LaborMarket';
        $this->modelNames['Ugyfel.Status'] = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Status';
        $this->modelNames['User.User'] = '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User';
        $this->modelNames['Cim.Country'] = '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\Country';
        $this->modelNames['Cim.City'] = '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\City';
    }
    
    public function addModelName($key, $modelName)
    {
        $this->modelNames[$key] = $modelName;
    }
    
    public function getModelName($key)
    {
        return isset($this->modelNames[$key]) ? $this->modelNames[$key] : null;
    }
    
    public function getConnection()
    {
        $connection = parent::getConnection();
        
        $activeRecordDsn = sprintf(
            $GLOBALS['activeRecordDsn'], 
            $GLOBALS['testDbUsername'], 
            $GLOBALS['testDbPassword'], 
            $GLOBALS['testDbHost'], 
            $GLOBALS['testDbDatabaseName'],
            $GLOBALS['testDbCharset']
        );
        
        Config::initialize(function($config) use ($activeRecordDsn) {
            $config->set_connections(array(
                'test' => $activeRecordDsn
            ));
            $config->set_default_connection('test');
        });
        
        return $connection;
    }
}