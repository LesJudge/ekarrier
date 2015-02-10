<?php
/**
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $munkarend_id Munkarend azonosító.
 * @property \WorkSchedule $workschedule Munkarend model.
 * @property \Client $client Ügyfél model.
 */
class ClientWorkSchedules extends \SheepItNmArMiscModel
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
    public static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó kapcsolatok 1:1.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'workschedule',
            'class_name' => 'WorkSchedule',
            'foreign_key' => 'munkarend_id'
        ),
        array(
            'client',
            'class_name' => 'Client',
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
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return null;
    }
    /**
     * Visszatér az id mező nevével.
     * @return string
     */
    protected function fieldId()
    {
        return 'munkarend_id';
    }
    /**
     * Visszatér a név mező nevével.
     * @return string
     */
    protected function fieldName()
    {
        return 'munkarend_nev';
    }
    /**
     * Visszatér a kapcsolat objektummal.
     * @return \ActiveRecord\Model
     */
    protected function relationObject()
    {
        return $this->workschedule;
    }
}