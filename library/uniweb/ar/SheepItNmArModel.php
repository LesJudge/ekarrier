<?php
/**
 * sheepIt N:M kapcsolat.
 */
abstract class SheepItNmArModel extends \ArBase implements ISheepItAble, IClientSave
{
    /**
     * Visszatér az id mező nevével.
     * @return string
     */
    abstract protected function fieldId();
    /**
     * Visszatér a név mező nevével.
     * @return string
     */
    abstract protected function fieldName();
    /**
     * Visszatér a kapcsolat objektummal.
     * @return \ActiveRecord\Model
     */
    abstract protected function relationObject();
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        $t = self::table_name();
        return 'INSERT INTO ' . $t . ' (ugyfel_id, ' . $this->fieldId() . ') VALUES (?, ?) 
               ON DUPLICATE KEY UPDATE ' . $this->fieldId() . ' = ?';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        return array($this->ugyfel_id, $this->{$this->fieldId()}, $this->{$this->fieldId()});
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $query = 'DELETE FROM ' . self::table_name() . ' WHERE ugyfel_id = ?';
        self::query($query, array($this->ugyfel_id));
    }
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm adatai JSON formátumban.
     */
    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $relation = $this->relationObject();
        if (is_object($relation)) {
            $jsonData = array(
                $prefix . '_' . $this->fieldName() => $relation->{$this->fieldName()},
                $prefix . '_' . $this->fieldId() => $relation->{$this->fieldId()},
                $prefix . '_' . $this->fieldName() . '_error' => null,
                $prefix . '_' . $this->fieldId() . '_error' => null
            );
        } else {
            $jsonData = array(
                $prefix . '_' . $this->fieldName() => null,
                $prefix . '_' . $this->fieldId() => null,
                $prefix . '_' . $this->fieldName() . '_error' => 'A mező megadása kötelező!',
                $prefix . '_' . $this->fieldId() . '_error' => null
            );
        }
        return $jsonData;
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     * @return \self
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
        $this->ugyfel_id = $client->ugyfel_id;
        return $this;
    }
    /**
     * Törölheti-e a rekord(okat) UPDATE előtt.
     * @return boolean
     */
    public function canDeleteBeforeUpdate()
    {
        return true;
    }
}