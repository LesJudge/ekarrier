<?php
/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $beallitas_ugyfelkezelo_tab_id Tab Id.
 * @property string $megjegyzes Megjegyzés.
 * @property int $letrehozo_id Létrehozó azonosító.
 * @property int $modosito_id Módosító azonosító.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_tab_megjegyzes_aktiv Aktív-e a rekord.
 * @property int $ugyfel_attr_tab_megjegyzes_torolt Törölt-e a rekord.
 */
abstract class ClientComment extends ArEditable implements \IClientSave
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
    public static $primary_key = 'ugyfel_id';
    
    public static $validates_length_of = array(
        array(
            'megjegyzes',
            'allow_blank' => true,
            'minimum' => 10,
            'too_short' => 'A megjegyzés túl rövid!'
        )
    );
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null)
    {
        if (static::isNaturalNoZeroNumber($param)) {
            return static::find('first', array(
                'ugyfel_id' => $param,
                'beallitas_ugyfelkezelo_tab_id' => static::COMMENT_TYPE_ID
            ));
        } else {
            $className = get_called_class();
            $class = new $className;
            $class->beallitas_ugyfelkezelo_tab_id = static::COMMENT_TYPE_ID;
            return $class;
        }
    }
    
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('ugyfel_id');
        $this->ugyfel_id = $client->ugyfel_id;
        $this->beallitas_ugyfelkezelo_tab_id = static::COMMENT_TYPE_ID;
        return $this;
    }
    /**
     * Mentés metódus.
     * @param boolean $validate Validáljon-e.
     * @return boolean
     */
    public function save($validate = true)
    {
        $insertMethod = new ReflectionMethod(get_called_class(), 'insert');
        $insertMethod->setAccessible(true);
        return $this->is_new_record() ? $insertMethod->invoke($this, $validate) : $this->updateComment($validate);
    }
    /**
     * UPDATE-eli a megjegyzést.
     * @param boolean $validate Validáljon-e.
     * @return boolean
     */
    protected function updateComment($validate)
    {
        $this->assign_attribute('modosito_id', UserLoginOut_Admin_Controller::$_id);
        $this->assign_attribute('modositas_szama', $this->read_attribute('modositas_szama') + 1);
        $this->assign_attribute('modositas_timestamp', date('Y-m-d H:i:s'));
        if ($validate === true || $this->is_valid()) {
            static::update_all(array(
                'set' => $this->to_array(),
                'conditions' => array(
                    'ugyfel_id' => $this->ugyfel_id,
                    'beallitas_ugyfelkezelo_tab_id' => static::COMMENT_TYPE_ID
                )
            ));
            return true;
        }
        return false;
    }
    /**
     * 
     * @return string
     * @todo Normális escape-elés!
     */
    public function get_megjegyzes()
    {
        return trim($this->read_attribute('megjegyzes'));
    }
}