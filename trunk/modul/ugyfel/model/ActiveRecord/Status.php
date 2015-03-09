<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
/**
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $aktualis_statusz Aktuális státusz azonosító.
 * @property int $kovetkezo_statusz Következő státusz azonosító.
 * @property int $idotartam Időtartam.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus $statuscurrent Aktuális státusz kapcsolat adatai.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus $statusnext Következő státusz kapcsolat adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class Status extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_statusz';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Aktuális státusz kapcsolat.
        array(
            'statuscurrent',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\ClientStatus',
            'conditions' => 'ugyfel_statusz_aktiv = 1 AND ugyfel_statusz_torolt = 0',
            'foreign_key' => 'aktualis_statusz',
            'read_only' => true
        ),
        // Következő státusz kapcsolat.
        array(
            'statusnext',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\ClientStatus',
            'conditions' => 'ugyfel_statusz_aktiv = 1 AND ugyfel_statusz_torolt = 0',
            'foreign_key' => 'kovetkezo_statusz',
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
    
    public function attributeLabels()
    {
        return array(
            'ugyfel_id' => 'Ügyfél azonosító',
            'aktualis_statusz' => 'Aktuális státusz',
            'kovetkezo_statusz' => 'Következő státusz',
            'idotartam' => 'Időtartam',
            'letrehozo_id' => 'Létrehozó felhasználó azonosítója',
            'modosito_id' => 'Módosító felhasználó azonosítója',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma'
        );
    }
    
    public static function getResourceKey()
    {
        return 'ugyfel_id';
    }
    /*
    public function validate()
    {
        $naturalNumber = new NaturalNumber;
        if (!is_null($this->aktualis_statusz) && !$naturalNumber->validate($this->aktualis_statusz)) {
            $this->errors->add('aktualis_statusz', 'Az aktuális státusz azonosító nem megfelelő!');
        }
        if (!is_null($this->kovetkezo_statusz) && !$naturalNumber->validate($this->kovetkezo_statusz)) {
            $this->errors->add('kovetkezo_statusz', 'A következő státusz azonosító nem megfelelő!');
        }
        if (!is_null($this->idotartam) && !$naturalNumber->validate($this->idotartam)) {
            $this->errors->add('idotartam', 'Az időtartam nem megfelelő!');
        }
        if (!is_null($this->letrehozo_id) && !$naturalNumber->validate($this->letrehozo_id)) {
            $this->errors->add('letrehozo_id', 'A létrehozó felhasználó azonosítója nem megfelelő!');
        }
        if (!is_null($this->modosito_id) && !$naturalNumber->validate($this->modosito_id)) {
            $this->errors->add('modosito_id', 'A módosító felhasználó azonosítója nem megfelelő!');
        }
        $naturalNumber->setZeroIsNatural(true);
        if (!is_null($this->modositas_szama) && !$naturalNumber->validate($this->modositas_szama)) {
            $this->errors->add('modositas_szama', 'A módosítás száma nem megfelelő!');
        }
    }
    */
    public function set_ugyfel_id($ugyfel_id)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute('ugyfel_id', $ugyfel_id, $this);
    }
    
    public function set_aktualis_statusz($aktualis_statusz)
    {
        if ($aktualis_statusz === '') {
            $aktualis_statusz = null;
        }
        $assign = new WithoutCast;
        $assign->assignAttribute('aktualis_statusz', $aktualis_statusz, $this);
    }
    
    public function set_kovetkezo_statusz($kovetkezo_statusz)
    {
        if ($kovetkezo_statusz === '') {
            $kovetkezo_statusz = null;
        }
        $assign = new WithoutCast;
        $assign->assignAttribute('kovetkezo_statusz', $kovetkezo_statusz, $this);
    }
    
    public function set_idotartam($idotartam)
    {
        if ($idotartam === '') {
            $idotartam = null;
        }
        $assign = new WithoutCast;
        $assign->assignAttribute('idotartam', $idotartam, $this);
    }
}