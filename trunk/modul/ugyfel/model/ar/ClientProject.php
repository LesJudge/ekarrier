<?php
/**
 * @property int $projekt_id Projekt azonosító.
 * @property int $user_id Felhasználó azonosító.
 * @property string $megjegyzes Megjegyzés.
 * @property \Client $client Ügyfél objektum.
 * @property \Project $project Projekt objektum.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ClientProject extends \ArBase implements \ISheepItAble, \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_projekt';
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
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'user_id',
            'read_only' => true
        ),
        array(
            'project',
            'conditions' => 'projekt_aktiv = 1 AND projekt_torolt = 0',
            'class_name' => 'Project',
            'foreign_key' => 'projekt_id',
            'read_only' => true
        )
    );
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \self
     */
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('project_id');
        $this->flag_dirty('ugyfel_id');
        $this->ugyfel_id = $client->ugyfel_id;
    }
    /**
     * Törölheti-e a rekord(okat) UPDATE előtt.
     * @return boolean
     */
    public function canDeleteBeforeUpdate()
    {
        return false;
    }
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm serializálható adatokkal.
     */
    public function sheepIt2Serializable()
    {
        return array(
            'projekt_id' => $this->projekt_id,
            'ugyfel_id' => $this->ugyfel_id,
            'megjegyzes' => $this->megjegyzes
        );
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $query = 'DELETE FROM ' . static::$table_name . ' WHERE ugyfel_id = ?';
        static::query($query, array($this->ugyfel_id));
    }
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'clientProejctForm_#index#';
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::$table_name . ' (projekt_id, ugyfel_id, megjegyzes) VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE megjegyzes = ?';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        return array($this->projekt_id, $this->ugyfel_id, $this->megjegyzes, $this->megjegyzes);
    }
}