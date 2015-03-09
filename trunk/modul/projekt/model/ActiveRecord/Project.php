<?php
namespace Uniweb\Module\Projekt\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ModuleBaseModel;
/**
 * Projekt AR model.
 * 
 * @property int $projekt_id Projekt azonosító.
 * @property string $nev Projekt neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Projekt módosításainak száma.
 * @property int $projekt_aktiv Megjelenik-e listázáskor a rekord.
 * @property int $projekt_torolt Törölt-e a rekord.
 */
class Project extends ModuleBaseModel
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'projekt';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'projekt_id';
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['status'] = new \Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus(
            'projekt_aktiv',
            'projekt_torolt'
        );
        return $behaviors;
    }
}