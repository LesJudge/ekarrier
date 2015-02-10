<?php

class SiteUserEditDataFinder extends \DbInjectAbstract implements \AttachedUserFinderInterface
{
    public function findAndSet($clientId, &$params)
    {
        $birthData = $this->findBirthData($clientId);
        $clientData = $this->findClientData($clientId);
        $residence = $this->findAddress($clientId, 1);
        $dwellingPlace = $this->findAddress($clientId, 2);
        $temporaryResidence = $this->findAddress($clientId, 3);
        // Születési adatok beállítása.
        $params['TxtSzulVezeteknev']->_value = $birthData['szuletesi_vezeteknev'];
        $params['TxtSzulKeresztnev']->_value = $birthData['szuletesi_keresztnev'];
        $params['SelSzulhelyOrszag']->_value = $birthData['szuletesi_hely_orszag_id'];
        $params['SelSzulhelyVaros']->_value = $birthData['szuletesi_hely_varos_id'];
        $params['DateSzulIdo']->_value = $birthData['szuletesi_ido'];
        // Személyes adatok beállítása.
        $params['SelVegzettseg']->_value = $clientData['vegzettseg_id'];
        $params['SelNem']->_value = $clientData['nem'];
        $params['TxtAnyjaNeve']->_value = $clientData['anyja_neve'];
        $params['TxtTelszamVezetekes']->_value = $clientData['telefonszam_vezetekes'];
        $params['TxtTelszamMobil1']->_value = $clientData['telefonszam_mobil1'];
        $params['TxtTelszamMobil2']->_value = $clientData['telefonszam_mobil2'];
        // Lakcím adatok beállítása.
        $params['SelLakhelyOrszag']->_value = $residence['cim_orszag_id'];
        $params['SelLakhelyMegye']->_value = $residence['cim_megye_id'];
        $params['SelLakhelyVaros']->_value = $residence['cim_varos_id'];
        $params['SelLakhelyIranyitoszam']->_value = $residence['cim_iranyitoszam_id'];
        $params['TxtLakhelyUtca']->_value = $residence['utca'];
        $params['TxtLakhelyHazszam']->_value = $residence['hazszam'];
        // Tartózkodási hely adatok beállítása.
        $params['SelTarthelyOrszag']->_value = $dwellingPlace['cim_orszag_id'];
        $params['SelTarthelyMegye']->_value = $dwellingPlace['cim_megye_id'];
        $params['SelTarthelyVaros']->_value = $dwellingPlace['cim_varos_id'];
        $params['SelTarthelyIranyitoszam']->_value = $dwellingPlace['cim_iranyitoszam_id'];
        $params['TxtTarthelyUtca']->_value = $dwellingPlace['utca'];
        $params['TxtTarthelyHazszam']->_value = $dwellingPlace['hazszam'];        
        // Ideiglenes lakcím adatok beállítása.
        $params['SelIdeiglenesOrszag']->_value = $temporaryResidence['cim_orszag_id'];
        $params['SelIdeiglenesMegye']->_value = $temporaryResidence['cim_megye_id'];
        $params['SelIdeiglenesVaros']->_value = $temporaryResidence['cim_varos_id'];
        $params['SelIdeiglenesIranyitoszam']->_value = $temporaryResidence['cim_iranyitoszam_id'];
        $params['TxtIdeiglenesUtca']->_value = $temporaryResidence['utca'];
        $params['TxtIdeiglenesHazszam']->_value = $temporaryResidence['hazszam'];
    }
    
    public function findBirthData($userId)
    {
        try {
            $query = "SELECT * FROM ugyfel_attr_szuletesi_adatok WHERE ugyfel_id = " . (int)$userId . " LIMIT 1";
            return $this->db->prepare($query)->query_select()->query_fetch_array();
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array(
                'ugyfel_id' => null,
                'szuletesi_vezeteknev' => null,
                'szuletesi_keresztnev' => null,
                'szuletesi_hely_orszag_id' => null,
                'szuletesi_hely_varos_id' => null,
                'szuletesi_ido' => null
            );
        }
    }
    
    public function findAddress($userId, $typeId)
    {
        try {
            $query = "SELECT * FROM ugyfel_attr_cim WHERE ugyfel_id = " . (int)$userId . " AND 
                beallitas_cim_tipus_id = " . (int)$typeId . " LIMIT 1";
            return $this->db->prepare($query)->query_select()->query_fetch_array();
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array(
                'ugyfel_id' => null,
                'beallitas_cim_tipus_id' => (int)$typeId,
                'cim_orszag_id' => null,
                'cim_megye_id' => null,
                'cim_varos_id' => null,
                'cim_iranyitoszam_id' => null,
                'utca' => null,
                'hazszam' => null
            );
        }
    }
    
    public function findClientData($userId)
    {
        try {
            $query = "SELECT * FROM ugyfel WHERE ugyfel_id = " . (int)$userId . " LIMIT 1";
            return $this->db->prepare($query)->query_select()->query_fetch_array();
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array(
                'ugyfel_id' => null,
                'vegzettseg_id' => null,
                'nem' => null,
                'anyja_neve' => null,
                'telefonszam_vezetekes' => null,
                'telefonszam_mobil1' => null,
                'telefonszam_mobil2' => null
            );
        }
    }
}