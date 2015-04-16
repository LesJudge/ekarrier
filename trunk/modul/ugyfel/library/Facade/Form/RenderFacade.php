<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\BirthData as BirthDataDecorator;
use Uniweb\Module\Ugyfel\Library\Facade\Form\OptionsFacade;
use Uniweb\Module\Ugyfel\Library\Facade\Form\SheepItFacade;
use Uniweb\Module\Ugyfel\Library\Facade\Form\SelectedFacade;
use ArrayObject;
use Rimo;

class RenderFacade
{
    /**
     * Adatok a rendereléshez.
     * @var \ArrayObject
     */
    protected $data;
    /**
     * Ügyfél objektum.
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client
     */
    protected $client;
    
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
        $sheepItFacade = new SheepItFacade;
        $optionsFacade = new OptionsFacade(Rimo::$pimple['gregwarCacheAdapter']);
        $selectFacade = new SelectedFacade;
        $sheepItFacade->assign($this->data);
        $optionsFacade->assign($this->data);
        $selectFacade->assign($this->data);
        $smarty = Rimo::$pimple['smarty'];
        foreach ($this->data as $key => $value) {
            $smarty->assign($key, $value);
        }
        $smarty->loadPlugin('Smarty_Function_Ar_Error');
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $smarty->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
    }
}