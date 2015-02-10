<?php
/**
 * Ügyfél által érdekelt szolgáltatások model. Elsődleges kulcsként a felhasználó azonosító van megadva, de ez
 * ebben a formában így helytelen, ugyanis egy kapcsolótáblát modelez, aminek két elsődleges kulcsa van.
 * 
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $szolgaltatas_id Szolgáltatás azonosító.
 * @property int $reszt_akar_venni Részt akar-e venni a szolgáltatáson.
 * @property int $reszt_vett Részt vett-e a szolgáltatáson.
 * @property mixed $mikor Mikor vett részt a szolgáltatáson.
 * @property mixed $mettol Mikortól vett részt a szolgátatáson.
 * @property mixed $meddig Meddig vett részt a szolgáltatáson.
 * @property Service $service Szolgáltatás model.
 * @property Client $client Ügyfél model.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ServiceInterested extends \ArBase implements ISheepItAble, IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'ugyfel_attr_szolgaltatas_erdekelt';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó kapcsolatok 1:1.
     * @var array
     */
    static $belongs_to = array(
        array(
            'service',
            'class_name' => 'Service',
            'foreign_key' => 'szolgaltatas_id'
        ),
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'ugyfel_id'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array(
        array(
            'szolgaltatas_id',
            'message' => 'A szolgáltatás megadása kötelező!'
        )
    );
    /**
     * Számokra vonatkozó validációs szabályok.
     * @var array
     */
    static $validates_numericality_of = array(
        array(
            'szolgaltatas_id',
            'greater_than' => 0,
            'message' => 'Nem megfelelő szolgáltatás azonosító!'
        )
    );
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'servicesForm_#index#';
    }
    
    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }

    public function setUpClientSave(\Client $client)
    {
        $this->ugyfel_id = $client->ugyfel_id;
        $this->flag_dirty('szolgaltatas_id');
    }

    public function canDeleteBeforeUpdate()
    {
        return true;
    }

    public function sheepIt2Serializable()
    {
        return array();
    }

    public function sheepItDelete()
    {
        $query = 'DELETE FROM ' . self::table_name() . ' WHERE ugyfel_id = ?';
        self::query($query, array($this->ugyfel_id));
    }

    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::table_name() . ' 
            (ugyfel_id, szolgaltatas_id, reszt_akar_venni, reszt_vett, mikor, mettol, meddig) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?)';
    }

    public function sheepItSaveValue()
    {
        $data = array($this->ugyfel_id, $this->szolgaltatas_id, null, null, null, null, null);
        $setIndex = function($value, $index) use (&$data) {
            if (!is_null($value)) {
                $data[$index] = $value;
            }
        };
        $setIndex($this->reszt_akar_venni, 2);
        $setIndex($this->reszt_vett, 3);
        $setIndex($this->mikor, 4);
        $setIndex($this->mettol, 5);
        $setIndex($this->meddig, 6);
        return $data;
    }
}