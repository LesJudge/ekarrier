<?php
namespace Uniweb\Library\Observer;
use SplObserver;
use SplSubject;
/**
 * Observer subject. Implementálja az \SplSubject interface-t, azoknak a metódusai definiálva vannak az 
 * osztályban. Ez az osztály azt a célt szolgálja, hogy a kód többi része minél inkább alkalmazkodjon a DRY elvekhez, 
 * vagyis ne legyen kódismétlés.
 */
class Subject implements SplSubject
{
    /**
     * Observers.
     * @var SplObserver[]
     */
    protected $observers = array();
    /**
     * Új observer hozzáadása.
     * @param SplObserver $observer Observer.
     */
    public function attach(SplObserver $observer)
    {
        $this->observers[] = $observer;
    }
    /**
     * Observer eltávolítása.
     * @param SplObserver $observer Observer.
     */
    public function detach(SplObserver $observer)
    {
        $key = array_search($observer, $this->observers, true);
        if (false !== $key) {
            unset($this->observers[$key]);
        }
    }
    /**
     * Observerek "értesítése".
     * @return void
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
    /**
     * Visszatér a subject-hez tartozó observerekkel.
     * @return SplObserver[]
     */
    public function getObservers()
    {
        return $this->observers;
    }
}