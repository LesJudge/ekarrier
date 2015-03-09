<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
/**
 * @property int $ugyfel_attr_munkarend_id Azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $munkarend_id Munkarend azonosító.
 * @property null|string $egyeb Megjegyzés.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property null|\ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_munkarend_aktiv Megjelenik-e listázáskor.
 * @property int $ugyfel_attr_munkarend_torolt Törölt-e a rekord.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Munkarend\Model\ActiveRecord\WorkSchedule $workschedule Munkarend model.
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél model.
 */
class WorkSchedule extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_munkarend';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_munkarend_id';
    /**
     * Modelhez tartozó kapcsolatok 1:1.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'workschedule',
            'class_name' => '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\WorkSchedule',
            'foreign_key' => 'munkarend_id'
        ),
        array(
            'client',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client',
            'foreign_key' => 'ugyfel_id'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'munkarend_id',
            'message' => 'A munkarend megadása kötelező!'
        )
    );
    /**
     * Visszatér a rekord azonosítójával.
     * @return int
     */
    public function get_ugyfel_attr_munkarend_id()
    {
        return $this->read_attribute('ugyfel_attr_munkarend_id');
    }
    /**
     * Visszatér a munkarend azonosítójával.
     * @return int
     */
    public function get_munkarend_id()
    {
        return $this->read_attribute('munkarend_id');
    }
    /**
     * Visszatér az egyéb értékkel.
     * @return null|string
     */
    public function get_egyeb()
    {
        return $this->read_attribute('egyeb');
    }
    /**
     * Beállítja a rekord azonosítóját.
     * @param int $ugyfel_attr_munkarend_id Rekord azonosító.
     */
    public function set_ugyfel_attr_munkarend_id($ugyfel_attr_munkarend_id)
    {
        (new AssignWithoutCast)->assignAttribute('ugyfel_attr_munkarend_id', $ugyfel_attr_munkarend_id, $this);
    }
    /**
     * Beállítja a munkarend azonosítóját.
     * @param int $munkarend_id Munkarend azonosító.
     */
    public function set_munkarend_id($munkarend_id)
    {
        (new AssignWithoutCast)->assignAttribute('munkarend_id', $munkarend_id, $this);
    }
    /**
     * Beállítja az egyéb értéket.
     * @param null|string $egyeb Egyéb.
     */
    public function set_egyeb($egyeb)
    {
        (new AssignString)->assignAttribute('egyeb', $egyeb, $this);
    }
}