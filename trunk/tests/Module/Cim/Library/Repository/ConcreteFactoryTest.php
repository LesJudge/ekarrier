<?php
namespace Tests\Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\Repository\ConcreteFactory;
use Uniweb\Module\Cim\Model\ActiveRecord\AddressView;

class ConcreteFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validDataProvider
     */
    public function testValidType($type, $expected)
    {
        $factory = new ConcreteFactory;
        $this->assertInstanceOf($expected, $factory->create($type, new AddressView));
    }
    /**
     * @dataProvider invalidDataProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Nem megfelelő típus!
     */
    public function testInvalidType($type)
    {
        $factory = new ConcreteFactory;
        $factory->create($type, new AddressView);
    }
    
    public function validDataProvider()
    {
        return array(
            array('country', '\\Uniweb\\Module\\Cim\\Library\\Repository\\CountryRepository'),
            array('countries', '\\Uniweb\\Module\\Cim\\Library\\Repository\\CountryRepository')
        );
    }
    
    public function invalidDataProvider()
    {
        return array('x', 'y');
    }
}