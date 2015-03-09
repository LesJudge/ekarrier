<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator as RelationCreator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Fixer as RelationFixer;


class ClientRelationCreator
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    protected $prepare;
    /**
     * @var \Uniweb\Library\Utilities\ActiveRecord\Interfaces\RelationCreatorInterface[]
     */
    protected $creators;
    
    public function __construct(Client $client, array $prepare, array $creators)
    {
        $this->client = $client;
        $this->prepare = $prepare;
        $this->creators = $creators;
    }
    
    public function create()
    {
        $relatedObjects = (new RelationCreator($this->client, $this->prepare, $this->creators))->create();
        (new RelationFixer($this->client))->fix($relatedObjects);
        return $relatedObjects;
    }
    /**
     * 
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
    
    public function setPrepare(array $prepare)
    {
        $this->prepare = $prepare;
    }
    
    public function setCreators(array $creators)
    {
        $this->creators = $creators;
    }
}