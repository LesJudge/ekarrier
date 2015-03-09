<?php
/**
 * @property int $munkakor_id Munkakör azonosító.
 * @property int $nyelv_id Nyelv azonosító.
 * @property string $munkakor_nev Munkakör neve.
 * @property string $munkakor_link Munkakörhöz tartozó SEO URL.
 * @property string $munkakor_leiras Munkakör leírása.
 * @property string $munkakor_meta_kulcsszo META kulcsszavak.
 * @property string $munkakor_tartalom Tartalom.
 * @property string $munkakor_elvarasok Elvárások.
 * @property int $munkakor_megtekintve Hányszor tekintették meg a munkakört.
 * @property int $munkakor_javitas_szama Hányszor módosították a munkakört.
 * @property \ActiveRecord\DateTime $munkakor_create_date Rekord létrehozásának ideje.
 * @property mixed $munkakor_modositas_datum Rekord módosításának ideje.
 * @property int $munkakor_letrehozo Létrehozó felhasználó azonosítója.
 * @property int $munkakor_modosito Módosító felhasználó azonosítója.
 * @property int $munkakor_aktiv Aktív-e a rekord.
 * @property int $munkakor_torolt Törölt-e a rekord.
 */
class Job extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'munkakor';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'munkakor_id';
    /**
     * Létrehozás idejét tároló mező neve.
     * @var mixed
     */
    protected $createdAttribte = 'munkakor_create_date';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'munkakor_modositas_datum';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'munkakor_letrehozo';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'munkakor_modosito';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'munkakor_javitas_szama';
    /**
     * Mentés előtt lefutó metódus.
     */
    public function before_save()
    {
        $link = $this->read_attribute('munkakor_link');
        if (empty($link)) {
            $this->assign_attribute('munkakor_link', Create::remove_accents($this->read_attribute('munkakor_nev')));
        }
    }
    /**
     * Validálja a modelt mentés előtt.
     */
    public function validate()
    {
        if ($this->is_new_record()) {
            $nameConditions = array('munkakor_nev = ?', $this->munkakor_nev);
            $urlConditions = array('munkakor_link = ?', $this->munkakor_link);
        } else {
            $nameConditions = array(
                'munkakor_nev = ? AND ' . self::$primary_key . ' != ?',
                $this->munkakor_nev,
                $this->munkakor_id
            );
            $urlConditions = array(
                'munkakor_link = ? AND ' . self::$primary_key . ' != ?',
                $this->munkakor_link,
                $this->munkakor_id
            );
        }
        if ($this->exists(array('conditions' => $nameConditions))) {
            $this->errors->add('munkakor_nev', 'Ez a munkakör név már foglalt!');
        }
        if ($this->exists(array('conditions' => $urlConditions))) {
            $this->errors->add('munkakor_link', 'Ez a link már foglalt!');
        }
    }
}