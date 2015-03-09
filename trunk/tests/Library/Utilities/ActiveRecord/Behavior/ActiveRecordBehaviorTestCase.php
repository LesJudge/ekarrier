<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;

class ActiveRecordBehaviorTestCase extends ActiveRecordTestCase
{   
    public function setUp()
    {
        parent::setUp();
        $statement = 'CREATE TABLE `ar_behavior_complete` (
            `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
            `value` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
            `creator` int(10) unsigned NOT NULL,
            `modificatory` int(10) unsigned NOT NULL,
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',
            `nom` smallint(5) unsigned NOT NULL DEFAULT \'0\',
            `active` tinyint(3) unsigned NOT NULL DEFAULT \'1\',
            `deleted` tinyint(3) unsigned NOT NULL DEFAULT \'0\',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;';
        $this->getConnection()->getConnection()->exec($statement);
    }
    
    public function tearDown()
    {
        $this->getConnection()->getConnection()->exec('DROP TABLE `ar_behavior_complete`;');
        parent::tearDown();
    }
    
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
    }
}