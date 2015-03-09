<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts;
use Uniweb\Library\Utilities\ActiveRecord\Model\TypeDependent;
use Uniweb\Library\Utilities\ActiveRecord\AttributeModifier\TypeDependent as ConditionsModifier;
use Uniweb\Library\Resource\Interfaces\ResourcableInterface;
use Uniweb\Library\Validator\NaturalNumber;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $ugyfel_tab_id Tab Id.
 * @property string $megjegyzes Megjegyzés.
 * @property int $letrehozo_id Létrehozó azonosító.
 * @property int $modosito_id Módosító azonosító.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_tab_megjegyzes_aktiv Aktív-e a rekord.
 * @property int $ugyfel_attr_tab_megjegyzes_torolt Törölt-e a rekord.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
abstract class CommentAbstract extends TypeDependent implements ResourcableInterface
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_tab_megjegyzes';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_tab_megjegyzes_id';
    /**
     * "Védett" attribútumok.
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_tab_id'
    );
    /**
     * Attribútum, ami meghatározza a típust.
     * @var string
     */
    protected static $attribute = 'ugyfel_tab_id';
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
    
    public static $validates_length_of = array(
        array(
            'megjegyzes',
            'allow_blank' => true,
            'minimum' => 5,
            'too_short' => 'A megjegyzés túl rövid! Legalább 5 karakter hosszúnak kell lennie!'
        )
    );
    
    public function get_ugyfel_attr_tab_megjegyzes_id()
    {
        return $this->read_attribute('ugyfel_attr_tab_megjegyzes_id');
    }
    
    public function get_ugyfel_id()
    {
        return $this->read_attribute('ugyfel_id');
    }
    
    public function get_ugyfel_tab_id()
    {
        return $this->read_attribute('ugyfel_tab_id');
    }
    
    public function get_megjegyzes()
    {
        return $this->read_attribute('megjegyzes');
    }
    
    public function set_ugyfel_attr_tab_megjegyzes_id($ugyfel_attr_tab_megjegyzes_id)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute('ugyfel_attr_tab_megjegyzes_id', $ugyfel_attr_tab_megjegyzes_id, $this);
    }
    
    public function set_ugyfel_id($ugyfel_id)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute('ugyfel_id', $ugyfel_id, $this);
    }
    
    public function set_ugyfel_tab_id($ugyfel_tab_id)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute('ugyfel_tab_id', $ugyfel_tab_id, $this);
    }
    
    public function set_megjegyzes($megjegyzes)
    {
        $assign = new WithoutCast;
        $assign->assignAttribute('megjegyzes', $megjegyzes, $this);
    }
    
    public static function instantiateModifier()
    {
        $modifier = new ConditionsModifier;
        $modifier->setTypeAttribute(static::getAttribute());
        $modifier->setTypeId(static::typeId());
        return $modifier;
    }
    
    public static final function typeId()
    {
        return static::COMMENT_TYPE_ID;
    }
    
    public static function getResourceKey()
    {
        return 'ugyfel_id';
    }
    
    public function before_save()
    {
        parent::before_save();
        if ($this->is_new_record()) {
            $this->assign_attribute('letrehozo_id', \UserLoginOut_Controller::$_id);
            $this->assign_attribute('modosito_id', \UserLoginOut_Controller::$_id);            
        } else {
            $this->assign_attribute('modosito_id', \UserLoginOut_Controller::$_id);
        }
    }
}