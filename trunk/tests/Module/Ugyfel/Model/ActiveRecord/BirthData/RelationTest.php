<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Birthdata;
use Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Birthdata\AbstractTestCase;
use Tests\Uniweb\Helper\UserRelationHelper;

class RelationTest extends AbstractTestCase
{
    public function testDoesItHaveCorrectCountryRelationInstance()
    {
        $this->assertInstanceOf($this->getModelName('Cim.Country'), $this->birthDatas[0]->country);
        $this->assertInstanceOf($this->getModelName('Cim.Country'), $this->birthDatas[1]->country);
        $this->assertNull($this->birthDatas[2]->country);
    }
    
    public function testDoesItHaveCorrectCityRelationInstance()
    {
        $this->assertInstanceOf($this->getModelName('Cim.City'), $this->birthDatas[0]->city);
        $this->assertInstanceOf($this->getModelName('Cim.City'), $this->birthDatas[1]->city);
        $this->assertNull($this->birthDatas[2]->city);        
    }
    
    public function testDoesItHaveCorrectCreatorInstance()
    {
        $this->assertInstanceOf($this->getModelName('User.User'), $this->birthDatas[0]->creator);
        $this->assertInstanceOf($this->getModelName('User.User'), $this->birthDatas[1]->creator);
        $this->assertNull($this->birthDatas[2]->creator);
    }
    
    public function testDoesItHaveCorrectModificatoryInstance()
    {
        $this->assertInstanceOf($this->getModelName('User.User'), $this->birthDatas[0]->modificatory);
        $this->assertInstanceOf($this->getModelName('User.User'), $this->birthDatas[1]->modificatory);
        $this->assertNull($this->birthDatas[2]->modificatory);
    }
    
    public function testDoesItRetrieveCorrectCountryRelation()
    {
        $countryDataTable = $this->getDataSet()->getTable('cim_orszag');
        $country1 = $countryDataTable->getRow(0);
        $country2 = $countryDataTable->getRow(1);
        
        $this->assertEquals($country1['cim_orszag_id'], $this->birthDatas[0]->country->cim_orszag_id);
        $this->assertEquals($country1['nev'], $this->birthDatas[0]->country->nev);
        $this->assertEquals($country1['kod'], $this->birthDatas[0]->country->kod);
        $this->assertEquals($country2['cim_orszag_id'], $this->birthDatas[1]->country->cim_orszag_id);
        $this->assertEquals($country2['nev'], $this->birthDatas[1]->country->nev);
        $this->assertEquals($country2['kod'], $this->birthDatas[1]->country->kod);
    }
    
    public function testDoesItRetrieveCorrectCityRelation()
    {
        $cityDataTable = $this->getDataSet()->getTable('cim_varos');
        $city1 = $cityDataTable->getRow(0);
        $city2 = $cityDataTable->getRow(1);
        
        $this->assertEquals($city1['cim_varos_id'], $this->birthDatas[0]->city->cim_varos_id);
        $this->assertEquals($city1['cim_varos_nev'], $this->birthDatas[0]->city->cim_varos_nev);
        $this->assertEquals($city2['cim_varos_id'], $this->birthDatas[1]->city->cim_varos_id);
        $this->assertEquals($city2['cim_varos_nev'], $this->birthDatas[1]->city->cim_varos_nev);
    }
    
    public function testDoesItRetrieveCorrectCreatorRelation()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $this->birthDatas[0]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $this->birthDatas[1]->creator);
    }
    
    public function testDoesItRetrieveCorrectModificatoryRelation()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $this->birthDatas[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $this->birthDatas[1]->modificatory);
    }
}