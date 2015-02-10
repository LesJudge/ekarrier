<?php

class ClientBirthData extends \ArBase implements \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_szuletesi_adatok';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key  = 'ugyfel_id';
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
            'szuletesi_hely_orszag_id',
            'szuletesi_hely_varos_id',
            'szuletesi_ido'
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
            return static::find($param);
        } else {
            $class = get_called_class();
            return new $class;
        }
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \self
     */
    public function setUpClientSave(\Client $client)
    {
        $this->ugyfel_id = $client->ugyfel_id;
        return $this;
    }
    
    public function attributeLabels()
    {
        return array(
            'szuletesi_vezeteknev' => 'Születési vezetéknév',
            'szuletesi_keresztnev' => 'Születési keresztnév',
            'szuletesi_hely_orszag_id' => 'Ország',
            'szuletesi_hely_varos_id' => 'Város',
            'szuletesi_ido' => 'Születési idő'
        );
    }
    
    public function get_szuletesi_ido()
    {
        return $this->readDateTimeAttribute('szuletesi_ido');
    }
}