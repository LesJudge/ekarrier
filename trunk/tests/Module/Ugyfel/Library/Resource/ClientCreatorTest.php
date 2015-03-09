<?php
use Uniweb\Module\Ugyfel\Library\Resource\Creator;

class ClientCreatorTest extends ActiveRecordTestCase
{
    protected $creator;
    
    public function testDoesItCreateNewInstanceOnValidGetRequest()
    {
        $request = array(
            'GET' => array(
                'id' => null
            ),
            'SERVER' => array(
                'REQUEST_METHOD' => 'GET'
            )
        );
        $client = $this->creator->createFromGlobals($request);
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client', $client);
        $this->assertTrue($client->is_new_record());
    }
    
    public function testDoesItFindClientOnValidGetRequest()
    {
        $request = array(
            'GET' => array(
                'id' => 1
            ),
            'SERVER' => array(
                'REQUEST_METHOD' => 'GET'
            )
        );
        $client = $this->creator->createFromGlobals($request);
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client', $client);
        $this->assertFalse($client->is_new_record());
        $this->assertEquals(1, $client->ugyfel_id);
        $this->assertEquals('Teszt', $client->vezeteknev);
        $this->assertEquals('Ügyfél 1', $client->keresztnev);
    }
    
    public function testDoesItCreateNewInstanceOnValidPostRequest()
    {
        $request = array(
            'GET' => array(
                'id' => null
            ),
            'POST' => array(
                'resource' => array(
                    'email' => 'foobar@uniweb.hu',
                    'keresztnev' => 'Bar',
                    'vezeteknev' => 'Foo'
                )
            ),
            'SERVER' => array(
                'REQUEST_METHOD' => 'POST'
            )
        );
        $client = $this->creator->createFromGlobals($request);
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client', $client);
        $this->assertTrue($client->is_new_record());
        $this->assertEquals('foobar@uniweb.hu', $client->email);
        $this->assertEquals('Bar', $client->keresztnev);
        $this->assertEquals('Foo', $client->vezeteknev);
    }
    
    public function testDoesItFindAndUpdateClientAttributesOnValidPostRequest()
    {
        $request = array(
            'GET' => array(
                'id' => 1
            ),
            'POST' => array(
                'resource' => array(
                    'email' => 'foobar@uniweb.hu'
                )
            ),
            'SERVER' => array(
                'REQUEST_METHOD' => 'POST'
            )
        );
        $client = $this->creator->createFromGlobals($request);
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client', $client);
        $this->assertFalse($client->is_new_record());
        $this->assertEquals('foobar@uniweb.hu', $client->email);
        $this->assertEquals('Ügyfél 1', $client->keresztnev);
        $this->assertEquals('Teszt', $client->vezeteknev);
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\CreatorException
     * @expectedExceptionMessage A keresett ügyfél nem található!
     */
    public function testDoesItThrowClientNotFoundExceptionOnInvisibleClient()
    {
        $request = array(
            'GET' => array(
                'id' => 3
            )
        );
        $this->creator->createFromGlobals($request);
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\CreatorException
     * @expectedExceptionMessage A keresett ügyfél nem található!
     */    
    public function testDoesItThrowClientNotFoundExceptionOnDeletedClient()
    {
        $request = array(
            'GET' => array(
                'id' => 4
            )
        );
        $this->creator->createFromGlobals($request);
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\CreatorException
     * @expectedExceptionMessage Végzetes hiba lépett fel az ügyfél űrlap generálása során!
     */    
    public function testDoesItThrowFatalErrorExceptionOnInvalidClass()
    {
        $request = array(
            'GET' => array(
                'id' => null
            )
        );
        Creator::$factoryClass = '\\InvalidClientResourceModel';
        Creator::createFromGlobals($request);
    }
    /**
     * @expectedException \Uniweb\Library\Resource\Exception\CreatorException
     * @expectedExceptionMessage Végzetes hiba lépett fel az ügyfél űrlap generálása során!
     */
    public function testDoesItThrowFatalErrorExceptionOnNotExistingClass()
    {
        $request = array(
            'GET' => array(
                'id' => null
            )
        );
        Creator::$factoryClass = '\\Not\\Existing\\Class';
        Creator::createFromGlobals($request);
    }
    
    protected function setUp()
    {
        $pdo = $this->getConnection()->getConnection();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
        parent::setUp();
        $this->creator = new Creator;
    }
    
    public function tearDown()
    {
        $pdo = $this->getConnection()->getConnection();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
        parent::tearDown();
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