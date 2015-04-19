<?php

class SiteCegEditInsert extends \AttachedUserInsert
{
    public function attachTo($userId, $toId)
    {
        $this->db->prepare("INSERT INTO user_ceg 
            (user_id, ceg_id) VALUES (" . (int)$userId . ", " . (int)$toId . ")")->query_insert();
    }

    public function insertAttachable(array &$params, $userId, $id)
    {
        $companyId = $this->insertCompany($params['TxtCegnev']->_value, $userId);
        // Székhely adatok mentése.
        $this->insertHeadquarters(
            $companyId, 
            $params['SelSzekhelyOrszag']->_value, 
            $params['SelSzekhelyMegye']->_value, 
            $params['SelSzekhelyVaros']->_value, 
            $params['SelSzekhelyIranyitoszam']->_value, 
            $params['TxtSzekhelyUtca']->_value, 
            $params['TxtSzekhelyUtca']->_value, 
            $userId
        );
        // Kapcsolattartó adatok mentése.
        $this->insertContact(
            $companyId,
            $params['TxtVnev']->_value,
            $params['TxtKnev']->_value,
            $params['TxtEmail']->_value,
            $params['TxtKtoTel']->_value
        );
        // Cég adatok mentése.
        $this->insertCompanyData($companyId, $params['SelSzektor']->_value, $params['SelTevkor']->_value, '', '', $userId);
        return $companyId;
    }
    /**
     * Jogcsoport azonosító.
     * @return int
     */
    public function rightGroupId()
    {
        return RimoConfig::COMPANY_RG;
    }
    /**
     * Menti a céget.
     * @param string $name Cég neve.
     * @param int $userId Felhasználó azonosító.
     * @return int
     */
    public function insertCompany($name, $userId)
    {
        $userId = (int)$userId;
        return $this->db->prepare("INSERT INTO ceg 
            (
                nev,
                link, 
                leiras, 
                meta_kulcsszo, 
                tartalom, 
                logo, 
                megtekintve, 
                letrehozo_id, 
                modosito_id, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                modositas_szama, 
                ceg_aktiv, 
                ceg_torolt
            ) 
            VALUES 
            (
                '" . mysql_real_escape_string($name) . "', 
                '" . mysql_real_escape_string(Create::remove_accents($name)) . "', 
                '',
                '',
                '', 
                '', 
                0,
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
     * Menti a székhely adatokat.
     * @param int $companyId Cég azonosító.
     * @param int $countryId Ország azonosító.
     * @param int $countyId Megye azonosító.
     * @param int $cityId Város azonosító.
     * @param int $zipCodeId Irányítószám azonosító.
     * @param string $street Utca.
     * @param string $hn Házszám.
     * @param int $userId Felhasználó azonosító.
     */
    public function insertHeadquarters($companyId, $countryId, $countyId, $cityId, $zipCodeId, $street, $hn, $userId)
    {
        $userId = (int)$userId;
        $this->db->prepare("INSERT INTO ceg_szekhely 
            (
                ceg_id, 
                cim_orszag_id, 
                cim_megye_id, 
                cim_varos_id, 
                cim_iranyitoszam_id, 
                utca, 
                hazszam, 
                letrehozo_id, 
                modosito_id, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                modositas_szama
            ) 
            VALUES 
            (
                " . (int)$companyId . ", 
                " . $this->modelEditHelper->idMayNull($countryId) . ", 
                " . $this->modelEditHelper->idMayNull($countyId) . ", 
                " . $this->modelEditHelper->idMayNull($cityId) . ", 
                " . $this->modelEditHelper->idMayNull($zipCodeId) . ", 
                '" . mysql_real_escape_string($street) . "', 
                '" . mysql_real_escape_string($hn) . "', 
                " . $userId . ", 
                " . $userId . ", 
                '" . date('Y-m-d H:i:s') . "', 
                0,
                0
            )")->query_insert();
    }
    /**
     * Menti a kapcsolattartó adatokat.
     * @param int $companyId Cég azonosító.
     * @param string $lastname Kapcsolattartó vezetékneve.
     * @param string $firstname Kapcsolattartó keresztneve.
     * @param string $email Kapcsolattartó e-mail címe.
     * @param string $phone Kapcsolattartó telefonszáma.
     */
    public function insertContact($companyId, $lastname, $firstname, $email, $phone)
    {
        $this->db->prepare("INSERT INTO ceg_kapcsolattarto 
            (
                ceg_id,
                ceg_kapcsolattarto_vezeteknev, 
                ceg_kapcsolattarto_keresztnev, 
                ceg_kapcsolattarto_email, 
                ceg_kapcsolattarto_telefon
            ) 
            VALUES 
            (
                " . (int)$companyId . ", 
                '" . mysql_real_escape_string($lastname) . "', 
                '" . mysql_real_escape_string($firstname) . "', 
                '" . mysql_real_escape_string($email) . "', 
                '" . mysql_real_escape_string($phone) . "'
            )")->query_insert();
    }
    /**
     * Menti a cég adatait.
     * @param int $companyId Cég azonosító.
     * @param int $sectorId Szektor azonosító.
     * @param int $tevkorId Tevékenységi kör azonosító.
     * @param string $regNumber Cégjegyzékszám.
     * @param string $taxNumber Adósázm.
     * @param int $userId Felhasználó azonosító.
     */
    public function insertCompanyData($companyId, $sectorId, $tevkorId, $regNumber, $taxNumber, $userId)
    {
        $userId = (int)$userId;
        $this->db->prepare("INSERT INTO ceg_adatok 
            (
                ceg_id, 
                szektor_id, 
                tevkor_id, 
                cegjegyzekszam, 
                adoszam, 
                letrehozo_id, 
                modosito_id, 
                letrehozas_timestamp, 
                modositas_timestamp, 
                modositas_szama
            ) 
            VALUES 
            (
                " . (int)$companyId . ", 
                '" . (int)$sectorId . "', 
                '" . (int)$tevkorId . "'
                '" . mysql_real_escape_string($regNumber) . "', 
                '" . mysql_real_escape_string($taxNumber) ."', 
                " . $userId . ", 
                " . $userId . ", 
                '" . date('Y-m-d H:i:s') . "', 
                0, 
                0
            )")->query_insert();
    }
}