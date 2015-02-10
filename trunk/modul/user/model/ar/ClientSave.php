<?php
/**
 * Ügyfél mentés osztály.
 */
class ClientSave extends \Client
{
    const EMAIL_LOGIN_DATA = 3; // E-mail azonosító a bejelentkezési adatokhoz.
    /**
     * Ügyfél adatokat tartalmazó tömb.
     * @var ActiveRecord\Model[]
     */
    protected $models = array();
    /**
     * Azonosító alapján lekérdezi az ügyfél adatait.
     * @param int $clientId
     * @param boolean $include
     * @return \ClientSave
     * @throws \ActiveRecord\RecordNotFound
     */
    public static function findClient($clientId, $include = true)
    {
        if ($include === true) {
            return ClientSave::find($clientId, array(
                'include' => array(
                    'labormarket', 
                    'projectinformation', 
                    'clientdatastatus',
                    'clientbirthdata',
                    'residence',
                    'dwellingplace',
                    'temporaryresidence',
                    'educations', 
                    'knowledges', 
                    'computerknowledges',
                    'services',
                    'programinformations',
                    'workschedules',
                    'projects',
                    'jobs'
                )
            ));
        } else {
            return ClientSave::find($clientId);
        }
    }
    /**
     * Menti a felhasználót ügyfélként.
     */
    public function saveUserAsClient()
    {
        //$this->query(
        //    'INSERT INTO user_jogcsoport (user_jogcsoport_id, user_id) VALUES (?, ?)', 
        //    array(RimoConfig::USER_RG, $this->user_id)
        //);
        return true;
    }
    /**
     * Beállítja az objektum attribútumait a paraméterül adott tömbből.
     * @param array $attributes
     * @throws ActiveRecord\ModelException
     */
    public function set_attributes(array $attributes)
    {
        $isValidArray = function($data, $index) {
            return isset($data[$index]) && is_array($data[$index]) && !empty($data[$index]);
        };
        if ($isValidArray($attributes, 'client')) {
            parent::set_attributes($attributes['client']);
            if ($isValidArray($attributes, 'models')) {
                $this->initModels($attributes['models']);
            }
        } else {
            throw new ActiveRecord\ModelException('Az ügyfél mentéséhez alapvető adatok hiányoznak!');
        }
    }
    /**
     * Menti a rekordot.
     * @param boolean $validate Validáljon-e mentés előtt.
     * @return boolean
     * @throws ActiveRecord\ReadOnlyException
     */
    public function save($validate = true)
    {
        if ($this->is_readonly()) {
            throw new ActiveRecord\ReadOnlyException(get_class($this), __METHOD__);
        }
        return $this->is_new_record() ? $this->insertClient($validate) : $this->updateClient($validate);
    }
    /**
     * Átalakítja a paraméterül adott string-et StudlyCase formába.
     * @param string $value Átalakítandó string.
     * @return string
     * @todo Ezt ki kellene emelni valahova statikusként, vagy az \Illuminate\Str Laravel komponenst behúzni a framebe!
     */
    protected function toStudly($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        return str_replace(' ', '', $value);
    }
    /**
     * Inicializálja az ügyfél mentéshez a modeleket (egy rekord).
     * @param array $attributes
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     */
    protected function initModels(array $attributes)
    {
        foreach ($attributes as $name => $data) {
            $modelName = $this->toStudly($name);
            if (is_array($data) && class_exists($modelName)) {
                $this->registerModel($modelName, $data);
            } else {
                throw new \RuntimeException('Ismeretlen hiba lépett fel a művelet során!');
            }
        }
    }
    /**
     * A $_POST szuperglobálisból kapott adatok alapján példányosítja a modeleket.
     * @param string $model Példányosítandó model neve.
     * @param array $data Model adatokat tartalmazó tömb.
     * @throws \UnexpectedValueException
     */
    protected function registerModel($model, array $data)
    {
        $isAssociative = function($a) {
            foreach (array_keys($a) as $key) {
                if (!is_int($key)) {
                    return true;
                }
            }
            return false;
        };
        $checkInstance = function($instance) {
            if (!($instance instanceof \ActiveRecord\Model)) {
                throw new \UnexpectedValueException('Nem megfelelő bemeneti adatok!');
            }
        };
        if ($isAssociative($data)) {
            //$instance = call_user_func(array($model, 'model'), $this->user_id);
            $instance = call_user_func(array($model, 'model'), $this->ugyfel_id);
            $checkInstance($instance);
            $instance->set_attributes($data);
            $this->models[$model] = $instance;
        } else {
            foreach ($data as $params) {
                $instance = call_user_func(array($model, 'model'));
                $checkInstance($instance);
                $instance->set_attributes($params);
                $this->models[$model][] = $instance;
            }
        }
    }
    /**
     * Megvizsgálja,hogy az ügyfél adatai menthetőek-e.
     * @return boolean
     */
    public function is_valid()
    {
        $valid = parent::is_valid();
        array_walk_recursive($this->models, function($model) use (&$valid) {
            $result = $model->is_valid();
            $valid = $valid && $result;
        });
        return $valid;
    }
    /**
     * E-mailben elküldi a belépési adatokat a felhasználónak.
     * @param string $password Profilhoz rendelt jelszó.
     */
    public function sendLoginDataEmail($password)
    {
        $mailer = new RimoMailerFromDB(Rimo::__getSingletonDatabase('MYSQL_DB'));
        $mailer->emailFromDB(self::EMAIL_LOGIN_DATA);
        $mailer->BodyTPL->assign('felhasznalonev', $this->user_fnev);
        $mailer->BodyTPL->assign('jelszo', $password);
        $mailer->BodyTPL->assign('email', $this->user_email);
        //$mailer->BodyTPL->assign('vezetek_nev', $this->user_vnev);
        //$mailer->BodyTPL->assign('kereszt_nev', $this->user_knev);
        $mailer->AddAddress($this->user_email);
        $mailer->Send();
    }
    /**
     * Menti a felhasználóhoz tartozó modeleket.
     * @param \Client $client Ügyfél objektum
     * @param boolean $validate Validáljon-e mentés előtt
     * @return boolean
     */
    protected function saveModels(\Client $client, $validate)
    {
        $result = true;
        array_walk_recursive($this->models, function($model) use ($client, $validate, $result) {
            if ($model->is_new_record()) {
                $model->setUpClientSave($client);
            }
            if ($model instanceof \ISheepItAble) {
                $result = $result && ArHelper::saveSheepItForm($model);
            } else {
                $result = $result && $model->save($validate);
            }
        });
        return $result;
    }
    /**
     * Létrehoz egy új ügyfelet az adatbázisban.
     * @param boolean $validate Validáljon-e mentés előtt.
     * @return boolean
     */
    protected function insertClient($validate = true)
    {
        if ($validate && !$this->is_valid()) {
            return false;
        }
        $rm = $this->setAccessible('insert'); // Public láthatóságúvá teszi az 'insert' metódust.
        $conn = $this->connection(); // Adatbázis kapcsolat.
        $conn->transaction(); // Tranzakció indítása.
        $result = $rm->invoke($this, $validate); // Végrehajtja az 'insert' metódust.
        if ($result) {
            $this->saveUserAsClient(); // Ügyfél jogcsoport mentése.
            $result && $this->saveModels($this, $validate) ? $conn->commit() : $conn->rollback();
        }
        return $result;
    }
    /**
     * Módosítja az ügyfél adatait.
     * @param boolean $validate Validáljon-e mentés előtt.
     * @return boolean
     */
    protected function updateClient($validate = true)
    {
        if ($validate && !$this->is_valid()) {
            return false;
        }
        $rm = $this->setAccessible('update'); // Public láthatóságúvá teszi az 'insert' metódust.
        $conn = $this->connection(); // Adatbázis kapcsolat.
        $conn->transaction(); // Tranzakció indítása.
        $result = $rm->invoke($this, $validate); // Végrehajtja az 'insert' metódust.
        if ($result) {
            foreach ($this->models as $value) {
                if (is_array($value)) {
                    /* @var $object \ActiveRecord\Model|ISheepItAble|IClientSave */
                    $object = &current($value);
                    if ($object instanceof \ISheepItAble && $object->canDeleteBeforeUpdate()) {
                        $object->setUpClientSave($this);
                        $object->sheepItDelete();
                    }
                }
            }
            $result && $this->saveModels($this, $validate) ? $conn->commit() : $conn->rollback();
        }
        return $result;
    }
    /**
     * Hozzáférhetővé teszi a paraméterül adott metódust.
     * @param string  $method Metódus neve.
     * @return \ReflectionMethod
     */
    protected function setAccessible($method)
    {
        $rm = new ReflectionMethod($this, $method);
        $rm->setAccessible(true);
        return $rm;
    }
    /**
     * Visszatér az ügyfélhez tartozó modelekkel.
     * @return ActiveRecord\Model[]
     */
    public function getModels()
    {
        return $this->models;
    }
}