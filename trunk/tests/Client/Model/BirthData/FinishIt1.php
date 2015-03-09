<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData;

class BirthDataTest extends ActiveRecordTestCase
{
    
    public function testCanISaveInstanceWhenEverythingIsFine()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 4;
        $birthData->letrehozo_id = 1;
        $birthData->modosito_id = 1;
        $birthData->modositas_szama = 0;
        
        $this->assertTrue($birthData->save());
        
        /* @var $found BirthData */
        $found = BirthData::find(4);
        $this->assertInstanceOf('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\BirthData', $found);
        $this->assertEquals(4, $found->ugyfel_id);
        $this->assertEquals(1, $found->letrehozo_id);
        $this->assertEquals(1, $found->modosito_id);
        $this->assertEquals(0, $found->modositas_szama);
    }
    /**
     * 
     * @param type $data
     * @param type $expected
     * @dataProvider validDataProvider
     */
    public function testDoesItSetAttributeValuesCorrectlyViaSetAttributes($data, $expected)
    {
        $birthData = new BirthData;
        $birthData->set_attributes($data);
        
        foreach ($expected as $attribute => $value) {
            $this->assertEquals($value, $birthData->{$attribute});
        }
    }
    /**
     * 
     * @param type $data
     * @param type $expected
     * @dataProvider validDataProvider
     */
    public function testDoesItSetAttributeValuesCorrectlyViaAssignment($data, $expected)
    {
        $birthData = new BirthData;
        foreach ($data as $attribute => $value) {
            $birthData->{$attribute} = $value;
        }
        foreach ($expected as $attribute => $value) {
            $this->assertEquals($value, $birthData->{$attribute});
        }
    }
    /**
     * 
     * @param type $data
     * @param type $expected
     * @dataProvider saveNewRecordProvider
     */
    public function testDoesItCreateRecordsViaCreateMethod($data, $expected)
    {
        $pdo = $this->getConnection()->getConnection();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_szuletesi_adatok;');
        
        $birthData = BirthData::create($data);
        $this->assertInstanceOf($this->getModelName('Ugyfel.BirthData'), $birthData);
        foreach ($expected as $attribute => $value) {
            $this->assertEquals($value, $birthData->{$attribute});
        }
    }
    
    public function saveNewRecordProvider()
    {
        return array_slice($this->validDataProvider(), 0, 1);
    }
    /**
     * @expectedException \ActiveRecord\DatabaseException
     * @expectedExceptionMessage FOREIGN KEY (`ugyfel_id`)
     */
    public function testDoesItThrowDatabaseExceptionOnForeignKeyConstraintUgyfelId()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 5;
        $birthData->letrehozo_id = 1;
        $birthData->modosito_id = 1;
        $birthData->modositas_szama = 0;
        $birthData->save();
    }
    /**
     * @expectedException \ActiveRecord\DatabaseException
     * @expectedExceptionMessage FOREIGN KEY (`letrehozo_id`)
     */    
    public function testDoesItThrowDatabaseExceptionOnForeignKeyConstraintLetrehozoIdWhenUserDoesNotExists()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 4;
        $birthData->letrehozo_id = 1000;
        $birthData->modosito_id = 1;
        $birthData->modositas_szama = 0;
        $birthData->save();
    }
    /**
     * @expectedException \ActiveRecord\DatabaseException
     * @expectedExceptionMessage FOREIGN KEY (`letrehozo_id`)
     */    
    public function testDoesItThrowDatabaseExceptionOnForeignKeyConstraintLetrehozoIdWhenUserIdIsNotDefined()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 4;
        $birthData->modosito_id = 1;
        $birthData->modositas_szama = 0;
        $birthData->save();
    }
    /**
     * @expectedException \ActiveRecord\DatabaseException
     * @expectedExceptionMessage FOREIGN KEY (`modosito_id`)
     */    
    public function testDoesItThrowDatabaseExceptionOnForeignKeyConstraintModositoIdWhenUserDoesNotExists()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 4;
        $birthData->letrehozo_id = 1;
        $birthData->modosito_id = 1000;
        $birthData->modositas_szama = 0;
        $birthData->save();
    }
    /**
     * @expectedException \ActiveRecord\DatabaseException
     * @expectedExceptionMessage FOREIGN KEY (`modosito_id`)
     */    
    public function testDoesItThrowDatabaseExceptionOnForeignKeyConstraintModositoIdWhenUserIdIsNotDefined()
    {
        $birthData = new BirthData;
        $birthData->ugyfel_id = 4;
        $birthData->letrehozo_id = 1;
        $birthData->modositas_szama = 0;
        $birthData->save();
    }
    /**
     * 
     * @param type $data
     * @param type $errors
     * @dataProvider invalidDataProvider
     */
    public function testDoesNewInstanceFailOnValidationOnInvalidData($data, $errors)
    {
        $birthData = new BirthData;
        foreach ($data as $attribute => $value) {
            $birthData->{$attribute} = $value;
        }
        $this->assertFalse($birthData->is_valid());
        
        foreach ($errors as $attribute => $message) {
            $this->assertEquals($message, $birthData->errors->on($attribute));
        }
    }
    /**
     * 
     * @param type $data
     * @dataProvider validDataProvider
     */
    public function testDoesNewInstancePassOnValidationOnValidData($data)
    {
        $birthData = new BirthData;
        foreach ($data as $attribute => $value) {
            $birthData->{$attribute} = $value;
        }
        $this->assertTrue($birthData->is_valid());
    }
    
    public function invalidDataProvider()
    {
        return array(
            array(
                array(
                    'ugyfel_id' => 'x'
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => null,
                    'orszag_id' => null,
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'ugyfel_id' => -1,
                    'orszag_id' => 1.5
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => null,
                    'orszag_id' => 'Az ország azonosító nem megfelelő!',
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'ugyfel_id' => 0,
                    'orszag_id' => true,
                    'varos_id' => new stdClass
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => null,
                    'orszag_id' => 'Az ország azonosító nem megfelelő!',
                    'varos_id' => 'A város azonosító nem megfelelő!',
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'vezeteknev' => 'x',
                    'keresztnev' => str_repeat('a', 129)
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => 'A vezetéknév túl rövid, legalább 3 karakter hosszúnak kell lennie!',
                    'keresztnev' => 'A keresztnév túl hosszú, legfeljebb 128 karakter hosszú lehet!',
                    'orszag_id' => null,
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'keresztnev' => 'x',
                    'vezeteknev' => str_repeat('a', 129)
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'keresztnev' => 'A keresztnév túl rövid, legalább 3 karakter hosszúnak kell lennie!',
                    'vezeteknev' => 'A vezetéknév túl hosszú, legfeljebb 128 karakter hosszú lehet!',
                    'orszag_id' => null,
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'keresztnev' => 'Pista',
                    'vezeteknev' => 'Kiss',
                    'orszag_id' => -1
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => null,
                    'orszag_id' => 'Az ország azonosító nem megfelelő!',
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'keresztnev' => '     K'
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => 'A keresztnév túl rövid, legalább 3 karakter hosszúnak kell lennie!',
                    'orszag_id' => null,
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => null,
                    'modosito_id' => null,
                    'modositas_szama' => null
                )
            ),
            array(
                array(
                    'letrehozo_id' => 0,
                    'modosito_id' => false,
                    'modositas_szama' => -1
                ),
                array(
                    'ugyfel_id' => 'Az ügyfél azonosító nem megfelelő!',
                    'vezeteknev' => null,
                    'keresztnev' => null,
                    'orszag_id' => null,
                    'varos_id' => null,
                    'szuletesi_ido' => null,
                    'letrehozas_timestamp' => null,
                    'modositas_timestamp' => null,
                    'letrehozo_id' => 'A létrehozó felhasználó azonosító nem megfelelő!',
                    'modosito_id' => 'A módosító felhasználó azonosító nem megfelelő!',
                    'modositas_szama' => 'A módosítás száma nem megfelelő!'
                )
            )
        );
    }
    
    public function validDataProvider()
    {
        return array(
            array(
                array(
                    'ugyfel_id' => 1,
                    'orszag_id' => 1,
                    'varos_id' => 1,
                    'vezeteknev' => 'Kiss-Nagy',
                    'keresztnev' => 'Pista',
                    'letrehozo_id' => 1,
                    'modosito_id' => 2,
                    'modositas_szama' => 0
                ),
                array(
                    'ugyfel_id' => 1,
                    'orszag_id' => 1,
                    'varos_id' => 1,
                    'vezeteknev' => 'Kiss-Nagy',
                    'keresztnev' => 'Pista',
                    'letrehozo_id' => 1,
                    'modosito_id' => 2,
                    'modositas_szama' => 0                    
                )
            ),
            array(
                array(
                    'ugyfel_id' => 2,
                    'orszag_id' => null,
                    'varos_id' => null,
                    'vezeteknev' => '',
                    'keresztnev' => ''
                ),
                array(
                    'ugyfel_id' => 2,
                    'orszag_id' => null,
                    'varos_id' => null,
                    'vezeteknev' => '',
                    'keresztnev' => ''
                )
            ),
            array(
                array(
                    'ugyfel_id' => 3,
                    'orszag_id' => 2,
                    'varos_id' => 2
                ),
                array(
                    'ugyfel_id' => 3,
                    'orszag_id' => 2,
                    'varos_id' => 2                    
                )
            ),
            array(
                array(
                    'ugyfel_id' => 4,
                    'vezeteknev' => '   Vezetéknév'
                ),
                array(
                    'ugyfel_id' => 4,
                    'vezeteknev' => 'Vezetéknév'
                )
            ),
            array(
                array(
                    'ugyfel_id' => 1,
                    'letrehozo_id' => 1,
                    'modosito_id' => 2000
                ),
                array(
                    'ugyfel_id' => 1,
                    'letrehozo_id' => 1,
                    'modosito_id' => 2000                    
                )
            ),
            array(
                array(
                    'ugyfel_id' => 1,
                    'vezeteknev' => 'Király     Gróf',
                    'keresztnev' => 'Béla'
                ),
                array(
                    'ugyfel_id' => 1,
                    'vezeteknev' => 'Király Gróf',
                    'keresztnev' => 'Béla'
                )
            )
        );
    }
}