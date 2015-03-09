<?php
namespace Uniweb\Library\DynamicFilter\Interfaces;
use Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface;

interface PersistenceInterface
{
    public function create(DynamicFilterInterface $dynamicFilter);
    
    public function destroy(DynamicFilterInterface $dynamicFilter);
    
    public function read(DynamicFilterInterface $dynamicFilter);
}