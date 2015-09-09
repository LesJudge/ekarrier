<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\Bit as AssignBit;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime as AssignDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Read\Bit as ReadBit;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;
/**
 * Ügyfél munkaerő piaci helyzete ActiveRecord model.
 * 
 * Attribútumok:
 * @property int $ugyfel_id Felhasználó azonosító, akihez tartoznak az adatok.
 * @property int $palyakezdo Pályakezdő-e.
 * @property int $regisztralt_munkanelkuli Regisztrált munkanélküli-e.
 * @property null|\ActiveRecord\DateTime $mikor_regisztralt Mikor regisztrált.
 * @property int $gyes_gyed_visszatero GYES-ről, GYED-ről visszatérő?
 * @property null|\ActiveRecord\DateTime $gyes_gyed_lejarati_datum Mikor jár le a GYES, GYED?
 * @property int $megvaltozott_munkakepessegu Megváltozott munkaképességű-e?
 * @property null|\ActiveRecord\DateTime $kovetkezo_felulvizsgalat_ideje Következő felülvizsgálat ideje.
 * @property string $munkavegzest_korlatozo_egyeb_okok Munkavégzést korlátozó egyéb okok.
 * @property int $dolgozik Dolgozik
 * @property string $dolgozik_nev Cég neve, ha dolgozik.
 * @property string $dolgozik_cim Cég címe, ha dolgozik.
 * @property string $dolgozik_munkakor Munkakör neve, amiben dolgozik, ha dolgozik.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class LaborMarket extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_munkaeropiaci_helyzet';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array('ugyfel_id');
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array(
        array(
            'palyakezdo',
            'in' => array(0, 1, null),
            'message' => 'A "Pályakezdő-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
        ),
        array(
            'regisztralt_munkanelkuli',
            'in' => array(0, 1, null),
            'message' => 'A "Regisztrált munkanélküli-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
        ),
        array(
            'gyes_gyed_visszatero',
            'in' => array(0, 1, null),
            'message' => 'A "GYES-ről, GYED-ről visszatérő ?" mező csak igen-nem, vagy üres értéket vehet fel!'
        ),
        array(
            'megvaltozott_munkakepessegu',
            'in' => array(0, 1, null),
            'message' => 'A "Megváltozott munkaképességű-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
        ),
        array(
            'dolgozik',
            'in' => array(0, 1, null),
            'message' => 'A "Dolgozik" mező csak igen-nem, vagy üres értéket vehet fel!'
        )
    );
    /**
     * Mezők értékeinek formátumára vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array();
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
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
     * Visszatér a pályakezdő mező értékével. (0-1)
     * @return int
     */
    public function get_palyakezdo()
    {
        $bit = new ReadBit;
        return $bit->readAttribute('palyakezdo', $this);
    }
    /**
     * Visszatér a regisztrált munkanélküli mező értékvel. (0-1)
     * @return int
     */
    public function get_regisztralt_munkanelkuli()
    {
        $bit = new ReadBit;
        return $bit->readAttribute('regisztralt_munkanelkuli', $this);
    }
    /**
     * Visszatér a GYES-GYED visszatérő mező értékével. (0-1)
     * @return int
     */
    public function get_gyes_gyed_visszatero()
    {
        $bit = new ReadBit;
        return $bit->readAttribute('gyes_gyed_visszatero', $this);
    }
    /**
     * Visszatér a megváltozott munkaképességű mező értékével. (0-1)
     * @return int
     */
    public function get_megvaltozott_munkakepessegu()
    {
        $bit = new ReadBit;
        return $bit->readAttribute('megvaltozott_munkakepessegu', $this);
    }
    /**
     * Visszatér a dolgozik mező értékével. (0-1)
     * @return int
     */
    public function get_dolgozik()
    {
        $bit = new ReadBit;
        return $bit->readAttribute('dolgozik', $this);
    }
    
    public function get_mikor_regisztralt($format = 'Y-m-d')
    {
        $dateTime = new ReadDateTime($format);
        return $dateTime->readAttribute('mikor_regisztralt', $this);
    }
    
    public function get_gyes_gyed_lejarati_datum($format = 'Y-m-d')
    {
        $dateTime = new ReadDateTime($format);
        return $dateTime->readAttribute('gyes_gyed_lejarati_datum', $this);
    }
    
    public function get_kovetkezo_felulvizsgalat_ideje($format = 'Y-m-d')
    {
        $dateTime = new ReadDateTime($format);
        return $dateTime->readAttribute('kovetkezo_felulvizsgalat_ideje', $this);
    }
    /**
     * Beállítja a "Pályakezdő" mező értékét.
     * @param mixed $palyakezdo
     */
    public function set_palyakezdo($palyakezdo)
    {
        $bit = new AssignBit;
        $bit->assignAttribute('palyakezdo', $palyakezdo, $this);
    }
    /**
     * Beállítja a "Regisztrált munkanélküli" mező értékét.
     * @param mixed $regisztralt_munkanelkuli
     */
    public function set_regisztralt_munkanelkuli($regisztralt_munkanelkuli)
    {
        $bit = new AssignBit;
        $bit->assignAttribute('regisztralt_munkanelkuli', $regisztralt_munkanelkuli, $this);
    }
    /**
     * Beállítja a "GYES-GYED visszatérő" mező értékét.
     * @param mixed $gyes_gyed_visszatero
     */
    public function set_gyes_gyed_visszatero($gyes_gyed_visszatero)
    {
        $bit = new AssignBit;
        $bit->assignAttribute('gyes_gyed_visszatero', $gyes_gyed_visszatero, $this);
    }
    /**
     * Beállítja a "Megváltozott munkaképességű" mező értékét.
     * @param mixed $megvaltozott_munkakepessegu
     */
    public function set_megvaltozott_munkakepessegu($megvaltozott_munkakepessegu)
    {
        $bit = new AssignBit;
        $bit->assignAttribute('megvaltozott_munkakepessegu', $megvaltozott_munkakepessegu, $this);
    }
    /**
     * Beállítja a "Dolgozik" mező értékét.
     * @param mixed $dolgozik
     */
    public function set_dolgozik($dolgozik)
    {
        $bit = new AssignBit;
        $bit->assignAttribute('dolgozik', $dolgozik, $this);
    }
    /**
     * Beállítja a munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül) értékét 
     * tároló mező értékét. (Trimeli!)
     * @param string $value
     */
    public function set_munkavegzest_korlatozo_egyeb_okok($value)
    {
        $this->assign_attribute('munkavegzest_korlatozo_egyeb_okok', trim($value));
    }
    
    public function set_mikor_regisztralt_ev($mikor_regisztralt_ev)
    {
        $this->setMikorRegisztralt('mikor_regisztralt_ev', $mikor_regisztralt_ev);
    }
    
    public function set_mikor_regisztralt_honap($mikor_regisztralt_honap)
    {
        $this->setMikorRegisztralt('mikor_regisztralt_honap', $mikor_regisztralt_honap);
    }
    
    public function set_mikor_regisztralt_nap($mikor_regisztralt_nap)
    {
        $this->setMikorRegisztralt('mikor_regisztralt_nap', $mikor_regisztralt_nap);
    }
    
    public function set_gyes_gyed_lejarati_datum($gyes_gyed_lejarati_datum)
    {
        $dateTime = new AssignDateTime('Y-m-d');
        $dateTime->assignAttribute('gyes_gyed_lejarati_datum', $gyes_gyed_lejarati_datum, $this);
    }
    
    public function set_kovetkezo_felulvizsgalat_ideje($kovetkezo_felulvizsgalat_ideje)
    {
        $dateTime = new AssignDateTime('Y-m-d');
        $dateTime->assignAttribute('kovetkezo_felulvizsgalat_ideje', $kovetkezo_felulvizsgalat_ideje, $this);
    }
    
    private function setMikorRegisztralt($attribute, $value)
    {
        if ($value != '') {
            $value = (int)$value;
        } else {
            $value = null;
        }
        
        $this->assign_attribute($attribute, $value);
    }
}