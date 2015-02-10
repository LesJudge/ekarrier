<?php
/**
 * Előkészíti az ügyfél adatokat a formhoz.
 * 
 * @todo Konstansok Enummá alakítása!
 */
class ClientEditData
{
    /**
     * Meglévő ügyfél adatainak előkészítése.
     * @param \Client $client
     * @return array
     */
    public static function createDataFromExisting(\Client $client)
    {
        $data = array();
        $data['client'] = $client;
        // Megjegyzés objektumok.
        $data['CommentActivity'] = $client->commentactivity;
        $data['CommentClientInformation'] = $client->commentclientinformation;
        //$data['CommentContact'] = $client->commentcontact;
        //$data['CommentDocument'] = $client->commentdocument;
        $data['CommentEducation'] = $client->commenteducation;
        $data['CommentJob'] = $client->commentjob;
        $data['CommentLaborMarket'] = $client->commentlabormarket;
        $data['CommentLogin'] = $client->commentlogin;
        $data['CommentPersonalData'] = $client->commentpersonaldata;
        //$data['CommentProject'] = $client->commentproject;
        $data['CommentProjectInformation'] = $client->commentprojectinformation;
        // Cím objektumok.
        $data['Residence'] = $client->residence;
        $data['DwellingPlace'] = $client->dwellingplace;
        $data['TemporaryResidence'] = $client->temporaryresidence;
        
        $data['LaborMarket'] = $client->labormarket;
        $data['ProjectInformation'] = $client->projectinformation;
        $data['ClientDataStatus'] = $client->clientdatastatus;
        $data['ClientBirthData'] = $client->clientbirthdata;
        $data['UserEducation'] = $client->sheepItEducations();
        $data['UserKnowledge'] = $client->sheepItKnowledges();
        $data['UcKnowledge'] = $client->sheepItComputerKnowledges();
        $data['sheepItMediations'] = $client->sheepItMediations();
        $selectedJobs = $sjFake = $servicesInterested = array();
        // Munkakörök.
        $jobs = $client->jobs;
        // Ha tartozik az ügyfélhez kiválasztott munkakör.
        if (!empty($jobs) && is_array($jobs)) {
            // Akkor bejárja a tömböt.
            foreach ($jobs as $k => $job) {
                $selectedJobs[] = $job->sheepIt2Serializable(); // A munkakör adatait serializálja.
                // Hozzáadja az $sjFake tömbhöz, hogy tudja hány darab van belőle.
                $sjFake[] = array('jobForm_#index#_key' => $k, 'jobForm_#index#_key_error' => '');
            }
        }
        $data['selectedJobs'] = json_encode($selectedJobs); // Kiválasztott munkakörök.
        $data['sjFake'] = json_encode($sjFake); // Fake sheepIt adat.
        // Szolgáltatások.
        $services = $client->services;
        // Ha tartozik az ügyfélhez szolgáltatás.
        if (!empty($services) && is_array($services)) {
            // Akkor bejárja a tömböt.
            foreach ($services as $service) {
                /* @var $service \ServiceInterested */
                $servicesInterested[$service->szolgaltatas_id] = $service->to_array();
                // Majd egy tömbben tárolja a kiválasztott szolgáltatás adatait.
            }
        }
        $data['ServiceInterested'] = $servicesInterested; // Kiválasztott szolgáltatások.
        $data['selectedPis'] = static::getSelectedOptions(
            $client->programinformations, 'program_informacio_id', 'egyeb'
        );
        $data['selectedWss'] = static::getSelectedOptions($client->workschedules, 'munkarend_id', 'munkarend_id');
        return $data;
    }
    /**
     * Új ügyfél adatainak előkészítése.
     * @param \Client $client Ügyfél objektum.
     * @return array
     */
    public static function createDataFromNew(\Client $client)
    {
        $data = array();
        $data['client'] = $client;
        // Megjegyzés objektumok.
        $data['CommentActivity'] = new CommentActivity;
        $data['CommentClientInformation'] = new CommentClientInformation;
        //$data['CommentContact'] = new CommentContact;
        //$data['CommentDocument'] = new CommentDocument;
        $data['CommentEducation'] = new CommentEducation;
        $data['CommentJob'] = new CommentJob;
        $data['CommentLaborMarket'] = new CommentLaborMarket;
        $data['CommentLogin'] = new CommentLogin;
        $data['CommentPersonalData'] = new CommentPersonalData;
        //$data['CommentProject'] = new CommentProject;
        $data['CommentProjectInformation'] = new CommentProjectInformation;
        // Cím objektumok.
        $data['Residence'] = new \Residence;
        $data['DwellingPlace'] = new \DwellingPlace;
        $data['TemporaryResidence'] = new \TemporaryResidence;
        
        $data['LaborMarket'] = new \LaborMarket;
        $data['ProjectInformation'] = new \ProjectInformation;
        $data['ClientDataStatus'] = new \ClientDataStatus;
        $data['ClientBirthData'] = new \ClientBirthData;
        $data['UserEducation'] = 
        $data['UserKnowledge'] = 
        $data['UcKnowledge'] = 
        $data['ServiceInterested'] = 
        $data['sheepItMediations'] = false;
        $data['selectedJobs'] = 
        $data['selectedPis'] = 
        $data['selectedWss'] = array();
        $data['sjFake'] = json_encode(array());
        return $data;
    }
    /**
     * Legenerálja az ügyfél adatokat tartalmazó tömböt.
     * @param \Client $client Ügyfél adatok.
     * @return array
     */
    public static function createClientData(\Client $client)
    {
        return $client->is_new_record() ? static::createDataFromNew($client) : static::createDataFromExisting($client);
    }
    /**
     * 
     * @param mixed $data Adathalmaz.
     * @param string $key Kulcs attribútum neve.
     * @param string $value Érték attribútum neve.
     * @return array
     */
    public static function getSelectedOptions($data, $key, $value)
    {
        return is_array($data) ? ArHelper::result2Options($data, $key, $value) : array();
    }
}