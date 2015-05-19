<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\Bit as AssignBit;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime as AssignDateTime;
use Uniweb\Library\Utilities\ActiveRecord\Read\Bit as ReadBit;
use Uniweb\Library\Utilities\ActiveRecord\Read\DateTime as ReadDateTime;
/**
 * Ügyfél által érdekelt szolgáltatások model. Elsődleges kulcsként a felhasználó azonosító van megadva, de ez
 * ebben a formában így helytelen, ugyanis egy kapcsolótáblát modelez, aminek két elsődleges kulcsa van.
 * 
 * @property int $ugyfel_attr_szolgaltatas_id Rekord azonosító.
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $szolgaltatas_id Szolgáltatás azonosító.
 * @property int $reszt_akar_venni Részt akar-e venni a szolgáltatáson.
 * @property int $reszt_vett Részt vett-e a szolgáltatáson.
 * @property mixed $mikor Mikor vett részt a szolgáltatáson.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_szolgaltatas_aktiv Megjelenik-e a rekord.
 * @property int $ugyfel_attr_szolgaltatas_erdekelt_torolt Törölt-e a rekord.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ServiceInterested extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_szolgaltatas_erdekelt';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_szolgaltatas_erdekelt_id';
    /**
     * Modelhez tartozó kapcsolatok 1:1.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'service',
            'class_name' => '\\Uniweb\\Module\\Szolgaltatas\\Model\\ActiveRecord\\Service',
            'conditions' => 'szolgaltatas_aktiv = 1 AND szolgaltatas_torolt = 1',
            'foreign_key' => 'szolgaltatas_id',
            'read_only' => true
        ),
        array(
            'client',
            'class_name' => '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Client',
            'foreign_key' => 'ugyfel_id'
        )
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'szolgaltatas_id',
            'message' => 'A szolgáltatás megadása kötelező!'
        )
    );
    /**
     * Számokra vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_numericality_of = array(
        array(
            'szolgaltatas_id',
            'greater_than' => 0,
            'message' => 'Nem megfelelő szolgáltatás azonosító!'
        )
    );
    
    public function get_ugyfel_attr_szolgaltatas_erdekelt_id()
    {
        return $this->read_attribute('ugyfel_attr_szolgaltatas_erdekelt_id');
    }
    
    public function get_reszt_akar_venni()
    {
        $read = new ReadBit;
        return (boolean)$read->readAttribute('reszt_akar_venni', $this);
    }
    
    public function get_reszt_vett()
    {
        $read = new ReadBit;
        return (boolean)$read->readAttribute('reszt_vett', $this);
    }
    
    public function get_mikor()
    {
        $read = new ReadDateTime('Y-m-d');
        return $read->readAttribute('mikor', $this);
    }
    
    public function set_ugyfel_attr_szolgaltatas_erdekelt_id($ugyfel_attr_szolgaltatas_erdekelt_id)
    {
        $assign = new AssignWithoutCast;
        $assign->assignAttribute('ugyfel_attr_szolgaltatas_erdekelt_id', $ugyfel_attr_szolgaltatas_erdekelt_id, $this);
    }
    
    public function set_reszt_akar_venni($reszt_akar_venni)
    {
        $assign = new AssignBit;
        $assign->assignAttribute('reszt_akar_venni', $reszt_akar_venni, $this);
    }
    
    public function set_reszt_vett($reszt_vett)
    {
        $assign = new AssignBit;
        $assign->assignAttribute('reszt_vett', $reszt_vett, $this);
    }
    
    public function set_mikor($mikor)
    {
        $assign = new AssignDateTime('Y-m-d');
        $assign->assignAttribute('mikor', $mikor, $this);
    }
}