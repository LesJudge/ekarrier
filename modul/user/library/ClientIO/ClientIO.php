<?php
/**
 * ClientIO export/import-ért felelős absztrakt osztály.
 */
abstract class ClientIO implements ClientIOInterface
{
    /**
     * Excel fájl, amibe az írás / amiből az olvasás történik.
     * @var \PHPExcel
     */
    protected $phpExcel;
    /**
     * Export/Import attribútumok.
     * @var \SplObjectStorage
     */
    protected $ioAttributes;
    /**
     * Attribútum adatokat tartalamzó tömb.
     * @var array
     */
    protected $attributes = array();
    /**
     * Alapértelmezett getter metódus neve.
     * @var string
     */
    protected $defaultGetter;
    /**
     * Alapértelmezett setter metódus neve.
     * @var string
     */
    protected $defaultSetter;
    /**
     * Konstruktor.
     * @param \PHPExcel $phpExcel
     * @param \SplObjectStorage $ioAttributes
     */
    public function __construct(\PHPExcel $phpExcel, \SplObjectStorage $ioAttributes)
    {
        $this->phpExcel = $phpExcel;
        $this->ioAttributes = $ioAttributes;
    }
    /**
     * Visszatér az alapértelmezett getter metódus nevével.
     * @return string
     */
    public function getDefaultGetter()
    {
        return $this->defaultGetter;
    }
    /**
     * Visszatér az alapértelmezett setter metódus nevével.
     * @return string
     */
    public function getDefaultSetter()
    {
        return $this->defaultSetter;
    }
    /**
     * Beállítja az alapértelmezett getter metódust.
     * @param string $getter
     * @throws \ClientIOException
     */
    public function setDefaultGetter($getter)
    {
        if (is_string($getter)) {
            $this->defaultGetter = $getter;
        } else {
            throw new \ClientIOException('Nem megfelelő getter metódus!');
        }
    }
    /**
     * Beállítja az alapértelmezett setter metódust.
     * @param string $setter
     * @throws \ClientIOException
     */
    public function setDefaultSetter($setter)
    {
        if (is_string($setter)) {
            $this->defaultSetter = $setter;
        } else {
            throw new \ClientIOException('Nem megfelelő settert metódus!');
        }
    }
    /**
     * Bejárja az osztályhoz tartozó objektumot, ha az implementálja az <b>\Iterator</b> interface-t.
     * @param string $attribute Példányváltozó neve.
     * @param \Closure $callback Callback.
     * @throws \InvalidArgumentException
     */
    public function iterate($attribute, \Closure $callback)
    {
        if (isset($this->{$attribute}) && is_object($this->{$attribute}) && $this->{$attribute} instanceof \Iterator) {
            $this->{$attribute}->rewind();
            while ($this->{$attribute}->valid()) {
                call_user_func($callback, &$this, $this->{$attribute}->current());
                $this->{$attribute}->next();
            }
        } else {
            throw new \InvalidArgumentException('Hiányzó iterátor! (' . (string)$attribute . ')');
        }
    }
    /**
     * Attribútumok beállítása.
     * @param array $attributes Attribútumok.
     * @throws \ClientIOException
     */
    public function setAttributes(array $attributes)
    {
        if (!empty($attributes)) {
            $this->attributes = $attributes;
        } else {
            throw new \ClientIOException('Kötelező attribútumot megadni!');
        }
    }
    /**
     * Létrehozza az attribútumok objektumokat.
     * @param array $attributes Attribútumok.
     * @throws \ClientIOExportException
     */
    public function setUpIoAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->setUpIoAttribute($attribute, $this->attributes[$attribute]);
            } else {
                throw new \ClientIOExportException('A paraméterül adott attribútum (' . $attribute . ') nem létezik!');
            }
        }
    }
    /**
     * Létrehozza az attribútum objektumot.
     * @param string $key Attribútum neve (kulcsa).
     * @param array $data Attribútum adatai.
     * @throws \ClientIOExportException
     */
    public function setUpIoAttribute($key, array $data)
    {
        $isset = function($key) use ($data) {
            return isset($data[$key]);
        };
        if ($isset('label')) {
            $label = $data['label'];
        } else {
            throw new \ClientIOExportException('A label megadása kötelező!');
        }
        $getter = $isset('getter') ? $data['getter'] : null;
        $setter = $isset('setter') ? $data['setter'] : null;
        $sourceMethod = $isset('source') ? $data['source'] : null;
        $isMultiple = (boolean)$sourceMethod;
        $this->ioAttributes->attach(new ClientIOAttribute($key, $label, $isMultiple, $sourceMethod, $getter, $setter));
    }
    /**
     * Visszatér a PHPExcel objektummal.
     * @return \PHPExcel
     */
    public function getPhpExcel()
    {
        return $this->phpExcel;
    }
}