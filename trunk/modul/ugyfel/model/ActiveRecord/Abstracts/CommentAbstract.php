<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;

class CommentAbstract extends BaseResourcable
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
    
    public function before_save()
    {
        parent::before_save();
        $assign = new WithoutCast;
        $assign->assignAttribute('ugyfel_tab_id', static::COMMENT_TYPE_ID, $this);
    }
}