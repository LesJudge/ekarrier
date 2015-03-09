<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Address;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Address\DwellingPlace;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Address\Residence;
use PHPUnit_Extensions_Database_DataSet_XmlDataSet;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;

class CrudTest extends ActiveRecordTestCase
{
    public function testDoesFindWorkCorrectly()
    {
        $addressData = $this->addressData();
        
        Residence::create($addressData); // Ügyfél 1 lakcím 1.
        DwellingPlace::create($addressData); // Ügyfél 1 tartózkodási hely 1
        
        Residence::find('all', array(
            'conditions' => array(
                'ugyfel_id = ?', 1
            )
        ));
        Residence::find('first', array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        //Residence::find_by_ugyfel_id(1);
        
        $residence = Residence::create($addressData); // Ügyfél 1 lakcím 2
        $lastId = $residence->ugyfel_attr_cim_id;
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_attr_cim_id = ' . $lastId
        ));
        
        Residence::create($addressData); // Ügyfél 1 lakcím 3
        
        DwellingPlace::create($addressData);
        $secondClientResidence = $addressData;
        $secondClientResidence['ugyfel_id'] = 2;
        Residence::create($secondClientResidence);
        DwellingPlace::create($secondClientResidence);
        
        $firstClientResidences = Residence::find('all', array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        
        $secondClientResidences = Residence::find('all', array(
            'conditions' => array(
                'ugyfel_id' => 2
            )
        ));
        
        $this->assertEquals(3, count($firstClientResidences));
        $this->assertEquals(1, count($secondClientResidences));
        
        $lastDp = DwellingPlace::last();
        $lastRes = Residence::last();
        
        $this->assertNotEquals($secondClientResidences[0]->ugyfel_attr_cim_id, $lastDp->ugyfel_attr_cim_id);
        
        $this->assertNotEquals($lastDp->ugyfel_attr_cim_id, $lastRes->ugyfel_attr_cim_id);
        
        $firstRes = Residence::first();
        $firstDp = DwellingPlace::first();
        
        $this->assertNotEquals($firstRes->ugyfel_attr_cim_id, $firstDp->ugyfel_attr_cim_id);
    }
    
