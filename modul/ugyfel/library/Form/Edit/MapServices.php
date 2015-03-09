<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit;
use Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects\Service;
use Uniweb\Library\Form\AbstractMap;

class MapServices extends AbstractMap
{
    public function map()
    {
        $intermediates = array();
        /* @var $option \Uniweb\Module\Szolgaltatas\Model\ActiveRecord\Service */
        foreach ($this->options as $option) {
            $selected = null;
            /* @var $selectedOption \Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested */
            foreach ($this->selectedOptions as $selectedOption) {
                $programInformation = $selectedOption->service;
                if ($programInformation && $programInformation == $option) {
                    $selected = $selectedOption;
                    break;
                }
                //} else {
                //    $selected = null;
                //}
            }
            /* @var $selected \Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested */
            $isSelected = !is_null($selected);
            $intermediates[] = new Service(
                $isSelected ? $selected->ugyfel_attr_szolgaltatas_erdekelt_id : null,
                $option->szolgaltatas_id, 
                $option->nev, 
                $isSelected, 
                $isSelected ? $selected->reszt_akar_venni : null, 
                $isSelected ? $selected->reszt_vett : null, 
                $isSelected ? $selected->mikor : null,
                $selected
            );
        }
        return $intermediates;
    }
}