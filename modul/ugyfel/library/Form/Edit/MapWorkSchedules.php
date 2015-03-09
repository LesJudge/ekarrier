<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapCheckboxWithMiscField;

class MapWorkSchedules extends MapCheckboxWithMiscField
{
    protected $relation = 'workschedule';
    
    protected $recordIdProperty = 'ugyfel_attr_munkarend_id';
    
    protected $idProperty = 'munkarend_id';
    
    protected $nameProperty = 'nev';
    
    protected $hasFieldProperty = 'has_field';
    
    protected $miscProperty = 'egyeb';
}