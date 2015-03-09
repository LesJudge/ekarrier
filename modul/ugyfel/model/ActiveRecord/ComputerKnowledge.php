<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_attr_szamitogepes_ismeret_id Azonosító.
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property string $ismeret Számítógépes ismeret.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property User $ugyfel Felhasználó adatai.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél kapcsolat.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class ComputerKnowledge extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_szamitogepes_ismeret';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_szamitogepes_ismeret_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array('ugyfel_attr_szamitogepes_ismeret_id');
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Ügyfél kapcsolat.
        array(
            'client',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client',
            'conditions' => 'ugyfel_aktiv = 1 AND ugyfel_torolt = 0',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'ismeret',
            'message' => 'Kötelező mező!'
        ),
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'ismeret',
            'within' => array(3, 255),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        )
    );
    
    public function get_ugyfel_attr_szamitogepes_ismeret_id()
    {
        return $this->read_attribute('ugyfel_attr_szamitogepes_ismeret_id');
    }
    /**
     * Visszatér az ismerettel.
     * @return string
     */
    public function get_ismeret()
    {
        return $this->read_attribute('ismeret');
    }
    
    public function set_ugyfel_attr_szamitogepes_ismeret_id($ugyfel_attr_szamitogepes_ismeret_id)
    {
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('ugyfel_attr_szamitogepes_ismeret_id', $ugyfel_attr_szamitogepes_ismeret_id, $this);
    }
    /**
     * Beállítja az ismeretet.
     * @param string $ismeret Számítógépes ismeret.
     */
    public function set_ismeret($ismeret)
    {
        $assign = new AssignString;
        $assign->assignAttribute('ismeret', $ismeret, $this);
    }
    /*
    public function before_update()
    {
        parent::before_update();
        if (!$this->is_new_record()) {
            $this->assign_attribute(static::$table_name . '_torolt', 0);
        }
    }
    */
}