<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $munkakor_id Munkakör azonosító.
 */
class Job extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_munkakor';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_munkakor_id';
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'munkakor_nev',
            'message' => 'Kötelező mező!'
        ),
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'munkakor_nev',
            'within' => array(3, 255),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        )
    );
    
    public function get_ugyfel_attr_munkakor_id()
    {
        return $this->read_attribute('ugyfel_attr_munkakor_id');
    }
    
    public function get_munkakor_nev()
    {
        return $this->read_attribute('munkakor_nev');
    }
    
    public function set_ugyfel_attr_munkakor_id($ugyfel_attr_munkakor_id)
    {
        if ($ugyfel_attr_munkakor_id === '') {
            $ugyfel_attr_munkakor_id = null;
        }
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('ugyfel_attr_munkakor_id', $ugyfel_attr_munkakor_id, $this);
    }
    
    public function set_munkakor_nev($munkakor_nev)
    {
        $assign = new AssignString;
        $assign->assignAttribute('munkakor_nev', $munkakor_nev, $this);
    }
    
    public function before_update()
    {
        parent::before_update();
        if (!$this->is_new_record()) {
            $this->assign_attribute(static::$table_name . '_torolt', 0);
        }
    }
}