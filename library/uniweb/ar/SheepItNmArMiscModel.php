<?php

abstract class SheepItNmArMiscModel extends \SheepItNmArModel
{
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm serializálható adatokkal.
     */
    public function sheepIt2Serializable()
    {
        $fieldId = $this->fieldId();
        return array($fieldId => $this->{$fieldId}, 'egyeb' => $this->egyeb);
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $sql = 'DELETE FROM ' . static::table_name() . ' WHERE ugyfel_id = ?';
        self::query($sql, array($this->ugyfel_id));
    }
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return null;
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::table_name() . ' (ugyfel_id, ' . $this->fieldId() . ', egyeb) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE egyeb = ?';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        return array($this->ugyfel_id, $this->{$this->fieldId()}, $this->egyeb, $this->egyeb);
    }
}