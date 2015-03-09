<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Resource\Interfaces\ResourcableInterface;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\Bit as BitAssign;
use Uniweb\Library\Utilities\ActiveRecord\Read\Bit as BitRead;
/**
 * Project információ ActiveRecord model.
 * 
 * Attribútumok:
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $eu_prog_elm_ket_ev Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?
 * @property int $hazai_prog_elm_ket_ev Hazai finanszírozású programban részt vett-e az elmúlt 2 évben?
 * @property int $kozvetitio_adatbazisba_kivan_kerulni Közvetítői adatbázisba kíván e kerülni?
 * @property int $hozzajarul_a_munkakozvetiteshez Hozzájárult-e munkaközvetítéshez?
 * @property int $mobilitast_vallal Mobilitást vállal e?
 * @property string $mobilitast_vallal_megjegyzes Megjegyzés a mobilitást vállal-e értékhez.
 * @property int $egy_megall_ktttnk_prog Együttműködési megállapodást kötöttünk-e vele a programba?
 * @property int $egy_megall_ktttnk_kepz Együttműködési megállapodást kötöttünk-e vele a képzésbe?
 * @property int $kepzes_bekerult Melyik képzésbe került be?
 * @property mixed $munkarend_id Munkarend azonosító.
 * @property mixed $karrierpont_id Hova érkezett be az ügyfél.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Beallitas\Model\ActiveRecord\CameTo $cameto Hova érkezett be az ügyfél.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Rekordot létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Rekordot módosító felhasználó adatai.
 */
