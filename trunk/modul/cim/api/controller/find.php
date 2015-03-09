<?php
use Uniweb\Module\Cim\Library\Repository\ConcreteFactory;
use Uniweb\Module\Cim\Model\ActiveRecord\AddressView;
/* @var $app \Slim\Slim */
$app->group('/find', function() use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    // Egyes számban.
    $singular = 'zipcode|country|county|city';
    // Többes számban.
    $plural = 'zipcodes|countries|counties|cities';
    // Finder objektum.
    $finder = new AddressView;
    // Repo factory objektum.
    $repoFactory = new ConcreteFactory;
    /**
     * Lekérdezi az összes rekordot.
     */
    $app->get('/:what/', function($what) use ($repoFactory, $finder) {
        echo json_encode($repoFactory->create($what, $finder)->findAll());
    })->conditions(array('what' => $plural));
    /**
     * Adat lekérdezése azonosító alapján.
     */
    $app->get('/:what/:id/', function($what, $id) use ($app, $repoFactory, $finder) {
        $result = $repoFactory->create($what, $finder)->findById($id);
        if ($result) {
            echo json_encode($result);
        } else {
            $app->response->status(404);
        }
    })->conditions(array('what' => $singular));
    /**
     * Valamilyen adat lekérdezése valami alapján. :)
     */
    $app->get('/:what/by/:by/:id/', function($what, $by, $id) use ($app, $repoFactory, $finder) {
        $repo = $repoFactory->create($what, $finder);
        switch ($by) {
            case 'zipcode':
                //$method = 'findByZipCodeId';
                $method = 'findByZipCode';
                break;
            case 'county':
                $method = 'findByCountyId';
                break;
            case 'country':
                $method = 'findByCountryId';
                break;
            default:
                $method = null;
                break;
        }
        if ($repo && $method) {
            $reflector = new ReflectionObject($repo);
            if ($reflector->hasMethod($method)) {
                echo json_encode($reflector->getMethod($method)->invoke($repo, $id));
            } else {
                throw new BadMethodCallException;
            }
        } else {
            throw new Exception;
        }
    })->conditions(array('what' => $plural, 'by' => $singular));
    
    $app->get('/search/:what/', function($what) use ($app, $finder) {
        $term = $app->request->get('term', null);
        if (is_string($term) && strlen($term) >= 2) {
            
        } else {
            $app->response->setStatus(400);
        }
    })->conditions(array('what' => 'zipcode'));
    /**
     * Nem megfelelő URL vagy Request method.
     */
    $app->notFound(function() use ($app) {
        $app->response->setBody('A keresett erőforrás nem található!');
    });
    /**
     * Szerver hiba.
     */
    $app->error(function(Exception $ex) use ($app) {
        $app->response->setBody('Végzetes hiba!');
    });
});