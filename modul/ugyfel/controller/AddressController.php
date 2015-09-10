<?php
namespace Uniweb\Module\Ugyfel\Controller;

use Exception;
use Slim\Slim;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Uniweb\Module\Cim\Library\Repository\CityRepository;
use Uniweb\Module\Cim\Library\Repository\CountryRepository;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;

class AddressController extends SlimBasedController
{
    /**
     * @param Slim $slim Slim objektum.
     */
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }
    
    public function birthplace($clientId)
    {
        try {
            // Ügyfél repository.
            $clientRepo = new ClientRepository;
            
            // Ügyfél lekérdezése.
            $client = $clientRepo->findById($clientId, array('include' => array('birthdata')));
            
            $countryRepo = new CountryRepository();
            $cityRepository = new CityRepository();
            $countryId = 124;
            $birthdata = $client->birthdata;
            if ($birthdata->country) {
                $countryId = $birthdata->country->cim_orszag_id;
            }
            $response = array(
                'countries' => $countryRepo->findAll(),
                'cities' => $cityRepository->findByCountryId($countryId),
                'country_id' => $client->birthdata->country->cim_orszag_id,
                'city_id' => $client->birthdata->city->cim_varos_id
            );
            echo json_encode($response);
        } catch (Exception $ex) {
            $this->slim->response->setStatus(404);
            $this->slim->response->setBody('A keresett ügyfél nem található!');
        }
        $this->stop();
    }
}
