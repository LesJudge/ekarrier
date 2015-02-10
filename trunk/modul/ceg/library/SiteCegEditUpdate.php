<?php

class SiteCegEditUpdate extends \AttachedUserUpdate
{
    public function updateAttached(array &$params, $userId, $id)
    {
        // Cég adatok módosítása.
        $this->updateCompany($id, $params['TxtCegnev']->_value, $userId);
        // Székhely adatok módosítása.
        $this->updateHeadquarters(
            $id,
            $params['SelSzekhelyOrszag']->_value,
            $params['SelSzekhelyMegye']->_value,
            $params['SelSzekhelyVaros']->_value,
            $params['SelSzekhelyIranyitoszam']->_value,
            $params['TxtSzekhelyUtca']->_value,
            $params['TxtSzekhelyHazszam']->_value,
            $userId
        );
        // Kapcsolattartó adatok módosítása.
        $this->updateContact(
            $id,
            $params['TxtVnev']->_value,
            $params['TxtKnev']->_value,
            $params['TxtEmail']->_value,
            $params['TxtKtoTel']->_value
        );
        // Cég adatok módosítása.
        $this->updateCompanyData(
            $id,
            $params['SelSzektor']->_value,
            $params['TxtCegjegyzekszam']->_value,
            $params['TxtAdoszam']->_value,
            $userId
        );
    }
    /**
     * Módosítja a cég adatait.
     * @param int $companyId Cég azonosító.
     * @param int $name Cég neve.
     * @param int $userId Felhasználó azonosító.
     */
    public function updateCompany($companyId, $name, $userId)
    {
        $this->db->prepare("UPDATE ceg SET nev = '" . mysql_real_escape_string($name) . "', 
            modosito_id = " . (int)$userId . ", 
            modositas_timestamp = '" . date('Y-m-d H:i:s') . "', 
            modositas_szama = modositas_szama + 1 WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_execute();
    }
    /**
     * Módosítja a cég székhely adatait.
     * @param int $companyId Cég azonosító.
     * @param int $countryId Ország azonosító.
     * @param int $countyId Megye azonosító.
     * @param int $cityId Város azonosító.
     * @param int $zipCodeId Irányítószám azonosító.
     * @param string $street Utca.
     * @param string $hn Házszám.
     * @param int $userId Felhasználó azonosító.
     */
    public function updateHeadquarters($companyId, $countryId, $countyId, $cityId, $zipCodeId, $street, $hn, $userId)
    {
        $this->db->prepare("UPDATE ceg_szekhely SET 
            cim_orszag_id = " . $this->modelEditHelper->idMayNull($countryId) . ", 
            cim_megye_id = " . $this->modelEditHelper->idMayNull($countyId). ", 
            cim_varos_id = " . $this->modelEditHelper->idMayNull($cityId) . ", 
            cim_iranyitoszam_id = " . $this->modelEditHelper->idMayNull($zipCodeId) . ", 
            utca = '" . mysql_real_escape_string($street) . "', 
            hazszam = '" . mysql_real_escape_string($hn) . "', 
            modosito_id = " . (int)$userId . ", 
            modositas_szama = modositas_szama + 1, 
            modositas_timestamp = '" . date('Y-m-d H:i:s') . "' WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_execute();
    }
    /**
     * Módosítja a cég kapcsolattartó adatait.
     * @param string $companyId Cég azonosító.
     * @param string $lastname Vezetéknév
     * @param string $firstname Keresztnév
     * @param string $email E-mail cím
     * @param string $phone Telefonszám
     */
    public function updateContact($companyId, $lastname, $firstname, $email, $phone)
    {
        $this->db->prepare("UPDATE ceg_kapcsolattarto SET 
            ceg_kapcsolattarto_vezeteknev = '" . mysql_real_escape_string($lastname) . "', 
            ceg_kapcsolattarto_keresztnev = '" . mysql_real_escape_string($firstname) . "', 
            ceg_kapcsolattarto_email = '" . mysql_real_escape_string($email) . "', 
            ceg_kapcsolattarto_telefon = '" . mysql_real_escape_string($phone) . "' 
            WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_execute();
    }
    /**
     * Módosítja acég adatait.
     * @param int $companyId Cég azonosító.
     * @param mixed $sectorId Szektor azonosító.
     * @param string $regNumber Cégjegyzékszám.
     * @param string $taxNumber Adószám.
     * @param int $userId Módosító felhasználó azonosító.
     */
    public function updateCompanyData($companyId, $sectorId, $regNumber, $taxNumber, $userId)
    {
        $this->db->prepare("UPDATE ceg_adatok SET 
            szektor_id = " . $this->modelEditHelper->idMayNull($sectorId) . ", 
            cegjegyzekszam = '" . mysql_real_escape_string($regNumber) . "', 
            adoszam = '" . mysql_real_escape_string($taxNumber) . "', 
            modosito_id = " . (int)$userId . ", 
            modositas_timestamp = '" . date('Y-m-d H:i:s'). "', 
            modositas_szama = modositas_szama + 1 WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_execute();
    }
}