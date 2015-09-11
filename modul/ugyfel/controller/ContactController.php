<?php
namespace Uniweb\Module\Ugyfel\Controller;

use ActiveRecord\RecordNotFound;
use Exception;
use Slim\Slim;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Contact;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Mediation;

class ContactController extends SlimBasedController
{
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }
    
    public function contacts($id)
    {
        $this->slim->response->headers->set('Content-Type', 'application/json');
        try {
            /* @var $contacts Contact */
            $clientRepo = new ClientRepository;
            $contacts = $clientRepo->findById($id, false)->contacts;
            $responseBody = array();
            if (is_array($contacts) && !empty($contacts)) {
                foreach ($contacts as $contact) {
                    $mediation = $contact->mediation;
                    $data = array(
                        'megjegyzes' => $contact->megjegyzes,
                        'datum' => $contact->datum,
                        'nev' => $contact->nev,
                        'kozvetites' => is_object($mediation),
                        'hova' => null,
                        'megjelent' => null,
                        'mikor' => null
                    );
                    if (is_object($mediation)) {
                        $data['hova'] = $mediation->hova;
                        $data['megjelent'] = $mediation->megjelent;
                        $data['mikor'] = $mediation->mikor;
                    }
                    $responseBody[] = $data;
                }
            }
            echo json_encode($responseBody);
        } catch (RecordNotFound $rnf) {
            $this->slim->response->setStatus(404);
        }
        $this->stop();
    }
    
    public function create($id)
    {
        $this->slim->response->headers->set('Content-Type', 'application/json');
        if ($this->slim->request->post('contact', null) != null) {
            $contactData = $this->slim->request->post('contact');
            if (is_array($contactData)) {
                $getIndex = function($data, $index) {
                    return isset($data[$index]) ? $data[$index] : '';
                };
                $isMediation = false;
                $mediation = null;
                // Esetnapló
                $contact = new Contact;
                $contact->ugyfel_id = $id;
                $contact->nev = $getIndex($contactData, 'nev');
                $contact->datum = $getIndex($contactData, 'datum');
                $contact->megjegyzes = $getIndex($contactData, 'megjegyzes');
                // Ha közvetítés.
                if ($getIndex($contactData, 'isMediation') == 1 && is_array($getIndex($contactData, 'mediation'))) {
                    $mediation = new Mediation;
                    $mediation->hova = $getIndex($contactData['mediation'], 'hova');
                    $mediation->megjelent = $getIndex($contactData['mediation'], 'megjelent');
                    $mediation->mikor = $getIndex($contactData['mediation'], 'mikor');
                    $isMediation = true;
                }
                // Validálás, mentés.
                $connection = $contact->connection();
                $connection->transaction();
                try {
                    $contactIsValid = $contact->is_valid();
                    $mediationIsValid = $isMediation ? $mediation->is_valid() : true;
                    if ($contactIsValid && $mediationIsValid) {
                        $contactSaved = $contact->save(false);
                        $mediationSaved = true;
                        if ($isMediation) {
                            $mediation->ugyfel_attr_esetnaplo_id = $contact->ugyfel_attr_esetnaplo_id;
                            $mediationSaved = $mediation->save(false);
                        }
                        if ($contactSaved && $mediationSaved) {
                            $connection->commit();
                            $this->slim->status(200);
                        } else {
                            throw new Exception;
                        }
                    } else {
                        $this->slim->status(400);
                        $connection->rollback();
                    }
                } catch (Exception $ex) {
                    $connection->rollback();
                    $this->slim->status(500);
                }
            } else {
                $this->slim->status(400);
            }
        }
        $this->stop();
    }
}