class ProjectInformation extends Behaviorable implements ResourcableInterface
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_projekt_informacio';
    /**
     * Elsődleges kulcs.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Hova érkezett kapcsolat.
        array(
            'cameto',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\CameTo',
            'conditions' => 'karrierpont_aktiv = 1 AND karrierpont_torolt = 0',
            'foreign_key' => 'karrierpont_id',
            'read_only' => true,
            'select' => 'karrierpont_id, nev'
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
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array();
/*
    public function after_construct()
    {
        // Táblában lévő összes BIT (0-1) attribútum.
        $incAttrs = array(
            'eu_prog_elm_ket_ev', 
            'hazai_prog_elm_ket_ev', 
            'kozvetitio_adatbazisba_kivan_kerulni', 
            'hozzajarul_a_munkakozvetiteshez',
            'mobilitast_vallal', 
            'egy_megall_ktttnk_prog', 
            'egy_megall_ktttnk_kepz'
        );
        foreach($incAttrs as $inclusion) {
            static::$validates_inclusion_of[] = array(
                $inclusion,
                'allow_blank' => false,
                'in' => array(0, 1, null),
                'message' => 'Csak igen-nem értéket vehet fel!'
            ); // Validációs szabály hozzáadása a tömbhöz.
        }
    }
*/    
    public function behaviors()
    {
        return array(
            'author' => new Author('letrehozo_id', 'modosito_id'),
            'modifications' => new NumberOfModifications('modositas_szama'),
            'timestamp' => new Timestamp('letrehozas_timestamp', 'modositas_timestamp')
        );
    }
    
    public static function getResourceKey()
    {
        return static::$primary_key;
    }
    /**
     * Visszatér az "Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékével. (0-1)
     * @return int
     */
    public function get_eu_prog_elm_ket_ev()
    {
        $bit = new BitRead;
        return $bit->readAttribute('eu_prog_elm_ket_ev', $this);
    }
    /**
     * Visszatér a "Hazai finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékével. (0-1)
     * @return int
     */
    public function get_hazai_prog_elm_ket_ev()
    {
        $bit = new BitRead;
        return $bit->readAttribute('hazai_prog_elm_ket_ev', $this);
    }
    /**
     * Visszatér a "Közvetítői adatbázisba kíván e kerülni ?" mező értékével. (0-1)
     * @return int
     */
    public function get_kozvetitio_adatbazisba_kivan_kerulni()
    {
        $bit = new BitRead;
        return $bit->readAttribute('kozvetitio_adatbazisba_kivan_kerulni', $this);
    }
    /**
     * Visszatér a "Hozzájárult-e munkaközvetítéshez ?" mező értékével. (0-1)
     * @return int
     */
    public function get_hozzajarul_a_munkakozvetiteshez()
    {
        $bit = new BitRead;
        return $bit->readAttribute('hozzajarul_a_munkakozvetiteshez', $this);
    }
    /**
     * Visszatér a "Mobilitást vállal e ?" mező értékével. (0-1)
     * @return int
     */
    public function get_mobilitast_vallal()
    {
        $bit = new BitRead;
        return $bit->readAttribute('mobilitast_vallal', $this);
    }
    /**
     * Visszatér az "Együttműködési megállapodást kötöttünk-e vele a programba ?" mező érétkével. (0-1)
     * @return int
     */
    public function get_egy_megall_ktttnk_prog()
    {
        $bit = new BitRead;
        return $bit->readAttribute('egy_megall_ktttnk_prog', $this);
    }
    /**
     * Visszatér az "Együttműködési megállapodást kötöttünk-e vele a képzésbe ?" mező értékével. (0-1)
     * @return int
     */
    public function get_egy_megall_ktttnk_kepz()
    {
        $bit = new BitRead;
        return $bit->readAttribute('egy_megall_ktttnk_kepz', $this);
    }
    /**
     * Beállítja az "Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékét.
     * @param mixed $eu_prog_elm_ket_ev
     */
    public function set_eu_prog_elm_ket_ev($eu_prog_elm_ket_ev)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('eu_prog_elm_ket_ev', $eu_prog_elm_ket_ev, $this);
    }
    /**
     * Beállítja a "Hazai finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékét.
     * @param mixed $hazai_prog_elm_ket_ev
     */
    public function set_hazai_prog_elm_ket_ev($hazai_prog_elm_ket_ev)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('hazai_prog_elm_ket_ev', $hazai_prog_elm_ket_ev, $this);
    }
    /**
     * Beállítja a "Közvetítői adatbázisba kíván e kerülni ?" mező értékét.
     * @param mixed $kozvetitio_adatbazisba_kivan_kerulni
     */
    public function set_kozvetitio_adatbazisba_kivan_kerulni($kozvetitio_adatbazisba_kivan_kerulni)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('kozvetitio_adatbazisba_kivan_kerulni', $kozvetitio_adatbazisba_kivan_kerulni, $this);
    }
    /**
     * Beállítja a "Hozzájárult-e munkaközvetítéshez ?" mező értékét.
     * @param mixed $hozzajarul_a_munkakozvetiteshez
     */
    public function set_hozzajarul_a_munkakozvetiteshez($hozzajarul_a_munkakozvetiteshez)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('hozzajarul_a_munkakozvetiteshez', $hozzajarul_a_munkakozvetiteshez, $this);
    }
    /**
     * Beállítja a "Mobilitást vállal e ?" mező értékét.
     * @param mixed $mobilitast_vallal
     */
    public function set_mobilitast_vallal($mobilitast_vallal)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('mobilitast_vallal', $mobilitast_vallal, $this);
    }
    /**
     * Beállítja az "Együttműködési megállapodást kötöttünk-e vele a programba ?" mező értékét.
     * @param mixed $egy_megall_ktttnk_prog
     */
    public function set_egy_megall_ktttnk_prog($egy_megall_ktttnk_prog)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('egy_megall_ktttnk_prog', $egy_megall_ktttnk_prog, $this);
    }
    /**
     * Beállítja az "Együttműködési megállapodást kötöttünk-e vele a képzésbe ?" mező értékét.
     * @param mixed $egy_megall_ktttnk_kepz
     */
    public function set_egy_megall_ktttnk_kepz($egy_megall_ktttnk_kepz)
    {
        $bit = new BitAssign;
        $bit->assignAttribute('egy_megall_ktttnk_kepz', $egy_megall_ktttnk_kepz, $this);
    }
    /**
     * Beállítja a munkarend_id mező értékét.
     * @param mixed $munkarend_id
     */
    public function set_munkarend_id($munkarend_id)
    {
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('munkarend_id', $munkarend_id, $this);
    }
    /**
     * Beállítja a hova érkezett mező értékét.
     * @param mixed $karrierpont_id
     */
    public function set_karrierpont_id($karrierpont_id)
    {
        if ($karrierpont_id === '') {
            $karrierpont_id = null;
        }
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('karrierpont_id', $karrierpont_id, $this);
    }
}