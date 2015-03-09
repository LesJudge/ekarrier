<?php
namespace Uniweb\Library\Resource\Interfaces;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;

interface ResourceSaveInterface
{
    public function save(
        ResourceInterface $resource, 
        array $relatedModels = array(), 
        array $deletablesByResource = array()
    );
}