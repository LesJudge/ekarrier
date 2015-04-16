<?php
namespace Uniweb\Module\Ugyfel\Library\Repository;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Module\Ugyfel\Library\Resource\ClientResourceSave;
use Uniweb\Library\Resource\Interfaces\ResourceRepositoryInterface;

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
     * @return \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client[]
     */
    public function findAll()
    {
        return Client::find('all', array('conditions' => array('ugyfel_torolt' => 0)));
    }
    /**
     * Lekérdezi az ügyfelet.
     * @param int $id Ügyfél azonosító.
     * @param boolean $withRelations Kapcsolatokkal együtt kérdezze-e le az ügyfelet.
     * @return \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client
     * @throws \ActiveRecord\RecordNotFound
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
            throw new \ActiveRecord\RecordNotFound;
        }
        return $client;
    }
    /**
     * Ügyfél mentése.
     * @param \Uniweb\Library\Resource\Interfaces\ResourceInterface $resource Ügyfél objektum.
     * @param \Uniweb\Library\Resource\Interfaces\ResourcableInterface[] $relatedModels Kapcsolódó modellek.
     * @return boolean
     */
    public function create(
        \Uniweb\Library\Resource\Interfaces\ResourceInterface $resource, 
        array $relatedModels = array()
    ) {
        $clientResourceSave = new ClientResourceSave;
        return $clientResourceSave->save($resource, $relatedModels);
    }
    
    public function update(
        \Uniweb\Library\Resource\Interfaces\ResourceInterface $resource, 
        array $relatedModels = array(), 
        array $deletablesByResource = array()
    ) {
        $clientResourceSave = new ClientResourceSave;
        return $clientResourceSave->save($resource, $relatedModels, $deletablesByResource);
    }
    /**
     * Ügyfél törlése azonosító alapján.
     * @param int $id Ügyfél azonosító.
     * @param \Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface[] $deletablesByResource
     * @return boolean
     * @throws \ActiveRecord\RecordNotFound
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