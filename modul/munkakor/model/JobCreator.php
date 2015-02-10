<?php

class JobCreator
{
    /**
     * Munkakör.
     * @var \Job
     */
    protected $job;
    /**
     * Munkakör kategóriák.
     * @var \SplObjectStorage
     */
    protected $categories;
    /**
     * Alapértelmezett kategória azonosító.
     * @var int
     */
    protected $defaultCategoryId = 1;
    /**
     * Konstruktor.
     * @param \Job $job Munkakör AR objektum.
     * @param boolean $addDefCat Adja-e hozzá a munkakört az alapértelmezett kategóriához.
     */
    public function __construct(\Job $job, $addDefCat = true)
    {
        $this->job = $job;
        $this->initCategoryStorage();
        if ($addDefCat === true) {
            $this->addCategoryById($this->getDefaultCategoryId());
        }
    }
    /**
     * Visszatér az alapértelmezett kategória azonosítóval.
     * @return int
     */
    public function getDefaultCategoryId()
    {
        return $this->defaultCategoryId;
    }
    /**
     * Inicializálja a munkakör kategóriákat tároló objektumot.
     */
    protected function initCategoryStorage()
    {
        $this->categories = new \SplObjectStorage;
    }
    /**
     * Hozzáadja a munkakör kategóriákat a listához.
     * @param array $categories
     * @throws \ActiveRecord\ModelException
     */
    public function addCategoriesById(array $categories)
    {
        foreach ($categories as $categoryId) {
            $this->addCategoryById($categoryId);
        }
    }
    /**
     * Hozzáadja a munkakör kategóriát a listához.
     * @param int $categoryId Munkakör kategória azonosító.
     * @throws \ActiveRecord\ModelException
     */
    public function addCategoryById($categoryId)
    {
        if (ArBase::isNaturalNoZeroNumber($categoryId)) {
            $jobCategory = new \JobCategory;
            $jobCategory->munkakor_attr_kategoria_id = $categoryId;
            $this->categories->attach($jobCategory);        
        } else {
            throw new \ActiveRecord\ModelException('Nem megfelelő kategória azonosító!');
        }
    }
    /**
     * Menti a munkakört kategóriákkal együtt.
     * @return boolean
     * @throws \ActiveRecord\ActiveRecordException
     */
    protected function saveJob()
    {
        if ($this->job->save()) {
            if (!empty($this->categories)) {
                return $this->saveCategories();
            }
            return true;
        }
        throw new \ActiveRecord\ActiveRecordException('A munkakör mentés sikertelen!');
    }
    /**
     * Menti a munkakörhöz a kategóriákat.
     * @return boolean
     * @throws \ActiveRecord\ActiveRecordException
     */
    protected function saveCategories()
    {
        /* @var $category \JobCategory */
        foreach ($this->categories as $category) {
            $category->munkakor_id = $this->job->munkakor_id;
            if (!$category->save()) {
                throw new \ActiveRecord\ActiveRecordException('A munkakör kategória mentése sikertelen!');
            }
        }
        return true;
    }
    /**
     * Menti a munkakört a kategóriákkal együtt.
     * @param boolean $transaction Tegye-e tranzakcióba.
     * @return boolean
     */
    public function save($transaction = true)
    {
        if ($transaction === true) {
            $connection = $this->job->connection();
            try {
                $connection->transaction();
                $this->saveJob();
                $connection->commit();
                return true;
            } catch (\Exception $e) {
                $connection->rollback();
                return false;
            }
        } else {
            return $this->saveJob();
        }
    }
    /**
     * Visszatér a munkakör objektummal.
     * @return \Job
     */
    public function getJob()
    {
        return $this->job;
    }
}