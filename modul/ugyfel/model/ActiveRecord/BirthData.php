<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime as AssignDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
use Uniweb\Library\Validator\NaturalNumber;
/**
 * Születési adatok model.
 * 
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property string $vezeteknev Vezetéknév.
 * @property string $keresztnev Keresztnév.
 * @property int $orszag_id Ország azonosító.
 * @property int $varos_id Város azonosító.
 * @property mixed $szuletesi_ido Születési idő.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél kapcsolat.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\Country $country Ország kapcsolat.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\City $city Város adatok.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 * 
 * @method self in(string $behavior_name) Szűrés az adott behavior-re.
 * @method mixed get_letrehozo_id() Visszatér a létrehozó felhasználó azonosítójával.
 * @method mixed get_modosito_id() Visszatér a módosító felhasználó azonosítójával.
 * @method mixed set_letrehozo_id(int $letrehozo_id) Beállítja a létrehozó felhasználó azonosítóját.
 * @method mixed set_modosito_id(int $modosito_id) Beállítja a módosító felhasználó azonosítóját.
 */
class BirthData extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_szuletesi_adatok';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key  = 'ugyfel_id';
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
        // Ország kapcsolat.
        array(
            'country',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\Country',
            'conditions' => 'cim_orszag_aktiv = 1 AND cim_orszag_torolt = 0',
            'foreign_key' => 'orszag_id',
            'read_only' => true
        ),
        // Város kapcsolat.
        array(
            'city',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\City',
            'conditions' => 'cim_varos_aktiv = 1 AND cim_varos_torolt = 0',
            'foreign_key' => 'varos_id',
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
     * String típusú attribútumok értékeinek vizsgálata.
     * @var array 
     */
    public static $validates_length_of = array(
        array(
            'vezeteknev',
            'within' => array(3, 128),
            'too_short' => 'A vezetéknév túl rövid, legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'A vezetéknév túl hosszú, legfeljebb 128 karakter hosszú lehet!',
            'allow_blank' => true
        ),
        array(
            'keresztnev',
            'within' => array(3, 128),
            'too_short' => 'A keresztnév túl rövid, legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'A keresztnév túl hosszú, legfeljebb 128 karakter hosszú lehet!',
            'allow_blank' => true
        )
    );
    
    public function validate()
    {
        parent::validate();
        $naturalNumber = new NaturalNumber;
        
        $countryId = $this->read_attribute('orszag_id');
        $cityId = $this->read_attribute('varos_id');
        
        if (!is_null($countryId) && !$naturalNumber->validate($countryId)) {
            $this->errors->add('orszag_id', 'Az ország azonosító nem megfelelő!');
        }
        if (!is_null($cityId) && !$naturalNumber->validate($cityId)) {
            $this->errors->add('varos_id', 'A város azonosító nem megfelelő!');
        }
        if ($this->szuletesi_ido === false) {
            $this->errors->add('szuletesi_ido', 'A születési idő nem megfelelő! (éééé-hh-nn)');
        }
    }
    /**
     * Visszatér a vezetéknévvel.
     * @return string
     */
    public function get_vezeteknev()
    {
        return $this->read_attribute('vezeteknev');
    }
    /**
     * Visszatér a keresztnévvel.
     * @return string
     */
    public function get_keresztnev()
    {
        return $this->read_attribute('keresztnev');
    }
    /**
     * Visszatér az ország azonosítóval.
     * @return null|int
     */
    public function get_orszag_id()
    {
        return $this->read_attribute('orszag_id');
    }
    /**
     * Visszatér a város azonosítóval.
     * @return null|int
     */
    public function get_varos_id()
    {
        return $this->read_attribute('varos_id');
    }
    /**
     * Beállítja a vezetéknevet.
     * @param string $vezeteknev
     */
    public function set_vezeteknev($vezeteknev)
    {
        $assign = new AssignString;
        $assign->assignAttribute('vezeteknev', $vezeteknev, $this);
    }
    /**
     * Beállítja a keresztnevet.
     * @param string $keresztnev
     */
    public function set_keresztnev($keresztnev)
    {
        $assign = new AssignString;
        $assign->assignAttribute('keresztnev', $keresztnev, $this);
    }
    /**
     * Beállítja az ország azonosítót.
     * @param null|int $orszag_id Ország azonosító.
     */
    public function set_orszag_id($orszag_id)
    {
        if ($orszag_id === '') {
            $orszag_id = null;
        } else {
            $orszag_id = (int)$orszag_id;
        }
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('orszag_id', $orszag_id, $this);
    }
    /**
     * Beállítja a város azonosítót.
     * @param null|int $varos_id Város azonosító.
     */
    public function set_varos_id($varos_id)
    {
        if ($varos_id === '') {
            $varos_id = null;
        } else {
            $varos_id = (int)$varos_id;
        }
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('varos_id', $varos_id, $this);
    }
    /**
     * Beállítja a születési időt.
     * @param null|string $szuletesi_ido Születési idő.
     */
    public function set_szuletesi_ido($szuletesi_ido)
    {
        if (is_null($szuletesi_ido) || $szuletesi_ido === '') {
            $assign = new AssignWithoutCast;
            $assign->assignAttribute('szuletesi_ido', null, $this);
        } else {
            $assign = new AssignDateTime('Y-m-d');
            $assign->assignAttribute('szuletesi_ido', $szuletesi_ido, $this);
        }
    }
}