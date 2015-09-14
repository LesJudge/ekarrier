<?php
namespace Uniweb\Module\Szolgaltatas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * Szolgáltatás ActiveRecord Model.
 * 
 * @property int $szolgaltatas_id Szolgáltatás azonosító.
 * @property string $nev Szolgáltatás neve.
 * @property string $leiras Szolgáltatás leírása.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítások száma.
 * @property int $szolgaltatas_aktiv Aktív-e a képzés.
 * @property int $szolgaltatas_torolt Törölt-e a képzés.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Service extends Behaviorable
{
    /**
     * Ügyfél szolgáltatás típus.
     */
    const TYPE_CLIENT = 'ugyfel';
    
    /**
     * Cég szolgáltatás típus.
     */
    const TYPE_COMPANY = 'ceg';
    
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'szolgaltatas';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'szolgaltatas_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'szolgaltatas_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * Alias példányváltozók.
     * @var array
     */
    public static $alias_attribute = array(
        'label' => 'nev',
        'value' => 'szolgaltatas_id'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
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
            'within' => array(3, 128),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 128 karakter hosszú lehet!'
        )
    );
    /**
     * Visszatér a szolgáltatás nevével.
     * @return string
     */
    public function get_nev()
    {
        return $this->read_attribute('nev');
    }
    /**
     * Visszatér a szolgáltatás leírásával.
     * @return string
     */
    public function get_leiras()
    {
        return $this->read_attribute('leiras');
    }
    /**
     * Beállítja a nev mező értékét.
     * @param string $nev
     */
    public function set_nev($nev)
    {
        $assign = new AssignString;
        $assign->assignAttribute('nev', $nev, $this);
    }
    /**
     * Beállítja a leiras mező értékét.
     * @param string $leiras
     */
    public function set_leiras($leiras)
    {
        $assign = new AssignString;
        $assign->assignAttribute('leiras', $leiras, $this);
    }
}