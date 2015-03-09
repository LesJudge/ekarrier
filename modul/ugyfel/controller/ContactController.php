<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Slim\Slim;

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
            /* @var $contacts \Uniweb\Module\Ugyfel\Model\ActiveRecord\Contact */
            $contacts = (new ClientRepository)->findById($id, false)->contacts;
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
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            $this->slim->response->setStatus(404);
        }
        $this->stop();
    }
    
    public function create($id, array $data)
    {
        
    }
}