    public function testDoesCountWorkCorrectly()
    {
        $addressData = $this->addressData();
        
        Residence::create($addressData);
        Residence::create($addressData);
        
        $residences = Residence::all();
        
        $this->assertEquals(2, count($residences));
        $this->assertEquals(2, Residence::count());
        
        $count1 = Residence::count(array(
            'conditions' => array(
                'ugyfel_id = ?', 1
            )
        ));
        $count2 = Residence::count(array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        $count3 = Residence::count(array(
            'conditions' => array(
                'ugyfel_id = ?', 2
            )
        ));
        $count4 = Residence::count_by_ugyfel_id(1);
        
        $secondClientResidence = $addressData;
        $secondClientResidence['ugyfel_id'] = 2;
        Residence::create($secondClientResidence);
        
        $this->assertEquals(2, $count1);
        $this->assertEquals(2, $count2);
        $this->assertEquals(0, $count3);
        $this->assertEquals(2, $count4);
    }
    
    public function testDoesItCreateNewAddressWithCorrectType()
    {
        $residence = new Residence;
        $residence->ugyfel_id = 1;
        $residence->cim_orszag_id = 1;
        $residence->cim_varos_id = 1;
        $residence->cim_megye_id = 1;
        $residence->cim_iranyitoszam_id = 1;
        $residence->utca = 'Utca1';
        $residence->hazszam;
        $residence->letrehozo_id = 1;
        $residence->modosito_id = 1;
        $residence->save();
        
        $this->assertNull(DwellingPlace::find('first', array(
            'conditions' => array(
                'ugyfel_attr_cim_id = ?', 1
            )
        )));
        
        $dwellingPlace = new DwellingPlace;
        $dwellingPlace->ugyfel_id = 1;
        $dwellingPlace->cim_orszag_id = 1;
        $dwellingPlace->cim_varos_id = 1;
        $dwellingPlace->cim_megye_id = 1;
        $dwellingPlace->cim_iranyitoszam_id = 1;
        $dwellingPlace->utca = 'Utca2';
        $dwellingPlace->hazszam;
        $dwellingPlace->letrehozo_id = 1;
        $dwellingPlace->modosito_id = 1;
        $dwellingPlace->save();
        
        $this->assertEquals(2, $this->getConnection()->getRowCount('ugyfel_attr_cim'));
        
        $residenceFromDb = Residence::find(1);
        $this->assertEquals(1, $residenceFromDb->ugyfel_cim_tipus_id);
        
        $exceptionThrownDwellingPlace = false;
        try {
            $dpObject = DwellingPlace::find_by_pk(1, array());
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            $exceptionThrownDwellingPlace = true;
        }
        $this->assertTrue($exceptionThrownDwellingPlace);
        
        $exceptionThrownResidence = false;
        try {
            $rObject = Residence::find_by_pk(2, array());
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            $exceptionThrownResidence = true;
        }
        $this->assertTrue($exceptionThrownResidence);
        
        $foundResidence = Residence::find(1, array());
        $foundDwellingPlace = DwellingPlace::find(2, array());
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Address\\Residence', $foundResidence);
        $this->assertInstanceOf(
            '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Address\\DwellingPlace', $foundDwellingPlace
        );
    }
    
    public function testDoesItDeleteAllWorksCorrectly()
    {
        $addressData = $this->addressData();
        // Lakhely hozzáadása.
        Residence::create($addressData);
        // Újabb lakhely hozzáadása.
        Residence::create($addressData);
        // Tartózkodási hely hozzáadása.
        DwellingPlace::create($addressData);
        
        $this->assertEquals(3, $this->getConnection()->getRowCount('ugyfel_attr_cim'));
        $this->assertEquals(2, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2'
        ));
        
        Residence::delete_all(array(
            'conditions' => array(
                'ugyfel_id = ?', 1
            )
        ));
        
        $this->assertEquals(1, $this->getConnection()->getRowCount('ugyfel_attr_cim', 'ugyfel_id = 1'));
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2'
        ));
        
        Residence::create($addressData);
        /* @var $lastResidence \Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\AddressAbstract */
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 
            'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        
        Residence::delete_all(array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        
        $this->assertEquals(0, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2'
        ));
        
        DwellingPlace::delete_all(array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        
        $this->assertEquals(0, $this->getConnection()->getRowCount('ugyfel_attr_cim'));
    }
    
    public function testDoesDeleteWorkCorrectly()
    {
        $residence = Residence::create($this->addressData());
        
        $this->assertEquals(1, $this->getConnection()->getRowCount('ugyfel_attr_cim'));
        
        $residence->delete();
        
        $this->assertEquals(0, $this->getConnection()->getRowCount('ugyfel_attr_cim'));
    }
    
    public function testDoesUpdateAllWorkCorrectly()
    {
        $addressData = $this->addressData();
        
        Residence::create($addressData);
        Residence::create($addressData);
        
        DwellingPlace::create($addressData);
        
        $this->assertEquals(2, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2'
        ));
        
        Residence::update_all(array(
            'set' => array(
                'utca' => 'street'
            ),
            'conditions' => array(
                'ugyfel_id = ?', 1
            )
        ));
        
        $this->assertEquals(2, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1 AND utca LIKE \'street\''
        ));
        
        $this->assertEquals(0, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1 AND utca LIKE \'Utca\''
        ));
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2'
        ));
        
        DwellingPlace::update_all(array(
            'set' => 'hazszam = 11',
            'conditions' => array(
                'ugyfel_id' => 1
            )
        ));
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2 AND hazszam LIKE \'11\''
        ));
        
        $this->assertEquals(0, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 2 AND hazszam LIKE \'10\''
        ));

        $another = $addressData;
        $another['ugyfel_id'] = 2;
        
        Residence::create($another);
        
        $this->assertEquals(2, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 2 AND ugyfel_cim_tipus_id = 1'
        ));
    }
    
    public function testDoesUpdateWorkCorrectly()
    {
        $addressData = $this->addressData();
        
        Residence::create($addressData);
        $residence = Residence::create($addressData);
        
        $lastId = $residence->ugyfel_attr_cim_id;
        
        $this->assertEquals(2, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1'
        ));
        
        $residence->hazszam = 11;
        $residence->save();
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_cim', 'ugyfel_id = 1 AND ugyfel_cim_tipus_id = 1 AND '
                . 'hazszam LIKE \'11\' AND ugyfel_attr_cim_id = ' . $lastId
        ));
    }
    
    protected function addressData()
    {
        return array(
            'ugyfel_id' => 1,
            'cim_orszag_id' => 1,
            'cim_varos_id' => 1,
            'cim_megye_id' => 1,
            'cim_iranyitoszam_id' => 1,
            'utca' => 'Utca',
            'hazszam' => '10',
            'letrehozo_id' => 1,
            'modosito_id' => 1
        );
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasCimTipus.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimOrszag.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimMegye.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimVaros.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimIranyitoszam.xml')
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
    }
    
    public function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();
    }
    
    protected function truncateTables()
    {
        $pdo = $this->getConnection()->getConnection();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $pdo->exec('TRUNCATE TABLE user;');
        $pdo->exec('TRUNCATE TABLE cim_varos;');
        $pdo->exec('TRUNCATE TABLE cim_megye;');
        $pdo->exec('TRUNCATE TABLE cim_orszag;');
        $pdo->exec('TRUNCATE TABLE cim_iranyitoszam;');
        $pdo->exec('TRUNCATE TABLE ugyfel_cim_tipus;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_cim;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
    }
}