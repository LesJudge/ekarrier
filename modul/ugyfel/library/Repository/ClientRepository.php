<?php
namespace Uniweb\Module\Ugyfel\Library\Repository;

use ActiveRecord\RecordNotFound;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;
use Uniweb\Library\Resource\Interfaces\ResourcableInterface;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;
use Uniweb\Library\Resource\Interfaces\ResourceRepositoryInterface;
use Uniweb\Module\Ugyfel\Library\Resource\ClientResourceSave;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

class ClientRepository implements ResourceRepositoryInterface
{
    /**
     * Létrehoz egy új ügyfél objektumot.
     * @param array $attributes Attribútumok, amiknek az értékeit be kell állítani a példányosításkor.
     * @return Client
     */
    public function instance(array $attributes = array())
    {
        $client = new Client;
        if (!empty($attributes)) {
            foreach ($attributes as $name => $value) {
                $client->{$name} = $value;
            }
        }
        return $client;
    }
    
    /**
     * Összes ügyfél lekérdezése.
     * @return Client[]
     */
    public function findAll()
    {
        return Client::find('all', array('conditions' => array('ugyfel_torolt' => 0)));
    }
    
    /**
     * Lekérdezi az ügyfelet.
     * @param int $id Ügyfél azonosító.
     * @param boolean $withRelations Kapcsolatokkal együtt kérdezze-e le az ügyfelet.
     * @return Client
     * @throws RecordNotFound
     */
    public function findById($id, $withRelations = false)
    {
        $include = array();
        if ($withRelations === true) {
            $include = array(
                'include' => array(
                    'employmentstatus',
                    'jobcategory',
                    'labormarket',
                    'projectinformation',
                    'addresses',
                    'status',
                    'birthdata',
                    'highesteducation',
                    'commentactivity',
                    'commentclientinformation',
                    'commentcontact',
                    'commentdocument',
                    'commenteducation',
                    'commentjob',
                    'commentlabormarket',
                    'commentlogin',
                    'commentpersonaldata',
                    'commentproject',
                    'commentprojectinformation',
                    'educations',
                    'knowledges',
                    'computerknowledges',
                    'services',
                    'programinformations',
                    'workschedules',
                    'projects'
                )
            );
        }
        $client = Client::find_by_pk($id, array('conditions' => array('ugyfel_torolt' => 0) + $include));
        if ($client->ugyfel_torolt == 1) {
            throw new RecordNotFound;
        }
        return $client;
    }
    
    /**
     * Ügyfél mentése.
     * @param ResourceInterface $resource Ügyfél objektum.
     * @param ResourcableInterface[] $relatedModels Kapcsolódó modellek.
     * @return boolean
     */
    public function create(
        ResourceInterface $resource, 
        array $relatedModels = array()
    ) {
        $clientResourceSave = new ClientResourceSave;
        return $clientResourceSave->save($resource, $relatedModels);
    }
    
    public function update(
        ResourceInterface $resource, 
        array $relatedModels = array(), 
        array $deletablesByResource = array()
    ) {
        $clientResourceSave = new ClientResourceSave;
        return $clientResourceSave->save($resource, $relatedModels, $deletablesByResource);
    }
    
    /**
     * Ügyfél törlése azonosító alapján.
     * @param int $id Ügyfél azonosító.
     * @param DeletableByResourceInterface[] $deletablesByResource
     * @return boolean
     * @throws RecordNotFound
     */
    public function delete($id, array $deletablesByResource = array())
    {
        $client = $this->findById($id);
        foreach ($deletablesByResource as $deletableByResource) {
            $deletableByResource->deleteByResource($client);
        }
        $client->ugyfel_torolt = 1;
        return $client->save();
    }
}