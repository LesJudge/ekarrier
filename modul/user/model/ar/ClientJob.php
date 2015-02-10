<?php
/**
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $munkakor_id Munkakör azonosító.
 */
class ClientJob extends \ArBase implements \IClientSave, \ISheepItAble
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_munkakor';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'munkakor_id';
    /**
     * Munkakör adatokat tartalmazó tömb.
     * @var array
     */
    protected $jobData = array();
    
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
     * Mentés előtt lefutó metódus.
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function before_save()
    {
        parent::before_save();
        if ($this->isNewJob() && !$this->saveJob()) {
            throw new \ActiveRecord\ActiveRecordException('A munkakör mentése sikertelen!');
        }
    }
    /**
     * Eldönti, hogy kell-e új munkakört mentenie.
     * @return boolean
     */
    protected function isNewJob()
    {
        return (int)$this->read_attribute('munkakor_id') == 0 && !empty($this->jobData);
    }
    /**
     * Menti az új munkakört.
     * @return boolean
     */
    protected function saveJob()
    {
        $job = new \Job($this->jobData['job']);
        $jobCreator = new \JobCreator($job, true);
        if (!empty($this->jobData['categories'])) {
            $jobCreator->addCategoriesById($this->jobData['categories']);
        }
        $saved = $jobCreator->save(false);
        if ($saved) {
            $this->assign_attribute('munkakor_id', $jobCreator->getJob()->munkakor_id);
        }
        return $saved;
    }
    /**
     * Módosít az attribútumokon, mielőtt a model ténylegesen megkapná azokat.
     * @param array $attributes
     */
    protected function modifyAttributes(array &$attributes)
    {
        if (!isset($attributes['munkakor_id'])) {
            $attributes['munkakor_id'] = 0;
        }
        if ((int)$attributes['munkakor_id'] == 0) {
            $categories = array();
            $jobName = null;
            if (isset($attributes['munkakor_nev'])) {
                $jobName = $attributes['munkakor_nev'];
                unset($attributes['munkakor_nev']);
            }
            if (isset($attributes['categories'])) {
                $categories = is_array($attributes['categories']) ? $attributes['categories'] : array();
                unset($attributes['categories']);
            }
            $this->jobData['job'] = array('munkakor_nev' => $jobName);
            $this->jobData['categories'] = $categories;
        } else {
            if (isset($attributes['munkakor_nev'])) {
                unset($attributes['munkakor_nev']);
            }
            if (isset($attributes['categories'])) {
                unset($attributes['categories']);
            }
        }
    }
    /**
     * Mielőtt beállítaná az attribútumokat, előtte alakít rajtuk.
     * @param array $attributes Attribútumok.
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
        $class = get_called_class();
        return new $class;
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \self
     */
    public function setUpClientSave(\Client $client)
    {
        $this->ugyfel_id = $client->ugyfel_id;
        $this->flag_dirty('ugyfel_id');
        $this->flag_dirty('munkakor_id');
    }
    /**
     * Törölheti-e a rekord(okat) UPDATE előtt.
     * @return boolean
     */
    public function canDeleteBeforeUpdate()
    {
        return true;
    }
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm serializálható adatokkal.
     */
    public function sheepIt2Serializable()
    {
        if ($this->is_new_record()) {
            return $this->serializeNew();
        } else {
            return $this->serializeExisting();
        }
    }
    
    protected function serializeNew()
    {
        $mainId = isset($this->jobData['categories'][0]) ? $this->jobData['categories'][0] : null;
        $subId = isset($this->jobData['categories'][1]) ? $this->jobData['categories'][1] : null;
        $mam = new Munkakor_Ajax_Model;
        return array(
            'name' => isset($this->jobData['munkakor_nev']) ? $this->jobData['munkakor_nev'] : null,
            'mainId' => $mainId,
            'subId' => $subId,
            'jobId' => $this->munkakor_id,
            'subCategories' => $mam->findByMainId($mainId),
            'jobs' => $mam->findBySubId($subId)
        );
    }
    
    protected function serializeExisting()
    {
        $mam = new Munkakor_Ajax_Model;
        $job = $mam->findJobDataWithIds($this->munkakor_id);
        if (empty($job)) {
            return array(
                'name' => null,
                'mainId' => null,
                'subId' => null,
                'jobId' => null,
                'subCategories' => null,
                'jobs' => null
            );
        } else {
            $jobs = $mam->findBySubId($job['sub_id']);
            $subCategories = $mam->findByMainId($job['main_id']);
            return array(
                'name' => $job['job_name'],
                'mainId' => $job['main_id'],
                'subId' => $job['sub_id'],
                'jobId' => $this->munkakor_id,
                'subCategories' => $subCategories,
                'jobs' => $jobs
            );
        }
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $query = 'DELETE FROM ' . static::$table_name . ' WHERE ugyfel_id = ?';
        static::query($query, array($this->ugyfel_id));
    }
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'myPrefix_';
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::$table_name . ' (ugyfel_id, munkakor_id) VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE munkakor_id = ?';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        if ($this->isNewJob() && !$this->saveJob()) {
            throw new \ActiveRecord\ActiveRecordException('A munkakör mentése sikertelen!');
        }
        return array($this->ugyfel_id, $this->munkakor_id, $this->munkakor_id);
    }
}