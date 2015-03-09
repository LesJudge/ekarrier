<?php
namespace Uniweb\Library\Resource\Interfaces;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;

interface ResourceRepositoryInterface
{
    public function instance(array $attributes = array());
    
    public function findAll();
    
    public function findById($id, $withRelations = false);
    
    public function create(ResourceInterface $resource, array $relatedModels = array());
    
    public function update(ResourceInterface $resource, array $relatedModels = array(), array $deletablesByResource = array());
    
    public function delete($id, array $deletablesByResource = array());
}