<?php
/**
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $beallitas_cim_tipus_id Cím típus azonosító.
 * @property int $cim_orszag_id Ország azonosító.
 * @property int $cim_megye_id Megye azonosító.
 * @property int $cim_varos_id Város azonosító.
 * @property int $cim_iranyitoszam_id Irányítószám azonosító.
 * @property string $utca Utca.
 * @property string $hazszam Házszám.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $ugyfel_attr_cim_aktiv Aktív-e a rekord.
 * @property int $ugyfel_attr_cim_torolt Törölt-e a rekord.
 */
abstract class ClientAddress extends \ArEditable implements \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_cim';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Konstruktor
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
        $this->modifyAttributes($attributes);
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    }
    /**
     * Attribútum értékek módosítása.
     * @param array $attributes
     */
    protected function modifyAttributes(array &$attributes)
    {
        $unset = array(
            'cim_orszag_id',
            'cim_megye_id',
            'cim_varos_id',
            'cim_iranyitoszam_id'
        );
        foreach ($unset as $attr) {
            if (isset($attributes[$attr]) && (int)$attributes[$attr] == 0) {
                unset($attributes[$attr]);
            }
        }
    }
    /**
     * Attribútumok értékeinek beállítása.
     * @param array $attributes
     */
    public function set_attributes(array $attributes)
    {
        $this->modifyAttributes($attributes);
        parent::set_attributes($attributes);
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null)
    {
        if (static::isNaturalNoZeroNumber($param)) {
            return static::find('first', array(
                'ugyfel_id' => $param,
                'beallitas_cim_tipus_id' => static::ADDRESS_TYPE_ID
            ));
        } else {
            $className = get_called_class();
            $class = new $className;
            $class->beallitas_cim_tipus_id = static::ADDRESS_TYPE_ID;
            return $class;
        }
    }
    
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('ugyfel_id');
        $this->ugyfel_id = $client->ugyfel_id;
        $this->beallitas_cim_tipus_id = static::ADDRESS_TYPE_ID;
        return $this;
    }
    
    public function save($validate = true)
    {
        $insertMethod = new \ReflectionMethod(get_called_class(), 'insert');
        $insertMethod->setAccessible(true);
        return $this->is_new_record() ? $insertMethod->invoke($this, $validate) : $this->updateAddress($validate);
    }
    
    protected function updateAddress($validate)
    {
        $this->assign_attribute('modosito_id', UserLoginOut_Admin_Controller::$_id);
        $this->assign_attribute('modositas_szama', $this->read_attribute('modositas_szama') + 1);
        $this->assign_attribute('modositas_timestamp', date('Y-m-d H:i:s'));
        if ($validate === true || $this->is_valid()) {
            static::update_all(array(
                'set' => $this->to_array(),
                'conditions' => array(
                    'ugyfel_id' => $this->ugyfel_id,
                    'beallitas_cim_tipus_id' => static::ADDRESS_TYPE_ID
                )
            ));
            return true;
        }
        return false;
    }
}