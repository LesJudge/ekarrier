<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Cim\Library\Repository\CountryRepository;
use Uniweb\Module\Cim\Library\Repository\CityRepository;
use Uniweb\Module\Cim\Model\ActiveRecord\AddressView;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Slim\Slim;
use Exception;

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
            $addressFinder = new AddressView;
            $client = (new ClientRepository)->findById($clientId, array('include' => array('birthdata')));
            $countryRepo = new CountryRepository($addressFinder);
            $cityRepository = new CityRepository($addressFinder);
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