<?php
/**
 * sheepItForm ActiveRecord interface. A modelnek akkor kell implementálnia ezt az interface-t, ha az adatokat 
 * sheepItForm-on keresztül mentjük. Természetesen nem kötelező, csak célszerű, ugyanis így használhatjuk az 
 * <b>ArHelper</b> osztály short-hand metódusait.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
interface ISheepItAble
{
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue();
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery();
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete();
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm serializálható adatokkal.
     */
    public function sheepIt2Serializable();
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix();
    /**
     * Törölheti-e a rekord(okat) UPDATE előtt.
     * @return boolean
     */
    public function canDeleteBeforeUpdate();
}