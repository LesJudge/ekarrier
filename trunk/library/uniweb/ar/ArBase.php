<?php
/**
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
abstract class ArBase extends \ActiveRecord\Model
{
    const DEFAULT_DATE_FORMAT = 'Y-m-d';
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';
    /**
     * A tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key;
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array();
    /**
     * Modelhez tartozó behavior-ök.
     * @var array
     */
    protected $arBehaviors = array();
    protected $callbacks = array(
        'after_create',
        'after_destroy',
        'after_save',
        'after_update',
        'after_validation',
        'after_validation_on_create',
        'after_validation_on_update',
        'before_create',
        'before_destroy',
        'before_save',
        'before_update',
        'before_validation',
        'before_validation_on_create',
        'before_validation_on_update'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array();
    /**
     * Mezők értékeinek formátumára vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array();

    public function __construct(
        array $attributes = array(),
        $guard_attributes = true,
        $instantiating_via_find = false,
        $new_record = true
    ) {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        $behaviors = $this->arBehaviors();
        foreach ($behaviors as $behavior => $settings) {
            is_array($settings) ? $this->attachArBehavior($behavior, $settings) : $this->attachArBehavior($behavior);
        }
    }
    /**
     * __get Magic metódus felülírása.
     * @param string $name A példányváltozó neve.
     * @return mixed
     */
    public function &__get($name)
    {
        if ($this->hasArBehavior($name)) {
            return $this->getArBehavior($name);
        }
        return parent::__get($name);
    }
    /**
     * __call Magic metódus felülírása.
     * @param string $method Metódus neve.
     * @param array $args Metódus paraméterei.
     * @return mixed
     */
    public function __call($method, $args)
    {
        $behaviors = $this->getArBehaviors();
        foreach ($behaviors as $behavior) {
            $callable = array($behavior, $method);
            if (method_exists($behavior, $method) && is_callable($callable, true)) {
                return call_user_func_array($callable, $args);
            }
        }
        return parent::__call($method, $args);
    }
    /**
     * Inicializálás végén lefutó metódus.
     */
    public function after_construct()
    {
        return true;
    }
    /**
     * Mindig lefutó validáció.
     */
    public function validate()
    {
        return true;
    }
    /**
     * Visszatér a behavioröket tartalmazó tömbbel, melyeket a model példányosításakor inicializál.
     * @return array
     */
    public function arBehaviors()
    {
        return array();
    }
    /**
     * Csatolja a paraméterül adott behaviort a beállításokkal együtt, ha az megfelelő. Ellenkező esetben kivételt dob.
     * @param string $arBehavior A behavior neve.
     * @param array $settings A behavior beállításai.
     * @return void
     * @throws ArBehaviorException
     */
    public function attachArBehavior($arBehavior, array $settings = array())
    {
        if (!$this->arBehaviorExists($arBehavior)) {
            throw new ArBehaviorException("A/az {$arBehavior} AR Behavior nem létezik!");
        } elseif ($this->hasArBehavior($arBehavior)) {
            throw new ArBehaviorException("A/az {$arBehavior}-t már korábban hozzáadtad a modelhez!");
        } else {
            $this->arBehaviors[$arBehavior] = $this->instatiateArBehavior($arBehavior, $settings);
        }
    }
    /**
     * Törli a paraméterül adott behavior-t a modelből, ha az létezik. Ellenkező esetben kivételt dob.
     * @param string $arBehavior A behavior neve.
     * @return void
     * @throws ArBehaviorException
     */
    public function detachArBehavior($arBehavior)
    {
        if ($this->hasArBehavior($arBehavior)) {
            unset($this->arBehaviors[$arBehavior]);
        } else {
            throw new ArBehaviorException("A modelhez nem tartozik {$arBehavior} AR Behavior!");
        }
    }
    /**
     * Megvizsgálja, hogy valid-e az AR Behavior.
     * @param object $arBehavior
     * @return boolean
     */
    protected function isValidArBehavior($arBehavior)
    {
        return is_a($arBehavior, 'ArBehavior');
    }
    /**
     * Példányosít egy objektumot az AR Behavior-ből, majd visszatér vele, ha az az ArBehavior osztályból származik.
     * Ellenkező esetben <b>ArBehaviorException</b>-t dob.
     * @param string $arBehavior
     * @param array $settings
     * @return ArBehavior
     * @throws ArBehaviorException
     */
    protected function instatiateArBehavior($arBehavior, $settings = array())
    {
        if (count($settings) > 0) {
            $instance = new $arBehavior($this, $settings);
        } else {
            $instance = new $arBehavior($this);
        }
        if ($this->isValidArBehavior($instance)) {
            return $instance;
        } else {
            throw new ArBehaviorException("A/az {$arBehavior}-nek az ArBehavior osztályból kell származnia!");
        }
    }
    /**
     * Visszatér az AR Behavior objektummal, ha az létezik. Ha nem, akkor <b>ArBehaviorException</b>-t dob!
     * @param string $arBehavior
     * @return ArBehavior
     * @throws ArBehaviorException
     */
    public function getArBehavior($arBehavior)
    {
        if ($this->hasArBehavior($arBehavior)) {
            return $this->arBehaviors[$arBehavior];
        } else {
            throw new ArBehaviorException("A modelhez nem tartozik {$arBehavior} AR Behavior!");
        }
    }
    /**
     * Megvizsgálja, hogy a modelhez tartozik-e az AR Behavior.
     * @param string $arBehavior
     * @return boolean
     */
    public function hasArBehavior($arBehavior)
    {
        return isset($this->arBehaviors[$arBehavior]);
    }
    /**
     * Megvizsgálja, hogy az AR Behavior létezik-e.
     * @param string $arBehavior
     * @return boolean
     */
    public function arBehaviorExists($arBehavior)
    {
        return file_exists($this->arBehaviorPath() . $arBehavior . '.php');
    }
    /**
     * Visszatér az AR Behavior-ök elérési útjával.
     * @return string
     */
    public function arBehaviorPath()
    {
        return 'library/uniweb/ar/behavior/';
        //return __DIR__ . 'behavior';
    }
    /**
     * Megvizsgálja, hogy a modelhez tartozik-e a paraméterül adott callback.
     * @param string $callback
     * @return boolean
     */
    public function hasCallback($callback)
    {
        return in_array($callback, $this->getCallbacks());
    }
    /**
     * Csatolja a modelhez a paraméterül adott callback-et, ha az nincs csatolva. Ha igen, kivételt dob.
     * @param string $callback
     * @return void
     * @throws \ActiveRecord\ModelException
     */
    public function attachCallback($callback)
    {
        if (!$this->hasCallback($callback)) {
            $this->callbacks[] = $callback;
        } else {
            throw new \ActiveRecord\ModelException("A {$callback} callback már csatolva lett a modelhez!");
        }
    }
    /**
     * Törli a modelből a callback-et, ha az létezik. Ha nem, kivételt dob.
     * @param mixed $callback
     * @return void
     * @throws \ActiveRecord\ModelException
     */
    public function detachCallback($callback)
    {
        $detach = array();
        if (is_string($callback)) {
            if ($this->hasCallback($callback)) {
                $detach[] = $callback;
            } else {
                throw new \ActiveRecord\ModelException("A {$callback} callback nem tartozik a modelhez!");
            }
        }
        if (is_array($callback)) {
            foreach ($callback as $cb) {
                if ($this->hasCallback($cb)) {
                    $detach[] = $cb;
                } else {
                    throw new \ActiveRecord\ModelException("A {$cb} callback nem tartozik a modelhez!");
                }
            }
        }
        $this->callbacks = array_diff($this->getCallbacks(), $detach);
    }
    /**
     * Végrehajtja a behavior-ök paraméterül adott callbackjét.
     * @param string $callback
     * @return void
     */
    protected function fireCallback($callback)
    {
        if ($this->hasCallback($callback)) {
            $behaviors = $this->getArBehaviors();
            foreach ($behaviors as $behavior) {
                if (method_exists($behavior, $callback)) {
                    call_user_func(array($behavior, $callback));
                }
            }
        }
    }
    /**
     * Rekord létrehozása előtt lefutó metódus.
     * @return void
     */
    public function before_create()
    {
        $this->fireCallback('before_create');
    }
    /**
     * Rekord mentése előtt lefutó metódus.
     * @return void
     */
    public function before_save()
    {
        $this->fireCallback('before_save');
    }
    /**
     * Rekord módosítása előtt lefutó metódus.
     * @return void
     */
    public function before_update()
    {
        $this->fireCallback('before_update');
    }
    /**
     * Visszatér a modelhez csatolt AR Behavior-ökkel.
     * @return array
     */
    public function getArBehaviors()
    {
        return $this->arBehaviors;
    }
    /**
     * Visszatér a modelhez rendelt callback metódusok neveivel.
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott szám természetes szám-e.
     * @param int $number
     * @return boolean
     */
    public static function isNaturalNumber($number)
    {
        return is_numeric($number);
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott szám természetes szám-e, valamint nagyobb-e mint 0.
     * @param int $number
     * @return boolean
     */
    public static function isNaturalNoZeroNumber($number)
    {
        return self::isNaturalNumber($number) && $number > 0;
    }
    /**
     * Megvizsgálja, hogy a paraméterül adott szám megfelelő AutoIncrement ID-e.
     * @param int $aiId
     * @return int
     * @throws InvalidArgumentException
     */
    public static function validateAiId($aiId)
    {
        if (self::isNaturalNoZeroNumber($aiId)) {
            return $aiId;
        } else {
            throw new InvalidArgumentException('Az azonosító érték nem megfelelő!');
        }
    }
    /**
     * BIT mező értékének kiolvasása.
     * @param string $attribute Attribútum neve.
     * @return mixed
     */
    public function readBitAttribute($attribute)
    {
        $value = $this->read_attribute($attribute);
        if (!is_null($value) && is_string($value)) {
            $value = (int)$value;
        }
        return $value;
    }
    /**
     * BIT mező értékének beállítása.
     * @param string $attribute Attribútum neve.
     * @param mixed $value Attribútum értéke.
     */
    public function assignBitAttribute($attribute, $value)
    {
        $this->assign_attribute($attribute, is_null($value) ? null :chr($value));
    }
    /**
     * Kiolvassa a date/datetime/timestamp mezők értékét, majd visszatér a paraméterül adott formátummal, ha az
     * értéke <b>\ActiveRecord\DateTime<b> objektum. Ha nem az, akkor NULL-lal tér vissza. Ez azért van így, mert maga
     * a könyvtár is ezen az elven működik. Valid dátum esetén objektummal tér vissza, <i>minden más esetben NULL a
     * visszatérési értéke</i>.
     * @param string $attribute Az attribútum neve.
     * @param string $format Milyen formátummal térjen vissza.
     * @return mixed
     */
    public function readDateTimeAttribute($attribute, $format = 'Y-m-d')
    {
        $datetime = $this->read_attribute($attribute);
        if (is_a($datetime, '\ActiveRecord\DateTime')) {
            return $datetime->format($format);
        } else {
            return null;
        }
    }
    /**
     * Megvizsgálja, hogy az attribútum ki van-e töltve.
     * @param string $attribute Attribútum neve.
     * @return boolean
     * @deprecated
     */
    public function isAttributeSet($attribute)
    {
        return array_key_exists($attribute, $this->dirty_attributes());
    }
    /**
     * Visszatér az attribútum label-jével, ha az létezik.
     * @param string $attribute Attribútum neve.
     * @return string
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    public function getAttributeLabel($attribute)
    {
        if (!is_null(($realName = $this->get_real_attribute_name($attribute)))) {
            $labels = $this->attributeLabels();
            if (isset($labels[$attribute])) {
                return $labels[$attribute];
            } else {
                throw new \ActiveRecord\UndefinedPropertyException(
                    'Nem adtál meg label-t az attribútumhoz ('. $attribute . ')!'
                );
            }
        } else {
            throw new \ActiveRecord\UndefinedPropertyException('Az attribútum (' . $attribute . ') nem létezik!');
        }
    }
    /**
     * Attribútumok neveit tartalmazó tömb.
     * @return array
     */
    public function attributeLabels()
    {
        return array();
    }
    /**
     * A paraméterül adott \ActiveRecord\DateTime objektum értékét a paraméterül adott formátummá alakítja.
     * Ha nem ebből származik, akkor módosítás nélkül tér vissza a paraméterül adott értékkel.
     * @param mixed $value Érték.
     * @param string $format Formátum.
     * @return mixed
     */
    public function formatArDateTime($value, $format)
    {
        if ($value instanceof \ActiveRecord\DateTime) {
            return $value->format($format);
        }
        return $value;
    }
    /**
     * A paraméterül adott \ActiveRecord\DateTime objektum értékét átalakítja a paraméterül adott formátumra. Ha nem 
     * abból származik, akkor egy "kihúzással" tér vissza.
     * @param mixed $value Érték.
     * @param string $format Formátum.
     * @return string
     */
    public function getDateTimeFormatted($value, $format = 'Y-m-d')
    {
        $datetime = $this->formatArDateTime($value, $format);
        return $datetime ? $datetime : '-';
    }
}