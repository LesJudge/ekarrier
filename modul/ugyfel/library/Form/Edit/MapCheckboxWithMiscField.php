<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit;

use Traversable;
use Uniweb\Library\Form\AbstractMap;
use Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects\CheckboxWithMiscField;

abstract class MapCheckboxWithMiscField extends AbstractMap
{
    protected $relation;
    
    protected $recordIdProperty;
    
    protected $idProperty;
    
    protected $nameProperty;
    
    protected $hasFieldProperty;
    
    protected $miscProperty;
    
    public function map()
    {
        $intermediates = array();
        
        if (is_array($this->options) || (is_object($this->options) && $this->options instanceof Traversable)) {
            foreach ($this->options as $option) {
                $selected = null;
                foreach ($this->selectedOptions as $selectedOption) {
                    $programInformation = $selectedOption->{$this->relation};
                    if ($programInformation && $programInformation == $option) {
                        $selected = $selectedOption;
                        break;
                    }
                    //} else {
                    //    $selected = null;
                    //}
                }
                $isSelected = !is_null($selected);
                $intermediates[] = new CheckboxWithMiscField(
                    $isSelected ? $selected->{$this->recordIdProperty} : null,
                    $option->{$this->idProperty}, 
                    $option->{$this->nameProperty}, 
                    $option->{$this->hasFieldProperty}, 
                    $isSelected,
                    $isSelected ? $selected->{$this->miscProperty} : null,
                    $selected
                );
            }
        }
        
        return $intermediates;
    }
}