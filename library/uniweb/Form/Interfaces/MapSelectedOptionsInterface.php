<?php
namespace Uniweb\Library\Form\Interfaces;

interface MapSelectedOptionsInterface
{
    /**
     * @return IntermediateObjectInterface[] IntermediateObjectInterface collection.
     */
    public function map();
    
    public function getOptions();
    
    public function getSelectedOptions();
    
    public function setOptions(array $options);
    
    public function setSelectedOptions(array $options = null);
}