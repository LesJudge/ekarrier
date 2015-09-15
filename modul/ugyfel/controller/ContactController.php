<?php
namespace Uniweb\Module\Ugyfel\Controller;

use ActiveRecord\RecordNotFound;
use Exception;
use Slim\Slim;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Contact;

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
            $clientRepo = new ClientRepository;
            
            // Lekérdezi az ügyfelet elsődleges kulcs alapján, majd veszi az esetnapló kapcsolatot.
            $client = $clientRepo->findById($id, false);
            $contacts = $client->contacts;
            
            $responseBody = array();
            
            // Megvizsgálja, hogy tartoznak-e az ügyfélhez esetnapló bejegyzések.
            if (is_array($contacts) && !empty($contacts)) {
                // Esetnapló bejegyzés típusok.
                $types = Contact::getTypes();
                
                foreach ($contacts as $contact) {
                    $responseBody[] = array(
                        'id' => $contact->ugyfel_attr_esetnaplo_id,
                        'tipus' => array_key_exists($contact->tipus, $types) ? $types[$contact->tipus] : null,
                        'nev' => $contact->nev,
                        'datum' => $contact->tipus == 1 ? $contact->letrehozas_timestamp->format('Y.m.d') : $contact->datum
                    );
                }
            }
            echo json_encode($responseBody);
        } catch (RecordNotFound $rnf) {
            $this->slim->response->setStatus(404);
        } catch (Exception $ex) {
            $this->slim->response->setStatus(500);
        }
        $this->stop();
    }
    
    public function create($id)
    {
        $this->slim->response->headers->set('Content-Type', 'application/json');
        
        try {
            // POST-olt adatok.
            $attributes = $this->slim->request->post('contact');
            
            if (is_array($attributes)) {
                // Ügyfél azonosító hozzáadása az attribútumokhoz.
                $attributes += ['ugyfel_id' => $id];

                $contact = new Contact($attributes);
                
                if (!$contact->is_valid()) {
                    $this->slim->response->setStatus(400);
                    echo json_encode($contact->errors->get_raw_errors());
                } else {
                    if (!$contact->save()) {
                        $this->slim->response->setStatus(500);
                    }
                }
            }
        } catch (Exception $ex) {
            $this->slim->response->setStatus(500);
        }
        
        $this->stop();
    }
}