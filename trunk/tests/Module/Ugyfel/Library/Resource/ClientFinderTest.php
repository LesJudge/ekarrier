<?php
use Uniweb\Module\Ugyfel\Library\Resource\Finder;

class ClientFinderTest extends ActiveRecordTestCase
{
    public function testDoesItFindExistingClient()
    {
        $client = Finder::find(array('id' => 1));
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client', $client);
        $this->assertEquals(1, $client->ugyfel_id);
        $this->assertEquals('Teszt', $client->vezeteknev);
        $this->assertEquals('Ügyfél 1', $client->keresztnev);
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\ResourceFinderException
     */
    public function testDoesItThrowExceptionOnInactiveClient()
    {
        $client = Finder::find(array('id' => 3));
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\ResourceFinderException
     */    
    public function testDoesItThrowExceptionOnDeletedClient()
    {
        $client = Finder::find(array('id' => 4));
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