<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
/**
 * Ügyfél nyelvtudás ActiveRecord Model.
 * 
 * @property int $ugyfel_attr_nyelvtudas_id Nyelvtudás azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $nyelvtudas_nyelv_id Nyelvtudás nyelv azonosítója.
 * @property int $nyelvtudas_szint_id Nyelvtudás szint azonosítója.
 * @property int $letrehozo_id Létrehozó azonosító.
 * @property int $modosito_id Módosító azonosító.
 * @property null|ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_nyelvtudas_aktiv Megjelenik-e a rekord.
 * @property int $ugyfel_attr_nyelvtudas_torolt Törölt-e a rekord.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél kapcsolat.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó kapcsolat.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó kapcsolat.
 * @property \Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Language $language Nyelv kapcsolat.
 * @property \Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Level $level Szint kapcsolat.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Knowledge extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_nyelvtudas';
    /**
     * Tábla elsődleges kulcsai.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_nyelvtudas_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array('ugyfel_attr_nyelvtudas_id');
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'nyelvtudas_nyelv_id',
            'message' => 'A nyelv megadása kötelező!'
        ),
        array(
            'nyelvtudas_szint_id',
            'message' => 'A szint megadása kötelező!'
        ),
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
        ),
        // Nyelv kapcsolat.
        array(
            'language',
            'class_name' => '\\Uniweb\\Module\\Nyelvtudas\\Model\\ActiveRecord\\Language',
            'foreign_key' => 'nyelvtudas_nyelv_id',
            'read_only' => true
        ),
        // Szint kapcsolat.
        array(
            'level',
            'class_name' => '\\Uniweb\\Module\\Nyelvtudas\\Model\\ActiveRecord\\Level',
            'foreign_key' => 'nyelvtudas_szint_id',
            'read_only' => true
        )
    );
    
    public function get_ugyfel_attr_nyelvtudas_id()
    {
        return $this->read_attribute('ugyfel_attr_nyelvtudas_id');
    }
    /**
     * Visszatér a nyelv azonosítójával.
     * @return int
     */
    public function get_nyelvtudas_nyelv_id()
    {
        return $this->read_attribute('nyelvtudas_nyelv_id');
    }
    /**
     * Visszatér a szint azonosítójával.
     * @return int
     */
    public function get_nyelvtudas_szint_id()
    {
        return $this->read_attribute('nyelvtudas_szint_id');
    }
    
    public function set_ugyfel_attr_nyelvtudas_id($ugyfel_attr_nyelvtudas_id)
    {
        (new AssignWithoutCast)->assignAttribute('ugyfel_attr_nyelvtudas_id', $ugyfel_attr_nyelvtudas_id, $this);
    }
    /**
     * Beállítja a nyelv azonosítót.
     * @param int $nyelvtudas_nyelv_id Nyelv azonosító.
     */
    public function set_nyelvtudas_nyelv_id($nyelvtudas_nyelv_id)
    {
        (new AssignWithoutCast)->assignAttribute('nyelvtudas_nyelv_id', $nyelvtudas_nyelv_id, $this);
    }
    /**
     * Beállítja a szint azonosítót.
     * @param null|int $nyelvtudas_szint_id Szint azonosító.
     */
    public function set_nyelvtudas_szint_id($nyelvtudas_szint_id)
    {
        (new AssignWithoutCast)->assignAttribute('nyelvtudas_szint_id', $nyelvtudas_szint_id, $this);
    }
}