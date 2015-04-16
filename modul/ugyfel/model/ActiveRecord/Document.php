<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * Ügyfél dokumentum model.
 * 
 * @property int $ugyfel_attr_dokumentum_id Dokumentum azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property string $nev Dokumentum kódolt neve.
 * @property string $dokumentum_nev Dokumentum eredeti neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_dokumentum_aktiv Megjelenik-e a rekord.
 * @property int $ugyfel_attr_dokumentum_torolt Törölt-e a rekord.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class Document extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_dokumentum';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_dokumentum_id';
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
    
    public function before_create()
    {
        parent::before_create();
        $ext = pathinfo($this->dokumentum_nev, PATHINFO_EXTENSION);
        $this->dokumentum_nev = substr(str_replace($ext, '', $this->dokumentum_nev), 0, 230) . $ext;
        $this->nev = md5(str_shuffle(uniqid(time()) . $this->dokumentum_nev)) . '.' . $ext;
    }
    /**
     * Visszatér a dokumentum hash-elt nevével.
     * @return string
     */
    public function get_nev()
    {
        return $this->read_attribute('nev');
    }
    /**
     * Visszatér a dokumentum teljes nevével.
     * @return string
     */
    public function get_dokumentum_nev()
    {
        return $this->read_attribute('dokumentum_nev');
    }
    
    public function get_letrehozas_timestamp($format = 'Y-m-d H:i:s')
    {
        $readDateTime = new ReadDateTime($format);
        return $readDateTime->readAttribute('letrehozas_timestamp', $this);
    }
    /**
     * Beállítja a dokumentum hash-elt nevét.
     * @param string $nev Dokumentum hash-elt neve.
     */
    public function set_nev($nev)
    {
        $string = new AssignString;
        $string->assignAttribute('nev', $nev, $this);
    }
    /**
     * Beállítja a dokumentum nevét.
     * @param string $dokumentum_nev Dokumentum neve.
     */
    public function set_dokumentum_nev($dokumentum_nev)
    {
        $string = new AssignString;
        $string->assignAttribute('dokumentum_nev', $dokumentum_nev, $this);
    }
}