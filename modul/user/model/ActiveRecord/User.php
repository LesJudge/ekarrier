<?php
namespace Uniweb\Module\User\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * Felhasználó ActiveRecord model.
 * 
 * @property int $user_id Felhasználó azonosító.
 * @property int $nyelv_id Nyelv azonosító. (Csak minek... :))
 * @property string $user_fnev Felhasználónév.
 * @property string $user_jelszo Jelszó.
 * @property string $user_email E-mail cím.
 * @property string $user_vnev Felhasználó vezetékneve.
 * @property string $user_knev Felhasználó keresztneve.
 * @property string $user_kep_nev Felhasználó avatar képe.
 * @property int $user_hirlevel Feliratkozott-e a hírlevélre.
 * @property ActiveRecord\DateTime $user_reg_date Regisztráció ideje.
 * @property int $user_megerositve Meg lett-e erősítve a profil.
 * @property ActiveRecord\DateTime $user_megerositve_date Megerősítés ideje.
 * @property ActiveRecord\DateTime $user_last_login Utolsó bejelentkezés ideje.
 * @property int $user_szum_login Bejelentkezések száma.
 * @property int $user_aktiv Aktív-e a felhasználó.
 * @property int $user_torolt Törölt-e a felhasználó.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class User extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'user';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'user_id';
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array();
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    static $validates_length_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    static $validates_inclusion_of = array();
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    static $attr_protected = array(
        'user_id',
        'user_reg_date',
        'user_megerositve',
        'user_megerositve_date',
        'user_last_login',
        'user_szum_login'
    );
    /**
     * Konstruktor felüldeklarálása.
     * @param array $attributes
     * @param boolean $guard_attributes
     * @param boolean $instantiating_via_find
     * @param boolean $new_record
     */
    public function __construct(
        array $attributes = array(),
        $guard_attributes = true,
        $instantiating_via_find = false,
        $new_record = true
    ) {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        // További védett attribútumok létező rekord esetén.
        /*
        if (!$new_record) {
            $username = $this->read_attribute('user_fnev');
            if (!empty($username)) {
                // Ha már korábben ki lett töltve a felhasználónév, akkor protected-dé teszi, ezáltalán nem lesz 
                // felülírható.
                self::$attr_protected[] = 'user_fnev';
            }
            // Az e-mail cím minden esetben protected, nem felülírható.
            //self::$attr_protected[] = 'user_email';
        }
        */
        self::$validates_presence_of = array(
            //array(
            //    'nyelv_id',
            //    'message' => 'Kötelező mező!'
            //),
            array(
                'user_vnev',
                'message' => 'Kötelező mező!'
            ),
            array(
                'user_knev',
                'message' => 'Kötelező mező!'
            ),
            //array(
            //    'user_aktiv',
            //    'message' => 'Kötelező mező!'
            //)
        );
        $usernameLength = $this->getUsenameLength();
        $passLength = $this->getPasswordLength();
        $emailLength = $this->getEmailLength();
        $nameLength = $this->getNameLength();
        self::$validates_length_of = array(
            array(
                'user_fnev',
                'allow_blank' => true,
                'within' => $usernameLength,
                'too_short' => 'A felhasználónévnek legalább ' . $usernameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A felhasználónév legfeljebb ' . $usernameLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'user_jelszo',
                'allow_blank' => true,
                'minimum' => $passLength[0],
                'too_short' => 'A jelszónak legalább ' . $passLength[0] . ' karakter hosszúnak kell lennie!'
            ),
            array(
                'user_email',
                'within' => $emailLength,
                'too_short' => 'Az e-mail cím legalább ' . $emailLength[0] . ' karakter hosszú legyen!',
                'too_long' => 'Az e-mail cím legfeljebb ' . $emailLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'user_vnev',
                'within' => $nameLength,
                'too_short' => 'A vezetéknévnek legalább ' . $nameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A vezetéknév legfeljebb ' . $nameLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'user_knev',
                'within' => $nameLength,
                'too_short' => 'A keresztnévnek legalább ' . $nameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A keresztnév legfeljebb ' . $nameLength[1] . ' karakter hosszú lehet!'
            )
        );
        self::$validates_inclusion_of = array(
            array(
                'user_hirlevel',
                'in' => array(0, 1),
                'message' => 'A hírlevél értéke csak igen-nem lehet!'
            ),
            array(
                'user_aktiv',
                'in' => array(0, 1),
                'message' => 'Az aktív értéke csak igen-nem lehet!'
            )
        );
    }
    /**
     * Egyedi validáció.
     */
    public function validate()
    {
        $username = $this->read_attribute('user_fnev');
        $email = $this->read_attribute('user_email');
        if ($this->emailExists($email)) {
            $this->errors->add('user_email', 'A megadott e-mail cím (' . $email . ') már használatban van!');
        }
        if (!empty($username) && $this->usernameExists($username)) {
            $this->errors->add('user_fnev', 'A megadott felhasználónév (' . $username . ') már használatban van!');
        }
        $password = $this->read_attribute('user_jelszo');
        if ($this->is_new_record()) {
            if (!empty($username) && empty($password)) {
                $this->errors->add('user_jelszo', 'A jelszó megadása kötelező!');
            }
        } else {
            if (!empty($password) && empty($username)) {
                $this->errors->add('user_fnev', 'Jelszót csak felhasználónévvel együtt tud megadni!');
            }
        }
    }
    
    public function attributeLabels()
    {
        return array(
            'user_id' => 'Felhasználó azonosító',
            'nyelv_id' => 'Nyelv azonosító',
            'user_fnev' => 'Felhasználónév',
            'user_jelszo' => 'Jelszó',
            'user_email' => 'E-mail cím',
            'user_vnev' => 'Vezetéknév',
            'user_knev' => 'Keresztnév',
            'user_kep_nev' => 'Profilkép',
            'user_hirlevel' => 'Hírlevélre feliratkozott',
            'user_reg_date' => 'Regisztráció ideje',
            'user_megerositve' => 'Megerősítve',
            'user_megerositve_date' => 'Megerősítés ideje',
            'user_last_login' => 'Utolsó bejelentkezés ideje',
            'user_szum_login' => 'Bejelentkezések száma',
            'user_aktiv' => 'Aktív',
            'user_torolt' => 'Törölt'
        );
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott mező értéke egyedi-e.
     * @param string $field Mező neve.
     * @param mixed $value Érték.
     * @return boolean
     */
    protected function isUnique($field, $value)
    {
        if ($this->is_new_record()) {
            $conditions = array($field . ' = ?', $value);
        } else {
            $conditions = array($field . ' = ? AND user_id != ?', $value, $this->user_id);
        }
        return $this->exists(array('conditions' => $conditions));
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott felhasználónév létezik-e az adatbázisban.
     * @param string $username Felhasználónév.
     * @return boolean
     */
    protected function usernameExists($username)
    {
        return $this->isUnique('user_fnev', $username);
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott e-mail cím létezik-e az adatbázisban.
     * @param string $email E-mail cím.
     * @return boolean
     */
    protected function emailExists($email)
    {
        return $this->isUnique('user_email', $email);
    }
    /**
     * Beállítja a felhasználó jelszavát, ha az nem üres string.
     * @param string $password
     */
    public function set_user_jelszo($password)
    {
        if (!empty($password)) {
            $this->assign_attribute('user_jelszo', Create::passwordGenerator($password, Rimo::$_config->SALT));
        }
    }
    /**
     * Visszatér a felhasználó teljes nevével.
     * @return string
     */
    public function getFullname()
    {
        return $this->user_vnev . ' ' . $this->user_knev;
    }
    /**
     * Visszatér a felhasználónév minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getUsenameLength()
    {
        return array(6, 50);
    }
    /**
     * Visszatér a jelszó minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getPasswordLength()
    {
        return array(2, null);
    }
    /**
     * Visszatér az e-mail cím minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getEmailLength()
    {
        return array(8, 255);
    }
    /**
     * Visszatér a név minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public function getNameLength()
    {
        return array(3, 64);
    }
}