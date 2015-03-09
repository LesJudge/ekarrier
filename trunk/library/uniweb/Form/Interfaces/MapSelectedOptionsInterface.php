<?php
namespace Uniweb\Library\Form\Interfaces;

interface MapSelectedOptionsInterface
{
    /**
     * @return \Uniweb\Library\Form\Interfaces\IntermediateObjectInterface[] IntermediateObjectInterface collection.
     */
    public function map();
    
    public function getOptions();
    
    public function getSelectedOptions();
    
    public function setOptions(array $options);
    
    public function setSelectedOptions(array $options = null);
}