<?php

class ClientIOAttribute implements ClientIOAttributeInterface
{
    /**
     * Attribútum neve (kulcsa).
     * @var string
     */
    protected $name;
    /**
     * Attribútum label-lje.
     * @var string
     */
    protected $label;
    /**
     * "Több értékű-e" az attribútum.
     * @var boolean
     */
    protected $isMultiple;
    /**
     * Forrást elérő metódus neve.
     * @var string
     */
    protected $sourceMethod;
    /**
     * Attribútum getter metódus neve.
     * @var mixed
     */
    protected $getter;
    /**
     * Attribútum setter metódus neve.
     * @var mixed
     */
    protected $setter;
    /**
     * Konstruktor.
     * @param string $name Attribútum neve (kulcsa).
     * @param string $label Attribútum label-je.
     * @param boolean $isMultiple Több értékű-e az attribútum.
     * @param mixed $getter Getter metódus neve.
     * @param mixed $setter Setter metódus neve.
     */
    public function __construct($name, $label, $isMultiple, $sourceMethod = null, $getter = null, $setter = null)
    {
        $this->setName($name);
        $this->setLabel($label);
        $this->isMultiple = $isMultiple;
        $this->sourceMethod = $sourceMethod;
        $this->setGetter($getter);
        $this->setSetter($setter);
    }
    /**
     * Engedélyezett metódus típusok a metódus lekérdezésnél/beállításnál.
     * @return array
     */
    protected function allowedMethodTypes()
    {
        return array('getter', 'setter');
    }
    /**
     * "Több értékű-e" az attribútum.
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->isMultiple;
    }
    /**
     * Visszatér a getter metódussal, ha az létezik. Ha nem, akkor a ClientIO::getDefaultGetter() értékével.
     * @return string
     * @throws \ClientIOException
     */
    public function getGetter()
    {
        return $this->getter;
    }
    /**
     * Visszatér az attribútum label-jével.
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    public function getSourceMethod()
    {
        return $this->sourceMethod;
    }
    /**
     * Visszatér az attribútum nevével (kulcsával).
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Visszatér a setter metódussal, ha az létezik. Ha nem, akkor a ClientIO::getDefaultSetter() értékével.
     * @return string
     * @throws \ClientIOException
     */
    public function getSetter()
    {
        return $this->setter;
    }
    /**
     * Beállítja a getter metódus nevét.
     * @param mixed $getter Getter metódus neve.
     * @throws \ClientIOException
     */
    public function setGetter($getter)
    {
        $this->getter = $getter;
    }
    /**
     * Beállítja a label-t.
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    /**
     * Beállítja az attirúbum nevét (kulcsát).
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Beállítja a setter metódus nevét.
     * @param mixed $setter
     * @throws \ClientIOException
     */
    public function setSetter($setter)
    {
        $this->setter = $setter;
    }
}