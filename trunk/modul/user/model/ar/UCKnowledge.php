<?php
/**
 * @property int $user_szismeret_id Azonosító.
 * @property int $user_id Felhasználó azonosító.
 * @property string $ismeret Számítógépes ismeret.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property User $user Felhasználó adatai.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 */
class UCKnowledge extends ArBase
{
        
        protected $knowledgeMin = 3;
        protected $knowledgeMax = 128;
        static $table_name = 'user_szismeret';
        static $primary_key = 'user_szismeret_id';
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
                        'message' => 'Az ismeretet felhasználóhoz kell rendelnie!'
                ),
                array(
                        'ismeret',
                        'message' => 'Kötelező mező!'
                ),
        );
        static $validates_length_of;
        
        public function __construct(array $attributes=array(), $guard_attributes=true, $instantiating_via_find=false, $new_record=true)
        {
                parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
                self::$validates_length_of = array(
                        array(
                                'ismeret',
                                'within' => array($this->getKnowledgeMin(), $this->getKnowledgeMax()),
                                'too_short' => 'Legalább '.$this->getKnowledgeMin().' karakter hosszúnak kell lennie!',
                                'too_long' => 'Legfeljebb '.$this->getKnowledgeMax().' karakter hosszú lehet!'
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
         * Lekérdezi a felhasználóhoz tartoz összes számítógép ismeret rekordot.
         * @param int $userId
         * @return array
         * @throws InvalidArgumentException
         */
        public static function findKnowledgesByUserId($userId)
        {
                if(self::validateAiId($userId))
                {
                        return self::find('all', array(
                                'conditions' => array(
                                        'user_id' => $userId
                                )
                        ));
                }
        }
        /**
         * Visszatér az ismeret minimális hosszával.
         * @return int
         */
        public function getKnowledgeMin()
        {
                return $this->knowledgeMin;
        }
        /**
         * Visszatér az ismeret maximális hosszával.
         * @return int
         */
        public function getKnowledgeMax()
        {
                return $this->knowledgeMax;
        }
        
}