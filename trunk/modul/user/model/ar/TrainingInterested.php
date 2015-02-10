<?php
/**
 * Ügyfél által érdekelt képzések model. Elsődleges kulcsként a felhasználó azonosító van megadva, de ez
 * ebben a formában így helytelen, ugyanis egy kapcsolótáblát modelez, aminek két elsődleges kulcsa van.
 * 
 * @property int $user_id Felhasználó azonosító.
 * @property int $kepzes_id Képzés azonosító.
 * @property Training $training Képzés model.
 * @property Client $client Ügyfél model.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 * 
 * @todo DELETE MODEL
 */
class TrainingInterested extends \SaTSheepItNmArModel
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'user_attr_kepzes_erdekelt';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'user_id';
    /**
     * Modelhez tartozó kapcsolatok 1:1.
     * @var array
     */
    static $belongs_to = array(
        array(
            'training',
            'class_name' => 'Training',
            'foreign_key' => 'kepzes_id'
        ),
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'user_id'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array(
        array(
            'kepzes_id',
            'message' => 'A képzés megadása kötelező!'
        )
    );
    /**
     * Számokra vonatkozó validációs szabályok.
     * @var array
     */
    static $validates_numericality_of = array(
        array(
            'kepzes_id',
            'greater_than' => 0,
            'message' => 'Nem megfelelő képzés azonosító!'
        )
    );
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'trainingsForm_#index#';
    }
    /**
     * Visszatér az id mező nevével.
     * @return string
     */
    protected function fieldId()
    {
        return 'kepzes_id';
    }
    /**
     * Visszatér a név mező nevével.
     * @return string
     */
    protected function fieldName()
    {
        return 'kepzes_nev';
    }
    /**
     * Visszatér a kapcsolat objektummal.
     * @return \ActiveRecord\Model
     */
    protected function relationObject()
    {
        return $this->training;
    }
}
