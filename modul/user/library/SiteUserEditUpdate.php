<?php

class SiteUserEditUpdate extends \AttachedUserUpdate
{
    public function updateAttached(array &$params, $userId, $id)
    {
        // Ügyfél címek módosítása.
        $this->updateAddress(
            $id, 
            1, //Residence::ADDRESS_TYPE_ID, 
            $params['SelLakhelyOrszag']->_value, 
            $params['SelLakhelyMegye']->_value, 
            $params['SelLakhelyVaros']->_value, 
            $params['SelLakhelyIranyitoszam']->_value, 
            $params['TxtLakhelyUtca']->_value, 
            $params['TxtLakhelyHazszam']->_value,
            $userId
        ); // Lakcím.
        $this->updateAddress(
            $id, 
            2, //DwellingPlace::ADDRESS_TYPE_ID, 
            $params['SelTarthelyOrszag']->_value, 
            $params['SelTarthelyMegye']->_value, 
            $params['SelTarthelyVaros']->_value, 
            $params['SelTarthelyIranyitoszam']->_value, 
            $params['TxtTarthelyUtca']->_value, 
            $params['TxtTarthelyHazszam']->_value,
            $userId
        ); // Tartózkodási hely.
        $this->updateAddress(
            $id, 
            3, //TemporaryResidence::ADDRESS_TYPE_ID, 
            $params['SelIdeiglenesOrszag']->_value, 
            $params['SelIdeiglenesMegye']->_value, 
            $params['SelIdeiglenesVaros']->_value, 
            $params['SelIdeiglenesIranyitoszam']->_value, 
            $params['TxtIdeiglenesUtca']->_value, 
            $params['TxtIdeiglenesHazszam']->_value,
            $userId
        ); // Ideiglenes lakcím.
        // Módosítja az ügyfél adatokat.
        $this->updateClientData(
            $id,
            $params['TxtEmail']->_value,
            $params['TxtVnev']->_value,
            $params['TxtKnev']->_value,
            $params['ChkHirlevel']->_value,
            $params['SelVegzettseg']->_value,
            $params['SelNem']->_value,
            $params['TxtAnyjaNeve']->_value,
            $params['TxtTelszamVezetekes']->_value,
            $params['TxtTelszamMobil1']->_value,
            $params['TxtTelszamMobil2']->_value,
            $userId
        );
        // Születési adatok módosítása.
        $this->updateBirthData(
            $id, 
            $params['TxtSzulVezeteknev']->_value, 
            $params['TxtSzulKeresztnev']->_value, 
            $params['SelSzulhelyOrszag']->_value, 
            $params['SelSzulhelyVaros']->_value, 
            $params['DateSzulIdo']->_value
        );
    }
    /**
     * Módosítja a felhasználó cím adatait.
     * @param int $clientId Ügyfél azonosító.
     * @param int $typeId Cím típus azonosító.
     * @param mixed $countryId Ország azonosító.
     * @param mixed $countyId Megye azonosító.
     * @param mixed $cityId Város azonosító.
     * @param mixed $zipCodeId Irányítószám azonosító.
     * @param string $street Utca
     * @param string $hn Házszám
     * @param int $userId Felhasználó azonosító.
     */
    public function updateAddress($clientId, $typeId, $countryId, $countyId, $cityId, $zipCodeId, $street, $hn, $userId)
    {
        $userId = (int)$userId;
        $query = "UPDATE ugyfel_attr_cim SET 
            cim_orszag_id = " . $this->modelEditHelper->idMayNull($countryId) . ", 
            cim_megye_id = " . $this->modelEditHelper->idMayNull($countyId) . ", 
            cim_varos_id = " . $this->modelEditHelper->idMayNull($cityId) . ", 
            cim_iranyitoszam_id = " . $this->modelEditHelper->idMayNull($zipCodeId) . ", 
            utca = '" . mysql_real_escape_string($street) . "', 
            hazszam = '" . mysql_real_escape_string($hn) . "', 
            modosito_id = " . $userId . ", 
            modositas_szama = modositas_szama + 1, 
            modositas_timestamp = '" . date('Y-m-d H:i:s') . "' 
            WHERE ugyfel_id = " . (int)$clientId . " AND ugyfel_cim_tipus_id = " . (int)$typeId . " LIMIT 1";
        $this->db->prepare($query)->query_execute();
    }
    /**
     * Módosítja az alapvető ügyfél adatokat.
     * @param int $clientId Ügyfél azonosító.
     * @param string $email E-mail cím.
     * @param string $lastname Vezetéknév.
     * @param string $firstname Keresztnév.
     * @param string $newsletter Hírlevélre feliratkozott-e.
     * @param mixed $eduId Legmagasabb iskolai végzettség.
     * @param string $gender Neme.
     * @param string $mothersName Anyja neve.
     * @param string $pHome Vezetékes telefonszám
     * @param string $pMob1 Mobiltelefonszám 1
     * @param string $pMob2 Mobiltelefonszám 2
     * @param int $userId Felhasználó azonosító.
     */
    public function updateClientData(
        $clientId, $email, $lastname, $firstname, $newsletter, $eduId, $gender, $mothersName, $pHome, $pMob1, $pMob2, 
        $userId
    ) {
        $userId = (int)$userId;
        $query = "UPDATE ugyfel SET 
            email = " . $this->modelEditHelper->stringMayNull($email) . ", 
            vezeteknev = " . $this->modelEditHelper->stringMayNull($lastname) . ", 
            keresztnev = " . $this->modelEditHelper->stringMayNull($firstname) . ", 
            user_hirlevel = " . (int)$newsletter . ", 
            vegzettseg_id = " . $this->modelEditHelper->idMayNull($eduId) . ", 
            nem = '" . mysql_real_escape_string($gender) . "', 
            anyja_neve = '" . mysql_real_escape_string($mothersName) . "', 
            telefonszam_vezetekes = '" . mysql_real_escape_string($pHome) . "', 
            telefonszam_mobil1 = '" . mysql_real_escape_string($pMob1) . "', 
            telefonszam_mobil2 = '" . mysql_real_escape_string($pMob2) . "', 
            modosito_id = " . $userId . ", 
            modositas_szama = modositas_szama + 1, 
            modositas_timestamp = '" . date('Y-m-d H:i:s') . "' WHERE ugyfel_id = " . (int)$clientId . " LIMIT 1";
        $this->db->prepare($query)->query_execute();
    }
    /**
     * Módosítja a születési adatokat.
     * @param int $clientId Felhasználó azonosító.
     * @param string $lastname Születési vezetéknév.
     * @param string $firstname Születési keresztnév.
     * @param mixed $countryId Ország azonosító.
     * @param mixed $cityId Város azonosító.
     * @param mixed $birthdate Születési idő.
     */
    public function updateBirthData($clientId, $lastname, $firstname, $countryId, $cityId, $birthdate)
    {
        $query = "UPDATE ugyfel_attr_szuletesi_adatok SET 
            szuletesi_vezeteknev = '" . mysql_real_escape_string($lastname) . "', 
            szuletesi_keresztnev = '" . mysql_real_escape_string($firstname) . "', 
            szuletesi_hely_orszag_id = " . $this->modelEditHelper->idMayNull($countryId) . ", 
            szuletesi_hely_varos_id = " . $this->modelEditHelper->idMayNull($cityId) . ", 
            szuletesi_ido = " . $this->modelEditHelper->stringMayNull($birthdate) . " 
            WHERE ugyfel_id = " . (int)$clientId . " LIMIT 1";
        $this->db->prepare($query)->query_execute();
    }
}