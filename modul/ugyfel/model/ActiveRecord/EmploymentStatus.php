<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique;
/**
 * @property int $ugyfel_munkaba_allas_allapot_id Azonosító.
 * @property string $nev Név.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Rekord létrehozásának ideje.
 * @property null|boolean|\ActiveRecord\DateTime $modositas_timestamp Rekord módosításának ideje.
 * @property int $modositas_szama Rekord módosításának a száma.
 * @property int $ugyfel_munkaba_allas_allapot_aktiv Megjelenik-e a rekord.
 * @property int $ugyfel_munkaba_allas_allapot_torolt Törölt-e a rekord.
 */
class EmploymentStatus extends Behaviorable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_munkaba_allas_allapot';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_munkaba_allas_allapot_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_munkaba_allas_allapot_id'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'nev',
            'message' => 'Kötelező mező!'
        ),
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'nev',
            'within' => array(3, 128),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 128 karakter hosszú lehet!'
        )
    );
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        )
    );
    /**
     * Visszatér a névvel.
     * @return string
     */
    public function get_nev()
    {
        return $this->read_attribute('nev');
    }
    /**
     * Beállítja a nevet.
     * @param string $nev
     */
    public function set_nev($nev)
    {
        $assign = new AssignString;
        $assign->assignAttribute('nev', $nev, $this);
    }
    
    public function behaviors()
    {
        return array(
            'author' => new Author('letrehozo_id', 'modosito_id'),
            'nom' => new NumberOfModifications('modositas_szama'),
            'status' => new RecordStatus(static::$table_name . '_aktiv', static::$table_name . '_torolt'),
            'timestamp' => new Timestamp('letrehozas_timestamp', 'modositas_timestamp')
        );
    }
    
    public function validate()
    {
        parent::validate();
        $isUnique = new IsUnique($this, 'nev');
        if (!$isUnique->validate($this->read_attribute('nev'))) {
            $this->errors->add('nev', 'Ez a név már használatban van!');
        }
    }
}