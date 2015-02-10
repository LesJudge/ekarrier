<?php
/**
 * Ügyfél opciók előkészítését elfedő osztály.
 */
class ClientEditOptionsFacade
{
    public static function generateOptions()
    {
        $data = array();
        $pleaseSelect = array('' => '-- Kérem, válasszon!--');
        // Hova érkezett opciók.
        $data['cameToOptions'] = $pleaseSelect + ClientEditFormCache::optionCache(
            'cameToOptions', array('CameTo', 'findAllActiveNotDeleted'), array('hova_erkezett_id', 'hova_erkezett_nev')
        );
        // Végzettség opciók.
        $data['educationOptions'] = ClientEditFormCache::optionCache(
            'educationOptions', array('Education', 'findAllActiveNotDeleted'), array('vegzettseg_id', 'vegzettseg_nev')
        );
        // Legmagasabb iskolai végzettség opciók.
        $data['highestDegreeOptions'] = $pleaseSelect + $data['educationOptions'];
        // Nyelvtudás - nyelv opciók.
        $data['langLangsOptions'] = ClientEditFormCache::optionCache(
            'langLangsOptions',
            array('KnowledgeLanguage', 'findAllActiveNotDeleted'),
            array('nyelvtudas_nyelv_id', 'nyelvtudas_nyelv_nev')
        );
        // Nyelvtudás - szint opciók.
        $data['langLevelsOptions'] = ClientEditFormCache::optionCache(
            'langLevelsOptions',
            array('KnowledgeLevel', 'findAllActiveNotDeleted'),
            array('nyelvtudas_szint_id', 'nyelvtudas_szint_nev')
        );
        // Számítógépes ismeret (autocomplete) opciók.
        $data['ucKnowledgeOptions'] = ClientEditFormCache::optionCache(
            'ucKnowledgeOptions',
            array('UcKnowledge', 'findAllActiveNotDeleted'),
            array('ismeret', 'ismeret')
        );
        // Ügyfél állapot opciók.
        $data['stateOptions'] = $pleaseSelect + ClientEditFormCache::optionCache(
            'stateOptions',
            array('ClientState', 'findAllActiveNotDeleted'),
            array('user_allapot_id', 'nev')
        );
        // Ügyfél státusz opciók.
        $data['statusOptions'] = $pleaseSelect + ClientEditFormCache::optionCache(
            'statusOptions',
            array('ClientStatus', 'findAllActiveNotDeleted'),
            array('user_statusz_id', 'nev')
        );
        // Esetnapló típus opciók.
        $data['contactTypeOptions'] = $pleaseSelect + ClientEditFormCache::optionCache(
            'contactTypeOptions',
            array('ContactType', 'findAllActiveNotDeleted'),
            array('esetnaplo_tipus_id', 'nev')
        );
        // Szolgáltatások.
        $data['servicesOptions'] = ClientEditFormCache::optionCache(
            'servicesOptions', array('Service', 'findAllActiveNotDeleted'), array('szolgaltatas_id', 'szolgaltatas_nev')
        );
        // Program információk.
        $piCache = Rimo::getCache()->get('programInformations');
        if (is_null($piCache)) {
            $piCache = $data['programInformations'] = ProgramInformation::findAllActiveNotDeleted();
            Rimo::getCache()->set('programInformations', serialize($piCache));
        } else {
            $data['programInformations'] = unserialize($piCache);
        }
        // Munkarendek.
        $wsCache = Rimo::getCache()->get('wsOptions');
        if (is_null($wsCache)) {
            $wsCache = $data['wsOptions'] = WorkSchedule::findAllActiveNotDeleted();
            Rimo::getCache()->set('wsOptions', serialize($wsCache));
        } else {
            $data['wsOptions'] = unserialize($wsCache);
        }
        // Munkakör opciók.
        $jobs = new Munkakor_Ajax_Model;
        $jobMainCategories = Rimo::getCache()->get('jobMainCategories');
        if (is_null($jobMainCategories)) {
            $jobMainCategories = $data['jobMainCategories'] = $jobs->findAllMainCategory();
            Rimo::getCache()->set('jobMainCategories', serialize($jobMainCategories));
        } else {
            $data['jobMainCategories'] = unserialize($jobMainCategories);
        }
        // Közvetítés opciók.
        $data['mediationOptions'] = ClientMediation::findOptions();
        // Ügyfél nem opciók.
        $data['gender'] = $pleaseSelect + array(ClientData::GENDER_MALE => 'Férfi', ClientData::GENDER_FEMALE => 'Nő');
        
        // Országok.
        $countryOptions = Rimo::getCache()->get('countryOptions');
        if (is_null($countryOptions)) {
            $countries = Country::find('all', array(
                'conditions' => array(
                    'cim_orszag_aktiv' => 1,
                    'cim_orszag_torolt' => 0
                )
            ));
            $countryOptions = $data['countryOptions'] = $pleaseSelect + ArHelper::result2Options(
                $countries, 'cim_orszag_id', 'nev'
            );
            Rimo::getCache()->set('countryOptions', serialize($countryOptions));            
        } else {
            $data['countryOptions'] = unserialize($countryOptions);
        }
        $countyOptions = Rimo::getCache()->get('countyOptions');
        if (is_null($countyOptions)) {
            $counties = County::find('all', array(
                'conditions' => array(
                    'cim_megye_aktiv' => 1,
                    'cim_megye_torolt' => 0
                )
            ));
            $countyOptions = $data['countyOptions'] = $pleaseSelect + ArHelper::result2Options(
                $counties, 'cim_megye_id', 'cim_megye_nev'
            );
            Rimo::getCache()->set('countyOptions', serialize($countyOptions));            
        } else {
            $data['countyOptions'] = unserialize($countyOptions);
        }
        $cityOptions = Rimo::getCache()->get('cityOptions');
        if (is_null($cityOptions)) {
            $cities = City::find('all', array(
                'conditions' => array(
                    'cim_varos_aktiv' => 1,
                    'cim_varos_torolt' => 0
                )
            ));
            $cityOptions = $data['cityOptions'] = $pleaseSelect + ArHelper::result2Options(
                $cities, 'cim_varos_id', 'cim_varos_nev'
            );
            Rimo::getCache()->set('cityOptions', serialize($cityOptions));            
        } else {
            $data['cityOptions'] = unserialize($cityOptions);
        }
        $zipCodeOptions = Rimo::getCache()->get('zipCodeOptions');
        if (is_null($zipCodeOptions)) {
            $zipCodes = ZipCode::find('all', array(
                'conditions' => array(
                    'cim_iranyitoszam_aktiv' => 1,
                    'cim_iranyitoszam_torolt' => 0
                )
            ));
            $zipCodeOptions = $data['zipCodeOptions'] = $pleaseSelect + ArHelper::result2Options(
                $zipCodes, 'cim_iranyitoszam_id', 'iranyitoszam'
            );
            Rimo::getCache()->set('zipCodeOptions', serialize($zipCodeOptions));            
        } else {
            $data['zipCodeOptions'] = unserialize($zipCodeOptions);
        }
        
        $data['munkakorKategoriaOptions'] = $pleaseSelect + array(1 => 'A', 2 => 'K', 3 => 'F');
        $data['munkabaAllasAllapotOptions'] = $pleaseSelect + array(1 => 1, 2 => 2, 3 => 3);
        
        // Város opciók.
        $ucam = new User_cim_Ajax_Model;
        $zipCodes = $ucam->findAndCacheZipCodes();
        $data['zipCodes'] = json_encode($zipCodes);
        // Aktív opciók.
        $data['activeValues'] = array(
            1 => 'Igen',
            0 => 'Nem'
        );
        return $data;
    }
}