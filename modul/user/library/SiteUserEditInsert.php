<?php

class SiteUserEditInsert extends \AttachedUserInsert
{
    public function rightGroupId()
    {
        return RimoConfig::USER_RG;
    }

    public function attachTo($userId, $toId)
    {
        $this->db->prepare("INSERT INTO user_ugyfel 
            (user_id, ugyfel_id) VALUES (" . (int)$userId . ", " . (int)$toId . ")")->query_insert();
    }

    public function insertAttachable(array &$params, $userId, $id)
    {
        // Menti az ügyfél adatokat.
        $clientId = $this->insertClientData(
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
        // Születési adatok mentése.
        $this->insertBirthData(
            $clientId, 
            $params['TxtSzulVezeteknev']->_value, 
            $params['TxtSzulKeresztnev']->_value, 
            $params['SelSzulhelyOrszag']->_value, 
            $params['SelSzulhelyVaros']->_value, 
            $params['DateSzulIdo']->_value
        );
        // Menti a munkaerőpiaci helyzet rekordot.
        $this->insertRequiredRecord('ugyfel_attr_mp_helyzet', $clientId, $userId);
        // Menti a projekt információ rekordot.
        $this->insertRequiredRecord('ugyfel_attr_projekt_informacio', $clientId, $userId);
        // Státusz mentése.
        $this->insertStatus($clientId);
        // Ügyfél címek mentése.
        $this->insertAddress(
            $clientId, 
            1, //Residence::ADDRESS_TYPE_ID, 
            $params['SelLakhelyOrszag']->_value, 
            $params['SelLakhelyMegye']->_value, 
            $params['SelLakhelyVaros']->_value, 
            $params['SelLakhelyIranyitoszam']->_value, 
            $params['TxtLakhelyUtca']->_value, 
            $params['TxtLakhelyHazszam']->_value,
            $userId
        ); // Lakcím.
        $this->insertAddress(
            $clientId, 
            2, //DwellingPlace::ADDRESS_TYPE_ID, 
            $params['SelTarthelyOrszag']->_value, 
            $params['SelTarthelyMegye']->_value, 
            $params['SelTarthelyVaros']->_value, 
            $params['SelTarthelyIranyitoszam']->_value, 
            $params['TxtTarthelyUtca']->_value, 
            $params['TxtTarthelyHazszam']->_value,
            $userId
        ); // Tartózkodási hely.
        $this->insertAddress(
            $clientId, 
            3, //TemporaryResidence::ADDRESS_TYPE_ID, 
            $params['SelIdeiglenesOrszag']->_value, 
            $params['SelIdeiglenesMegye']->_value, 
            $params['SelIdeiglenesVaros']->_value, 
            $params['SelIdeiglenesIranyitoszam']->_value, 
            $params['TxtIdeiglenesUtca']->_value, 
            $params['TxtIdeiglenesHazszam']->_value,
            $userId
        ); // Ideiglenes lakcím.
        // Ügyfél megjegyzés rekordok mentése.
        $this->insertTabComment($clientId, 7, '', $userId);
        $this->insertTabComment($clientId, 1, '', $userId);
        $this->insertTabComment($clientId, 9, '', $userId);
        $this->insertTabComment($clientId, 10, '', $userId);
        $this->insertTabComment($clientId, 6, '', $userId);
        $this->insertTabComment($clientId, 5, '', $userId);
        $this->insertTabComment($clientId, 3, '', $userId);
        $this->insertTabComment($clientId, 11, '', $userId);
        $this->insertTabComment($clientId, 2, '', $userId);
        $this->insertTabComment($clientId, 8, '', $userId);
        $this->insertTabComment($clientId, 4, '', $userId);
        return $clientId;
    }
    /**
     * Menti az alapvető ügyfél adatokat.
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
    public function insertClientData(
        $email, $lastname, $firstname, $newsletter, $eduId, $gender, $mothersName, $pHome, $pMob1, $pMob2, $userId
    ) {
        $userId = (int)$userId;
        return $this->db->prepare("INSERT INTO ugyfel 
            (
                email, 
                vezeteknev, 
                keresztnev, 
                user_hirlevel, 
                vegzettseg_id, 
                nem, 
                anyja_neve, 
                telefonszam_vezetekes, 
                telefonszam_mobil1, 
                telefonszam_mobil2, 
                letrehozo_id, 
                modosito_id, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                modositas_szama
            ) 
            VALUES 
            (
                '" . mysql_real_escape_string($email) . "', 
                '" . mysql_real_escape_string($lastname) . "', 
                '" . mysql_real_escape_string($firstname) . "', 
                " . (int)$newsletter . ", 
                " . $this->modelEditHelper->idMayNull($eduId) . ", 
                '" . mysql_real_escape_string($gender) . "', 
                '" . mysql_real_escape_string($mothersName) . "', 
                '" . mysql_real_escape_string($pHome) . "', 
                '" . mysql_real_escape_string($pMob1) . "', 
                '" . mysql_real_escape_string($pMob2) . "', 
                " . $userId . ", 
                " . $userId . ", 
                '" . date('Y-m-d H:i:s') . "', 
                0,
                0
            )")->query_insert();
    }
    /**
     * Menti a születési adatokat.
     * @param int $userId Felhasználó azonosító.
     * @param string $lastname Születési vezetéknév.
     * @param string $firstname Születési keresztnév.
     * @param mixed $countryId Ország azonosító.
     * @param mixed $cityId Város azonosító.
     * @param mixed $birthdate Születési idő.
     */
    public function insertBirthData($clientId, $lastname, $firstname, $countryId, $cityId, $birthdate)
    {
        $this->db->prepare("INSERT INTO ugyfel_attr_szuletesi_adatok 
            (
                ugyfel_id, 
                szuletesi_vezeteknev, 
                szuletesi_keresztnev, 
                szuletesi_hely_orszag_id, 
                szuletesi_hely_varos_id, 
                szuletesi_ido
            ) 
            VALUES 
            (
                " . (int)$clientId . ", 
                '" . mysql_real_escape_string($lastname) . "', 
                '" . mysql_real_escape_string($firstname) . "', 
                " . $this->modelEditHelper->idMayNull($countryId) . ", 
                " . $this->modelEditHelper->idMayNull($cityId) . ", 
                " . $this->modelEditHelper->stringMayNull($birthdate) . "
            )")->query_insert();
    }
    /**
     * Kötelező ugyfél rekord mentése a paraméterül adott táblába.
     * @param string $table Tábla neve.
     * @param int $clientId Ügyfél azonosító.
     * @param int $userId Felhasználó azonosító.
     */
    public function insertRequiredRecord($table, $clientId, $userId)
    {
        $userId = (int)$userId;
        $this->db->prepare("INSERT INTO " . $table . " 
            (
                ugyfel_id, 
                letrehozo_id, 
                modosito_id, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                modositas_szama
            ) 
            VALUES 
            (
                " . (int)$clientId . ", 
                " . $userId . ", 
                " . $userId . ", 
                '" . date('Y-m-d H:i:s') . "', 
                0, 
                0
            )")->query_insert();
    }
    /**
     * Menti a felhasználóhoz tartozó státuszt.
     * @param int $clientId Felhasználó azonosító.
     */
    public function insertStatus($clientId)
    {
        $this->db->prepare("INSERT INTO ugyfel_attr_statusz 
            (
                ugyfel_id, 
                aktualis_statusz, 
                kovetkezo_statusz, 
                idotartam
            ) 
            VALUES 
            (" . (int)$clientId . ", NULL, NULL, NULL)")->query_insert();
    }
    /**
     * Menti a felhasználóhoz a megjegyzést, hogy az ügyfélezelőben gond nélkül megjelenjen.
     * @param int $clientId Ügyfél azonosító.
     * @param int $tabId Tab azonosító.
     * @param string $comment Megjegyzés.
     * @param int $userId Felhasználó azonosító.
     */
    public function insertTabComment($clientId, $tabId, $comment, $userId)
    {
        $userId = (int)$userId;
        $this->db->prepare("INSERT INTO ugyfel_attr_tab_megjegyzes 
            (
                ugyfel_id, 
                beallitas_ugyfelkezelo_tab_id,
                megjegyzes,
                letrehozo_id,
                modosito_id,
                letrehozas_timestamp,
                modositas_timestamp,
                modositas_szama,
                ugyfel_attr_tab_megjegyzes_aktiv,
                ugyfel_attr_tab_megjegyzes_torolt
            ) 
            VALUES 
            (
                " . (int)$clientId . ",
                " . (int)$tabId . ",
                '" . mysql_real_escape_string($comment) . "',
                " . $userId . ",
                " . $userId . ",
                '" . date('Y-m-d H:i:s') . "',
                0,
                0, 
                1,
                0
            )")->query_insert();
    }
    /**
     * Menti a felhasználóhoz a címeket.
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
    public function insertAddress($clientId, $typeId, $countryId, $countyId, $cityId, $zipCodeId, $street, $hn, $userId)
    {
        $userId = (int)$userId;
        $this->db->prepare("INSERT INTO ugyfel_attr_cim 
            (
                ugyfel_id, 
                beallitas_cim_tipus_id, 
                cim_orszag_id, 
                cim_megye_id, 
                cim_varos_id, 
                cim_iranyitoszam_id, 
                utca, 
                hazszam, 
                letrehozo_id, 
                modosito_id, 
                modositas_szama, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                ugyfel_attr_cim_aktiv, 
                ugyfel_attr_cim_torolt
            ) 
            VALUES 
            (
                " . (int)$clientId . ", 
                " . (int)$typeId . ", 
                " . $this->modelEditHelper->idMayNull($countryId) . ", 
                " . $this->modelEditHelper->idMayNull($countyId) . ", 
                " . $this->modelEditHelper->idMayNull($cityId) . ", 
                " . $this->modelEditHelper->idMayNull($zipCodeId) . ", 
                '" . mysql_real_escape_string(trim($street)) . "', 
                '" . mysql_real_escape_string(trim($hn)) . "', 
                " . $userId . ", 
                " . $userId . ", 
                0, 
                '" . date('Y-m-d H:i:s') . "',
                0,
                1,
                0
            )")->query_insert();
    }
}