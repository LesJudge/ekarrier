<?php
namespace Uniweb\Module\Ugyfel\Controller;

use Exception;
use Rimo;
use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;
use Uniweb\Library\DynamicFilter\Exceptions\FactoryException;
use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\Exceptions\PersistenceException;
use Uniweb\Library\DynamicFilter\Factory;
use Uniweb\Library\DynamicFilter\FilterSetup;
use Uniweb\Library\DynamicFilter\Interfaces\ControllerInterface;
use Uniweb\Library\Flash\Flash;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client as ClientModel;

class FilterController implements ControllerInterface
{
    /**
     * @var ClientFilter
     */
    protected $filter;
    
    /**
     * @var Flash
     */
    protected $flash;
    
    /**
     * @param ClientFilter $filter Ügyfél szűrő objektum.
     * @param Flash $flash Flash objektum.
     */
    public function __construct(ClientFilter $filter, Flash $flash)
    {
        $this->filter = $filter;
        $this->flash = $flash;
    }
    
    /**
     * Szűrő létrehozása.
     */
    public function create()
    {
        $post = filter_input_array(INPUT_POST);
        if (isset($post['filter']) && is_array($post['filter']) && !empty($post['filter'])) {
            try {
                $setup = new FilterSetup(
                    $this->filter, 
                    new Factory(ClientModel::connection()->connection), 
                    Rimo::$pimple['clientFilterConfig']
                );
                $setup->setUp($post['filter']);
                $this->filter->create($post['filter']);
                $this->flash->setFlash(
                        'success', 
                        'Sikeresen beállította a szűrőt! Ez egészen addig lesz aktív, amíg alaphelyzetbe '
                        . 'nem állítja, vagy a munkamenet meg nem szűnik!'
                );
            } catch (DynamicFilterException $dfe) {
                $this->flash->setFlash('error', $dfe->getMessage());
            } catch (FilterException $fe) {
                $this->flash->setFlash('error', $fe->getMessage());
            } catch (FactoryException $fex) {
                $this->flash->setFlash('error', $fex->getMessage());
            } catch (Exception $e) {
                $this->flash->setFlash('error', 'Végzetes hiba történt a szűrő beállítása során!');
            }
        } else {
            $this->flash->setFlash('error', 'Nem megfelelő szűrő paraméterek!');
        }
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
        exit;
    }
    
    /**
     * Szűrő törlése.
     */
    public function destroy()
    {
        try {
            $this->filter->destroy();
            $this->flash->setFlash('success', 'Sikeresen törölte a szűrőt!');
        } catch (PersistenceException $pe) {
            $this->flash->setFlash('error', $pe->getMessage());
        }
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
        exit;
    }
    
    /**
     * Visszatér a dinamikus szűrő objektummal.
     * @return ClientFilter
     */
    public function getFilter()
    {
        return $this->filter;
    }
    
    /**
     * Visszatér a flash objektummal.
     * @return Flash
     */
    public function getFlash()
    {
        return $this->flash;
    }
    
    /**
     * Beállítja a dinamikus szűrő objektumot.
     * @param ClientFilter $filter Dinamikus szűrő objektum.
     */
    public function setFilter(ClientFilter $filter)
    {
        $this->filter = $filter;
    }
    
    /**
     * Beállítja a flash objektumot.
     * @param Flash $flash Flash objektum.
     */
    public function setFlash(Flash $flash)
    {
        $this->flash = $flash;
    }
}