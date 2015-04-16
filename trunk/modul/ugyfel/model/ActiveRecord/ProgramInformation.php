<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $program_informacio_id Program információ azonosító.
 * @property string $egyeb Egyéb érték.
 * 
 * @property \Uniweb\Module\Beallitas\Model\ActiveRecord\ProgramInformation $programinformation Program információ adatai.
 */
class ProgramInformation extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_program_informacio';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_program_informacio_id';
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Program információ kapcsolat.
        array(
            'programinformation',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\ProgramInformation',
            'conditions' => 'program_informacio_torolt = 0',
            'foreign_key' => 'program_informacio_id',
            'read_only' => true
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'program_informacio_id',
            'message' => 'A program információ megadása kötelező!'
        )
    );
    /**
     * Visszatér a rekord azonosítójával.
     * @return null|int
     */
    public function get_ugyfel_attr_program_informacio_id()
    {
        return $this->read_attribute('ugyfel_attr_program_informacio_id');
    }
    /**
     * Visszatér a program információ azonosítóval.
     * @return int
     */
    public function get_program_informacio_id()
    {
        return $this->read_attribute('program_informacio_id');
    }
    
    public function get_egyeb()
    {
        return $this->read_attribute('egyeb');
    }
    /**
     * Beállítja a rekord azonosítóját.
     * @param mixed $ugyfel_attr_program_informacio_id
     */
    public function set_ugyfel_attr_program_informacio_id($ugyfel_attr_program_informacio_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute(
            'ugyfel_attr_program_informacio_id', 
            $ugyfel_attr_program_informacio_id, 
            $this
        );
    }
    
    public function set_program_informacio_id($program_informacio_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('program_informacio_id', $program_informacio_id, $this);
    }
    
    public function set_egyeb($egyeb)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('egyeb', $egyeb, $this);
    }
}