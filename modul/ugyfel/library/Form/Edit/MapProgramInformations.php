<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapCheckboxWithMiscField;

class MapProgramInformations extends MapCheckboxWithMiscField
{
    protected $relation = 'programinformation';
    
    protected $recordIdProperty = 'ugyfel_attr_program_informacio_id';
    
    protected $idProperty = 'program_informacio_id';
    
    protected $nameProperty = 'nev';
    
    protected $hasFieldProperty = 'has_field';
    
    protected $miscProperty = 'egyeb';
}