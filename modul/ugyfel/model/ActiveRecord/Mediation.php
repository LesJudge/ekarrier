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
        return (new ReadDateTime($format))->readAttribute('mikor', $this);
    }
    
    public function get_megjelent()
    {
        return (new ReadBit)->readAttribute('megjelent', $this);
    }
    
    public function get_hova()
    {
        return $this->read_attribute('hova');
    }
    
    public function set_ugyfel_attr_kozvetites_id($ugyfel_attr_kozvetites_id)
    {
        (new AssignWithoutCast)->assignAttribute('ugyfel_attr_kozvetites_id', $ugyfel_attr_kozvetites_id, $this);
    }
    
    public function set_mikor($mikor)
    {
        (new AssignDateTime('Y-m-d'))->assignAttribute('mikor', $mikor, $this);
    }
    
    public function set_megjelent($megjelent)
    {
        (new AssignBit)->assignAttribute('megjelent', $megjelent, $this);
    }
    
    public function set_hova($hova)
    {
        (new AssignString)->assignAttribute('hova', $hova, $this);
    }
}