<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_attr_vegzettseg_id Végzettség azonosító.
 * @property int $nyelv_id Nyelv azonosító.
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property string $iskola Iskola.
 * @property int $kezdet Kezdés éve.
 * @property int $veg Végzés éve.
 * @property string $szak Szak.
 * @property string $megnevezes Megnevezés.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Végzettség létrehozásának ideje.
 * @property ActiveRecord\DateTime $ugyfel_attr_modositas_timestamp Végzettség módosításának ideje.
 * @property int $ugyfel_attr_letrehozo_id Végzettség létrehozójának azonosítója.
 * @property int $ugyfel_attr_modosito_id Végzettség módosítójának azonosítója.
 * @property int $modositas_szama Végzettség módosításának száma.
 * @property int $ugyfel_attr_vegzettseg_aktiv Aktív-e a végzettség.
 * @property int $ugyfel_attr_vegzettseg_torolt Törölt-e a végzettség.
 */
class Education extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_vegzettseg';
    /**
     * Tábla elsődleges kulcsa.
     * @var array
     */
    public static $primary_key = 'ugyfel_attr_vegzettseg_id';
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'vegzettseg_id', 
            'message' => 'A végzettség megadása kötelező!'
        )
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'iskola',
            'allow_blank' => true,
            'within' => array(10, 255),
            'too_short' => 'Legalább 10 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        ),
        array(
            'szak',
            'allow_blank' => true,
            'within' => array(10, 255),
            'too_short' => 'Legalább 10 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        ),
        array(
            'megnevezes',
            'allow_blank' => true,
            'within' => array(3, 255),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        )
    );
    
    public function get_ugyfel_attr_vegzettseg_id()
    {
        return $this->read_attribute('ugyfel_attr_vegzettseg_id');
    }
    /**
     * Visszatér a végzettség azonosítóval.
     * @return int
     */
    public function get_vegzettseg_id()
    {
        return $this->read_attribute('vegzettseg_id');
    }
    /**
     * Visszatér az iskola nevével.
     * @return string
     */
    public function get_iskola()
    {
        return $this->read_attribute('iskola');
    }
    /**
     * Visszatér a kezdés évével.
     * @return null|int
     */
    public function get_kezdet()
    {
        $kezdet = $this->read_attribute('kezdet');
        return $kezdet > 0 ? $kezdet : null;
    }
    /**
     * Visszatér a végzés évével.
     * @return null|int
     */
    public function get_veg()
    {
        $veg = $this->read_attribute('veg');
        return $veg > 0 ? $veg : null;
    }
    /**
     * Visszatér a szak nevével.
     * @return string
     */
    public function get_szak()
    {
        return $this->read_attribute('szak');
    }
    /**
     * Visszatér a megnevezéssel.
     * @return string
     */
    public function get_megnevezes()
    {
        return $this->read_attribute('megnevezes');
    }
    
    public function set_ugyfel_attr_vegzettseg_id($ugyfel_attr_vegzettseg_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('ugyfel_attr_vegzettseg_id', $ugyfel_attr_vegzettseg_id, $this);
    }
    /**
     * Beállítja a végzettség azonosítót.
     * @param int $vegzettseg_id
     */
    public function set_vegzettseg_id($vegzettseg_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('vegzettseg_id', $vegzettseg_id, $this);
    }
    /**
     * Beállítja az iskola nevét.
     * @param string $iskola
     */
    public function set_iskola($iskola)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('iskola', $iskola, $this);
    }
    /**
     * Beállítja a kezdés évét.
     * @param int $kezdet Kezdés éve.
     */
    public function set_kezdet($kezdet)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('kezdet', $kezdet, $this);
    }
    /**
     * Beállítja a végzés évét.
     * @param int $veg Végzés éve.
     */
    public function set_veg($veg)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('veg', $veg, $this);
    }
    /**
     * Beállítja a szak nevét.
     * @param string $szak Szak neve.
     */
    public function set_szak($szak)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('szak', $szak, $this);
    }
    /**
     * Beállítja a megnevezést.
     * @param string $megnevezes Megnevezés.
     */
    public function set_megnevezes($megnevezes)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('megnevezes', $megnevezes, $this);
    }
}