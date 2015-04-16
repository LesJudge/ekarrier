<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime as AssignDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Assign\Bit as AssignBit;
use Uniweb\Library\Utilities\ActiveRecord\Read\Bit as ReadBit;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;

class Mediation extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_kozvetites';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_kozvetites_id';
    
    public function get_ugyfel_attr_kozvetites_id()
    {
        return $this->read_attribute('ugyfel_attr_kozvetites_id');
    }
    
    public function get_mikor($format = 'Y-m-d')
    {
        $readDateTime = new ReadDateTime($format);
        return $readDateTime->readAttribute('mikor', $this);
    }
    
    public function get_megjelent()
    {
        $readBit = new ReadBit;
        return $readBit->readAttribute('megjelent', $this);
    }
    
    public function get_hova()
    {
        return $this->read_attribute('hova');
    }
    
    public function set_ugyfel_attr_kozvetites_id($ugyfel_attr_kozvetites_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('ugyfel_attr_kozvetites_id', $ugyfel_attr_kozvetites_id, $this);
    }
    
    public function set_mikor($mikor)
    {
        $assignDateTime = new AssignDateTime('Y-m-d');
        $assignDateTime->assignAttribute('mikor', $mikor, $this);
    }
    
    public function set_megjelent($megjelent)
    {
        $assignBit = new AssignBit;
        $assignBit->assignAttribute('megjelent', $megjelent, $this);
    }
    
    public function set_hova($hova)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('hova', $hova, $this);
    }
}