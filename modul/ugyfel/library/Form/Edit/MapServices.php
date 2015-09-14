<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit;

use Traversable;
use Uniweb\Library\Form\AbstractMap;
use Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects\Service;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested;
use Uniweb\Module\Szolgaltatas\Model\ActiveRecord\Service as ServiceModel;

class MapServices extends AbstractMap
{
    public function map()
    {
        $intermediates = array();
        
        if (is_array($this->options) || (is_object($this->options) && $this->options instanceof Traversable)) {
            /* @var $option ServiceModel */
            foreach ($this->options as $option) {
                $selected = null;
                /* @var $selectedOption ServiceInterested */
                foreach ($this->selectedOptions as $selectedOption) {                
                    $service = $selectedOption->service;
                    if ($service && $service->id == $option->id) {
                        $selected = $selectedOption;
                        break;
                    } else {
                        $selected = null;
                    }
                }
                
                $intermediates[] = new Service($option, $selected);
            }
        }
        
        return $intermediates;
    }
}