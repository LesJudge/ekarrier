<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

class ClientModelTest extends ActiveRecordTestCase
{
    
    public function testValidateRequiredFields()
    {
        $client = new Client;
        $this->assertFalse($client->is_valid());
        
        $client->vezeteknev = 'Vezetéknév';
        $client->keresztnev = 'Keresztnév';
        $client->email = 'vezeteknev@keresztnev.com';
        $this->assertTrue($client->is_valid());
        
        return $client;
    }
    /**
     * @depends testValidateRequiredFields
     */
    public function testDoesItSaveValidClient($client)
    {
        $saved = $client->save();
        $this->assertTrue($saved);
        
        $this->assertEquals(5, $this->getConnection()->getRowCount('ugyfel'));
    }
    
    protected function getDataSet()
    {
        return $this->createXMLDataSet('./tests/Client/dataset/Ugyfel.xml');
    }
    
    protected function getTearDownOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE();
    }
}