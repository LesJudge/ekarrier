<?php
/**
 * Projekt AR model.
 * 
 * @property int $projekt_id Projekt azonosító.
 * @property string $nev Projekt neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Projekt létrehozásának ideje.
 * @property mixed $modositas_timestamp Projekt módosításának ideje.
 * @property int $modositas_szama Projekt módosításainak száma.
 * @property int $projekt_aktiv Aktív-e a projekt.
 * @property int $projekt_torolt Törölt-e a projekt.
 * @property \User $creator Létrehozó felhasználó adatai.
 * @property \User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Project extends \ArEditable
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
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'projekt_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'creator',
            'class_name' => 'User',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true
        ),
        array(
            'modificatory',
            'class_name' => 'User',
            'foreign_key' => 'modosito_id',
            'read_only' => true
        )
    );
    /**
     * Inicializálás végén lefutó metódus.
     */
    public function after_construct()
    {
        self::$validates_presence_of = array(
            array(
                'nev',
                'message' => 'A projekt nevének megadása kötelező!'
            )
        );
    }
    
    public function validate()
    {
        if ($this->is_new_record()) {
            $conditions = array('nev = ?', $this->nev);
        } else {
            $conditions = array('nev = ? AND ' . self::$primary_key . ' != ?', $this->nev, $this->projekt_id);
        }
        if ($this->exists(array('conditions' => $conditions))) {
            $this->errors->add('nev', 'Ez a projekt név már foglalt! Kérem, válasszon másikat!');
        }
    }
}