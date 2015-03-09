<?php
namespace Uniweb\Library\Form;
use Uniweb\Library\Form\Interfaces\MapSelectedOptionsInterface;

abstract class AbstractMap implements MapSelectedOptionsInterface
{
    /**
     * Összes opció.
     * @var array
     */
    protected $options;
    /**
     * Kiválasztott opciók.
     * @var null|array
     */
    protected $selectedOptions;
    
    public function __construct(array $options, array $selectedOptions = null)
    {
        $this->options = $options;
        $this->selectedOptions = $selectedOptions;
    }
    /**
     * Visszatér az összes opcióval.
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * Visszatér a kiválasztott opciókkal.
     * @return null|array
     */
    public function getSelectedOptions()
    {
        return $this->selectedOptions;
    }
    /**
     * Beállítja az összes opciót.
     * @param array $options Összes opció.
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
    /**
     * Beállítja a kiválasztott opciókat.
     * @param null|array $options Kiválasztott opciók.
     */
    public function setSelectedOptions(array $options = null)
    {
        $this->selectedOptions = $options;
    }
}