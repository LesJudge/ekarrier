<?php

class SiteCegEditFinder extends \DbInjectAbstract implements \AttachedUserFinderInterface
{
    public function findAndSet($attachedId, &$params)
    {
        $company = $this->findCompany($attachedId);
        $companyData = $this->findCompanyData($attachedId);
        $contact = $this->findContact($attachedId);
        $hq = $this->findHeadquarters($attachedId);
        $jobs = $this->findJobs($attachedId);
        // Cég adatok beállítása.
        $params['TxtCegnev']->_value = $company['nev'];
        $params['SelSzektor']->_value = $companyData['szektor_id'];
        $params['SelTevkor']->_value = $companyData['tevkor_id'];
        $params['SelTevcsop']->_value = $this->getCatParent($companyData['tevkor_id']);
        $params['TxtAdoszam']->_value = $companyData['adoszam'];
        $params['TxtCegjegyzekszam']->_value = $companyData['cegjegyzekszam'];
        // Kapcsolattartó adatok beállítása.
        $params['TxtVnev']->_value = $contact['ceg_kapcsolattarto_vezeteknev'];
        $params['TxtKnev']->_value = $contact['ceg_kapcsolattarto_keresztnev'];
        $params['TxtEmail']->_value = $contact['ceg_kapcsolattarto_email'];
        $params['TxtKtoTel']->_value = $contact['ceg_kapcsolattarto_telefon'];
        // Székhely adatok beállítása.
        $params['SelSzekhelyOrszag']->_value = $hq['cim_orszag_id'];
        $params['SelSzekhelyMegye']->_value = $hq['cim_megye_id'];
        $params['SelSzekhelyVaros']->_value = $hq['cim_varos_id'];
        $params['SelSzekhelyIranyitoszam']->_value = $hq['cim_iranyitoszam_id'];
        $params['TxtSzekhelyUtca']->_value = $hq['utca'];
        $params['TxtSzekhelyHazszam']->_value = $hq['hazszam'];
    }
    
    public function findCompany($companyId)
    {
        return $this->db->prepare("SELECT ceg_id, nev FROM ceg WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_select()->query_fetch_array();
    }
    /**
     * Cég azonosító alapján lekérdezi a cég adatait.
     * @param int $companyId Cég azonosító.
     * @return array
     */
    public function findCompanyData($companyId)
    {
        return $this->db->prepare("SELECT ceg_id, szektor_id, cegjegyzekszam, adoszam, tevkor_id FROM ceg_adatok 
            WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_select()->query_fetch_array();
    }
    /**
     * Cég azonosító alapján lekérdezi a kapcsolattartó adatait.
     * @param int $companyId Cég azonosító.
     * @return array
     */
    public function findContact($companyId)
    {
        return $this->db->prepare("SELECT ceg_id, ceg_kapcsolattarto_vezeteknev,  ceg_kapcsolattarto_keresztnev, 
            ceg_kapcsolattarto_email, ceg_kapcsolattarto_telefon FROM ceg_kapcsolattarto 
            WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_select()->query_fetch_array();
    }
    /**
     * Cég azonosító alapján lekérdezi a cég székhelyét.
     * @param int $companyId Cég azonosító.
     * @return array
     */
    public function findHeadquarters($companyId)
    {
        return $this->db->prepare("SELECT ceg_id, cim_orszag_id, cim_megye_id, cim_varos_id, 
            cim_iranyitoszam_id, utca, hazszam FROM ceg_szekhely WHERE ceg_id = " . (int)$companyId . " LIMIT 1
        ")->query_select()->query_fetch_array();
    }
    /**
     * Cég azonosító alapján lekérdezi a céghez tartozó munkaköröket.
     * @param int $companyId Cég azonosító.
     * @return array
     */
    public function findJobs($companyId)
    {
        try {
            $query = "SELECT munkakor_id FROM ceg_attr_munkakor WHERE ceg_id = " . (int)$companyId;
            $result = $this->db->prepare($query)->query_select();
            $jobIds = array();
            while ($data = $result->query_fetch_array()) {
                $jobIds[] = $data['munkakor_id'];
            }
            return $jobIds;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    private function getCatParent($mkID){
        try {
            $query = "SELECT munkakor_kategoria_id AS ID
                      FROM munkakor_kategoria 
                      WHERE szint = 1 AND baloldal < 
                            (SELECT mk1.baloldal AS leftside
                            FROM munkakor_kategoria AS mk1
                            WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$mkID).")

                            AND jobboldal >
                            
                            (SELECT mk1.jobboldal AS rightside
                            FROM munkakor_kategoria AS mk1
                            WHERE mk1.munkakor_kategoria_id = ".mysql_real_escape_string((int)$mkID).")
                            LIMIT 1
                        "
                    ;
           $result = $this->db->prepare($query)->query_select()->query_fetch_array();
            return $result['ID'];
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
}