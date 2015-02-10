<?php
/**
 * Felhasználó címek ActiveRecord Model.
 * 
 * @property int $user_cim_id Cím azonosító.
 * @property int $user_id Felhasználó azonosító.
 * @property int $cim_iranyitoszam_id Irányítószám azonosító.
 * @property string $user_cim_utca Utca neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Rekord létrehozásának ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Rekord módosításának ideje.
 * @property int $modositas_szama Rekord módosításainak száma.
 * @property int $user_cim_aktiv Aktív-e a rekord.
 * @property int $user_cim_torolt Törölve lett-e a rekord.
 * @property User $user Címhez tartozó felhasználó adatai.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class UserAddress extends ArBase
{
        
        protected $streetMin = 3;
        protected $streetMax = 128;
        static $table_name = 'user_cim';
        static $primary_key = 'user_cim_id';
        static $belongs_to = array(
                array(
                        'user',
                        'class_name' => 'User',
                        'foreign_key' => 'user_id',
                        'read_only' => true
                ),
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
        static $attr_protected = array(
                'letrehozo_id',
                'modosito_id',
                'letrehozas_timestamp',
                'modositas_timestamp',
                'modositas_szama'
        );
        static $validates_presence_of = array(
                array(
                        'user_id',
                        'message' => 'A címet felhasználóhoz kell rendelnie!'
                ),
                array(
                        'cim_iranyitoszam_id',
                        'message' => 'Kötelező mező!'
                ),
                array(
                        'user_cim_utca',
                        'message' => 'Kötelező mező!'
                )
        );
        static $validates_length_of;
        
        public function __construct(array $attributes=array(), $guard_attributes=true, $instantiating_via_find=false, $new_record=true)
        {
                parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
                self::$validates_length_of = array(
                        array(
                                'user_cim_utca',
                                'within' => array($this->getStreetMin(), $this->getStreetMax()),
                                'too_short' => 'Legalább '.$this->getStreetMin().' karakter hosszúnak kell lennie!',
                                'too_long' => 'Legfeljebb '.$this->getStreetMax().' karakter hosszú lehet!'
                        )
                );
        }
        /**
         * Modelhez tartozó behavior-ök.
         * @return array
         */
        public function arBehaviors()
        {
                return array(
                        'ArTimestampBehavior' => array(
                                'createdAttribute' => 'letrehozas_timestamp',
                                'modifiedAttribute' => 'modositas_timestamp'
                        ),
                        'ArAuthorBehavior' => array(
                                'creatorAttribute' => 'letrehozo_id',
                                'modificatoryAttribute' => 'modosito_id'
                        ),
                        'ArNomBehavior' => array(
                                'nomAttribute' => 'modositas_szama'
                        )
                );
        }
        /**
         * Visszatér a felhasználóhoz tartozó összes aktív, nem törölt címmel.
         * @param int $userId Felhasználó azonosító.
         * @return array
         * @throws InvalidArgumentException
         */
        public static function findAddressByUserId($userId)
        {
                if(self::validateAiId($userId))
                {
                        return self::find('all', array(
                                'conditions' => array(
                                        'user_id' => $userId,
                                        'user_cim_aktiv' => 1,
                                        'user_cim_torolt' => 0
                                )
                        ));
                }
        }
        /**
         * Visszatér az utca nevének minimális hosszával.
         * @return int
         */
        public function getStreetMin()
        {
                return $this->streetMin;
        }
        /**
         * Visszatér az utca nevének maximális hosszával.
         * @return int
         */
        public function getStreetMax()
        {
                return $this->streetMax;
        }
        /**
         * Visszatér a rekord aktív állapotával. (0-1)
         * @return int
         */
        public function get_user_cim_aktiv()
        {
                return ord($this->read_attribute('user_cim_aktiv'));
        }
        /**
         * Visszatér a rekord törölt állapotával. (0-1)
         * @return int
         */
        public function get_user_cim_torolt()
        {
                return ord($this->read_attribute('user_cim_torolt'));
        }
        
}