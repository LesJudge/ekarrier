<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime as AssignDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;
/**
 * @property int $ugyfel_attr_esetnaplo_id Esetnapló azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $ugyfel_esetnaplo_tipus_id Esetnapló típus azonosító.
 * @property string $nev Név.
 * @property string $pozicio Pozíció.
 * @property int $megjelent Megjelent-e.
 * @property null|\ActiveRecord\DateTime $datum Dátum.
 * @property string $megjegyzes Megjegyzés.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $aktiv Megjelenik-e a rekord.
 * @property int $torolt Törölt-e a rekord.
 * 
 * <b>Kapcsolatok:</b>
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél adatai.
 */
class Contact extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_esetnaplo';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_esetnaplo_id';
    
    public static $has_one = array(
        // Közvetítés kapcsolat.
        array(
            'mediation',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Mediation',
            'conditions' => 'ugyfel_attr_kozvetites_torolt = 0',
            'foreign_key' => 'ugyfel_attr_esetnaplo_id',
            'primary_key' => 'ugyfel_attr_esetnaplo_id',
            'read_only' => true
        )
    );
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
    
    public static $validates_presence_of = array(
        array(
            'nev',
            'message' => 'Kötelező mező!'
        )
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'nev',
            'allow_blank' => false,
            'within' => array(3, 128),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 128 karakter hosszú lehet!'
        )
        /*,
        array(
            'megjegyzes',
            'allow_blank' => true,
            'minimum' => 3,
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!'
        )
        */
    );
    
    public function get_ugyfel_attr_esetnaplo_id()
    {
        return $this->read_attribute('ugyfel_attr_esetnaplo_id');
    }
    
    public function get_nev()
    {
        return $this->read_attribute('nev');
    }
    
    public function get_datum($format = 'Y-m-d')
    {
        $readDateTime = new ReadDateTime($format);
        return $readDateTime->readAttribute('datum', $this);
    }
    
    public function get_megjegyzes()
    {
        return $this->read_attribute('megjegyzes');
    }
    
    public function set_ugyfel_attr_esetnaplo_id($ugyfel_attr_esetnaplo_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('ugyfel_attr_esetnaplo_id', $ugyfel_attr_esetnaplo_id, $this);
    }
    
    public function set_nev($nev)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('nev', $nev, $this);
    }
    
    public function set_datum($datum)
    {
        $assignDateTime = new AssignDateTime('Y-m-d');
        return $assignDateTime->assignAttribute('datum', $datum, $this);
    }
    
    public function set_megjegyzes($megjegyzes)
    {
        $assignString = new AssignString;
        $assignString->assignAttribute('megjegyzes', $megjegyzes, $this);
    }
}