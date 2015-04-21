<?php
namespace Uniweb\Module\Nyelvtudas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ModuleBaseModel;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
/**
 * Nyelvtudás szint ActiveRecord model.
 * 
 * @property int $nyelvtudas_szint_id Nyelvtudás szint azonosító.
 * @property int $nev Nyelvtudás szint neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $nyelvtudas_szint_aktiv Megjelenik-e listázáskor a rekord.
 * @property int $nyelvtudas_szint_torolt Törölt-e a rekord.
 */
class Level extends ModuleBaseModel
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'nyelvtudas_szint';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'nyelvtudas_szint_id';
    
    public function behaviors()
    {
        /* @var $behaviors \Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior[] */
        $behaviors = parent::behaviors();
        $behaviors['status'] = new \Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus(
            'nyelvtudas_szint_aktiv',
            'nyelvtudas_szint_torolt',
            1,
            0
        );
        return $behaviors;
    }
    /**
     * Visszatér a rekord aktív értékével.
     * @return int
     */
    public function get_nyelvtudas_szint_aktiv()
    {
        return $this->get_aktiv();
    }
    /**
     * Visszatér a rekord törölt értékvel.
     * @return int
     */
    public function get_nyelvtudas_szint_torolt()
    {
        return $this->get_torolt();
    }
    
    public function get_nyelvtudas_szint_id()
    {
        return $this->read_attribute('nyelvtudas_szint_id');
    }
    
    public function set_nyelvtudas_szint_id($nyelvtudas_szint_id)
    {
	$assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute('nyelvtudas_szint_id', $nyelvtudas_szint_id, $this);
    }
}