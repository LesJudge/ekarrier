<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_attr_cim_id Cím azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $ugyfel_cim_tipus_id Cím típus azonosító.
 * @property int $cim_orszag_id Ország azonosító.
 * @property int $cim_megye_id Megye azonosító.
 * @property int $cim_varos_id Város azonosító.
 * @property int $cim_iranyitoszam_id Irányítószám azonosító.
 * @property string $utca Utca.
 * @property string $hazszam Házszám.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $ugyfel_attr_cim_aktiv Aktív-e a rekord.
 * @property int $ugyfel_attr_cim_torolt Törölt-e a rekord.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Beallitas\Model\ActiveRecord\AddressType $type Típus.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\County $county Megye adatai.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\Country $country Ország adatai.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\City $city Város adatai.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\ZipCode $zipcode Irányítószám adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class Address extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_cim';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_cim_id';
    /**
     * "Védett" attribútumok.
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_cim_tipus_id'
    );
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Típus kapcsolat.
        array(
            'type',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\AddressType',
            'foreign_key' => 'ugyfel_cim_tipus_id',
            'read_only' => true
        ),
        // Megye kapcsolat.
        array(
            'county',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\County',
            'conditions' => 'cim_megye_aktiv = 1 AND cim_megye_torolt = 0',
            'foreign_key' => 'cim_megye_id',
            'read_only' => true
        ),
        // Ország kapcsolat.
        array(
            'country',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\Country',
            'conditions' => 'cim_orszag_aktiv = 1 AND cim_orszag_torolt = 0',
            'foreign_key' => 'cim_orszag_id',
            'read_only' => true
        ),
        // Város kapcsolat.
        array(
            'city',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\City',
            'conditions' => 'cim_varos_aktiv = 1 AND cim_varos_torolt = 0',
            'foreign_key' => 'cim_varos_id',
            'read_only' => true
        ),
        // Irányítószám kapcsolat.
        array(
            'zipcode',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\ZipCode',
            'conditions' => 'cim_iranyitoszam_aktiv = 1 AND cim_iranyitoszam_torolt = 0',
            'foreign_key' => 'cim_iranyitoszam_id',
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
            'ugyfel_cim_tipus_id',
            'message' => 'Kötelező mező!'
        ),
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    /*
    public static $validates_length_of = array(
        array(
            'ismeret',
            'within' => array(3, 255),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 255 karakter hosszú lehet!'
        )
    );
     * 
     */
    
    public function get_ugyfel_attr_cim_id()
    {
        return $this->read_attribute('ugyfel_attr_cim_id');
    }
    
    public function set_ugyfel_attr_cim_id($ugyfel_attr_cim_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('ugyfel_attr_cim_id', $ugyfel_attr_cim_id, $this);
    }
    
    public function set_ugyfel_cim_tipus_id($ugyfel_cim_tipus_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('ugyfel_cim_tipus_id', $ugyfel_cim_tipus_id, $this);
    }
    
    public function set_cim_orszag_id($cim_orszag_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('cim_orszag_id', $cim_orszag_id, $this);
    }
    
    public function set_cim_megye_id($cim_megye_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('cim_megye_id', $cim_megye_id, $this);
    }
    
    public function set_cim_varos_id($cim_varos_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('cim_varos_id', $cim_varos_id, $this);
    }
    
    public function set_cim_iranyitoszam_id($cim_iranyitoszam_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('cim_iranyitoszam_id', $cim_iranyitoszam_id, $this);
    }
    
    public function set_utca($utca)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('utca', $utca, $this);
    }
    
    public function set_hazszam($hazszam)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('hazszam', $hazszam, $this);
    }
}