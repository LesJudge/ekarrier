<?php
namespace Uniweb\Library\Resource\Interfaces;
use \Uniweb\Library\Resource\Interfaces\ResourceInterface;

interface DeletableByResourceInterface
{
    public function deleteByResource(ResourceInterface $resource);
}