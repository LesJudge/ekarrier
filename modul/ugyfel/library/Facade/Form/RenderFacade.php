<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Rimo;
use Smarty;
use Uniweb\Library\Cache\Adapter\GregwarCacheAdapter;
use Uniweb\Module\Ugyfel\Library\Facade\Form\OptionsFacade;
use Uniweb\Module\Ugyfel\Library\Facade\Form\SelectedFacade;
use Uniweb\Module\Ugyfel\Library\Facade\Form\SheepItFacade;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\BirthData as BirthDataDecorator;

class RenderFacade
{
    /**
     * Adatok a rendereléshez.
     * @var ArrayObject
     */
    private $data;
    
    /**
     * Ügyfél objektum.
     * @var Client
     */
    private $client;
    
    public function __construct(ArrayObject $data, Client $client)
    {
        $this->data = $data;
        $this->client = $client;
    }
    
    public function render()
    {
        $this->data->offsetSet('client', $this->client);
        $this->data->offsetSet('clientId', (int)$this->client->ugyfel_id);
        $this->data->offsetSet('DOMAIN', Rimo::$_config->DOMAIN);
        $this->data->offsetSet('mode', $this->client->is_new_record() ? 'Új felvitel' : 'Módosítás');
        $this->data->offsetSet('gender', array(
            '' => '--Kérem, válasszon!--',
            'male' => 'Férfi',
            'female' => 'Nő'
        ));
        $this->data->offsetSet('birthDataDecorator', new BirthDataDecorator($this->client->birthdata));
        
        /* @var $cache GregwarCacheAdapter */
        $cache = Rimo::$pimple['gregwarCacheAdapter'];
        
        // SheepIt cuccok hozzáadása a nézet változókhoz.
        $sheepItFacade = new SheepItFacade;
        $sheepItFacade->assign($this->data);
        
        // Opciók hozzáadása a nézet változókhoz.
        $optionsFacade = new OptionsFacade($cache);
        $optionsFacade->assign($this->data);
        
        // Még mielőtt a selected facade átadná a nézetnek az értékeket, gyorsan rendezi a munkarendeket.
        $sortWorkschedulesFacade = new SortWorkschedulesFacade;
        $sortWorkschedulesFacade->assign($this->data);
        
        // Hozzáadja a szolgáltatásokat a nézet adatokhoz.
        $servicesFacade = new ServicesFacade($cache, 900);
        $servicesFacade->assign($this->data);
        
        // Select opciók hozzáadása a nézet változókhoz.
        $selectFacade = new SelectedFacade;
        $selectFacade->assign($this->data);
        
        // Tancsadók hozzáadása a nézet változókhoz.
        $consultantsFacade = new ConsultantsFacade($cache);
        $consultantsFacade->assign($this->data);
        
        // Összegyűjtött kommentek hozzáadása a nézet változókhoz.
        $collectedCommentsFacade = new CollectedCommentsFacade($this->client);
        $collectedCommentsFacade->assign($this->data);
        
        /* @var $smarty Smarty */
        $smarty = Rimo::$pimple['smarty'];
        
        foreach ($this->data as $key => $value) {
            $smarty->assign($key, $value);
        }
        
        // Tanácsadó neve alapértemezetten.
        $consultantName = 'Nem rendeltek hozzá tanácsadót!';
        $consultant = $this->client->consultant;
        
        // Ha az ügyfélhez tartozik tanácsadó, akkor annak a nevét jeleníti meg.
        if (!is_null($consultant)) {
            $consultantName = $consultant->getFullname();
        }
        
        $smarty->assign('consultant', $consultantName);
        
        $smarty->loadPlugin('Smarty_Function_Ar_Error');
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $smarty->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
    }
}