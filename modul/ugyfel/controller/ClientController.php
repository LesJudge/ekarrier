<?php
namespace Uniweb\Module\Ugyfel\Controller;

use ActiveRecord\RecordNotFound;
use ArrayObject;
use Exception;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Rimo;
use Smarty;
use Uniweb\Library\DynamicFilter\Factory;
use Uniweb\Library\DynamicFilter\FilterSetup;
use Uniweb\Library\Flash\Flash;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Fixer as RelationFixer;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\ClientRelationCreator;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\EditConfig;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;
use Uniweb\Module\Ugyfel\Library\Facade\Form\OptionsFacade;
use Uniweb\Module\Ugyfel\Library\Facade\Form\RenderFacade;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Library\Request\Post\Validator as PostValidator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client as ClientModel;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\BirthData as BirthDataDecorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;

class ClientController
{
    /**
     * @var ClientFilter
     */
    protected $filter;
    
    /**
     * Szűrő beállítások.
     * @var array
     */
    protected $filterConfig;
    
    /**
     * @var Flash
     */
    protected $flash;
    
    /**
     * @var ClientRepository
     */
    protected $repository;
    
    /**
     * @param ClientFilter $filter Ügyfél szűrő objektum.
     * @param Flash $flash Flash objektum.
     * @param ClientRepository $repository Ügyfél repository objektum.
     */
    public function __construct(ClientFilter $filter, Flash $flash, ClientRepository $repository)
    {
        $this->filter = $filter;
        $this->flash = $flash;
        $this->repository = $repository;
    }
    
    /**
     * Ügyfelek listázása.
     */
    public function index()
    {
        $filterSet = !is_null($this->filter->read()); // Van-e aktív szűrő.
        $clients = array(); // Ügyfél collection.
        if ($filterSet) {
            try {
                $setup = new FilterSetup(
                    $this->filter, 
                    new Factory(ClientModel::connection()->connection), 
                    Rimo::$pimple['clientFilterConfig']
                );
                $setup->setUp($this->filter->read());
                $clientsCollection = $this->filter->filter();
            } catch (Exception $e) {
                $this->flash->setFlash('error', $e->getMessage());
                if ($this->flash->hasFlash('success')) {
                    $this->flash->removeFlash('success');
                }
            }
        } else {
            // Ha nincs aktív szűrő, akkor lekérdezi az ügyfeleket.
            $clientsCollection = $this->repository->findAll();
        }
        // Ha nem üres az eredményhalmaz, akkor feldolgozza a kapott ügyfél adatokat.
        if (!empty($clientsCollection)) {
            foreach ($clientsCollection as $clientItem) {
                $birthDataDecorator = new BirthDataDecorator($clientItem->birthdata);
                $clients[] = array(
                    'ugyfel_id' => $clientItem->ugyfel_id,
                    'vezeteknev' => $clientItem->vezeteknev,
                    'keresztnev' => $clientItem->keresztnev,
                    'email' => $clientItem->email,
                    'birthdate' => $birthDataDecorator->getBirthDate(),
                    'birthplace' => $birthDataDecorator->getFullBirthplace(),
                    'letrehozas_timestamp' => $clientItem->letrehozas_timestamp->format('Y-m-d H:i:s')
                );
            }
        } else {
            $this->flash->setFlash('info', 'Nincs megjeleníthető ügyfél!');
        }
        // Lapozó objektum.
        $pagerfanta = new Pagerfanta(new ArrayAdapter($clients));
        $pagerfanta->setMaxPerPage(100);
        // Aktuális oldal beállítása.
        $page = filter_input(INPUT_GET, 'page');
        if (!is_null($page)) {
            $page = (int)$page > 0 && $page <= $pagerfanta->getNbPages() ? (int)$page : 1;
            $pagerfanta->setCurrentPage($page);
        }
        // Lapozó nézet.
        $paginateView = new \Pagerfanta\View\DefaultView;
        $paginatorHtml = $paginateView->render($pagerfanta, function($page) {
            return Rimo::$_config->DOMAIN_ADMIN . 'ugyfel?page=' . $page;
        }, array(
            'next_message' => '>',
            'proximity' => 3,
            'previous_message' => '<'
        ));
        // Page limit.
        $pageLimit = array(100 => 100, 250 => 250, 500 => 500);
        
        $options = new ArrayObject;
        $optionsFacade = new OptionsFacade(Rimo::$pimple['gregwarCacheAdapter']);
        $optionsFacade->assign($options);        
        /* @var $view Smarty */
        $view = Rimo::$pimple['smarty'];
        $view->assign('DOMAIN', Rimo::$_config->DOMAIN);
        $view->assign('DOMAIN_ADMIN', Rimo::$_config->DOMAIN_ADMIN);
        $view->assign('clients', $pagerfanta->getCurrentPageResults());
        $view->assign('paginator', $paginatorHtml);
        $view->assign('pageLimit', $pageLimit);
        $view->assign('flash', $this->flash);
        $view->assign('filterSet', $filterSet);
        $view->assign('filterOptions', $filterSet ? json_encode($this->filter->read()) : false);
        $view->assign('genderOptions', Rimo::$_config->genderOptions);
        $view->assign('xlsExportConfig', Rimo::$pimple['clientXlsExportConfig']);
        foreach ($options as $key => $value) {
            $view->assign($key, $value);
        }
        $view->loadPlugin('Smarty_Function_Filter_Text');
        $view->loadPlugin('Smarty_Function_Filter_True_Or_False');
        // Lista renderelése.
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_list.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/List/Form.tpl'));
    }
    
    /**
     * Ügyfél form megjelenítése.
     */
    public function create()
    {
        try {
            // Új ügyfél objektum létrehozása.
            $client = $this->repository->instance();
            // Nem létező kapcsolatok felépítése, hogy a view-ban lehessen egyszerűen a kapcsolatokra hivatkozni.
            $relationFixer = new RelationFixer($client);
            $relationFixer->fix();
            // Form renderelése.
            $this->renderForm(new ArrayObject(array(
                'formUrl' => '/admin/ugyfel', 
                'requestMethod' => 'POST'
            )), $client);
        } catch (Exception $e) {
            $this->flash->setFlash('error', 'Hiba lépett fel az űrlap generálása során!');
            header('HTTP/1.0 500 Server Error');
            header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
            exit;
        }
    }
    
    public function store()
    {
        try {
            // Kérés validálása.
            $postValidator = new PostValidator;
            $postValidator->validate(array(
                'get' => filter_input_array(INPUT_GET), 
                'post' => filter_input_array(INPUT_POST)
            ));
            // Ügyfél objektum létrehozása.
            $filterInputArray = filter_input_array(INPUT_POST);
            $client = $this->repository->instance($filterInputArray['client']);
            $editConfig = new EditConfig;
            $post = filter_input_array(INPUT_POST);
            $clientRelationCreator = new ClientRelationCreator(
                $client, 
                $post['relationships'], 
                $editConfig->getConfig()
            );
            $relatedObjects = $clientRelationCreator->create();
            // Ügyfél mentése.
            if ($this->repository->create($client, $relatedObjects)) {
                // Sikeres mentés esetén irányítson át az ügyfél formra az üzenettel.
                $this->flash->setFlash('success', 'Sikeresen mentette az ügyfelet!');
                header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/' . $client->ugyfel_id . '/edit');
                exit;
            } else {
                // Sikertelen mentés esetén pedig renderlje ki a formot a hibaüzenetekkel.
                $this->renderForm(new ArrayObject(array(
                    'formError' => 'Az ügyfél mentése sikertelen, mert az adatok nem megfelelőek!',
                    'formUrl' => '/admin/ugyfel',
                    'requestMethod' => 'POST'
                )), $client);
            }
        } catch (Exception $e) {
            $this->handleFormError($e);
        }
    }
    
    public function edit($id)
    {
        try {
            // Ügyfél lekérdezése.
            $client = $this->repository->findById($id, true);
            // Form renderelése.
            $this->renderForm(new ArrayObject(array(
                'formUrl' => '/admin/ugyfel/' . $client->ugyfel_id,
                'requestMethod' => 'PUT'
            )), $client);
        } catch (RecordNotFound $rnf) {
            $this->flash->setFlash('error', 'A keresett ügyfél nem található!');
            header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
            exit;
        }
    }
    
    public function update($id)
    {
        try {
            $postValidator = new PostValidator;
            $postValidator->validate(array(
                'get' => filter_input_array(INPUT_GET),
                'post' => filter_input_array(INPUT_POST)
            ));
            // Ügyfél lekérdezése.
            $client = $this->repository->findById($id, false);
            // Kapcsolódó objektumok létrehozása.
            $filterInputArray = filter_input_array(INPUT_POST);
            $editConfig = new EditConfig;
            $clientRelationCreator = new ClientRelationCreator(
                $client, 
                $filterInputArray['relationships'], 
                $editConfig->getConfig()
            );
            $relatedObjects = $clientRelationCreator->create();
            $post = filter_input_array(INPUT_POST);
            $attributes = $post['client'];
            foreach ($attributes as $attribute => $value) {
                $client->{$attribute} = $value;
            }
            // Ügyfél mentése.
            if ($this->repository->update($client, $relatedObjects, $this->deletables())) {
                // Sikeres mentés esetén irányítson át az ügyfél formra az üzenettel.
                $this->flash->setFlash('success', 'Sikeresen mentette az ügyfelet!');
                header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/' . $client->ugyfel_id . '/edit');
                exit;
            } else {
                // Sikertelen mentés esetén pedig renderlje ki a formot a hibaüzenetekkel.
                $this->renderForm(new ArrayObject(array(
                    'formError' => 'Az ügyfél mentése sikertelen, mert az adatok nem megfelelőek!',
                    'formUrl' => '/admin/ugyfel/' . $client->ugyfel_id,
                    'requestMethod' => 'PUT'
                )), $client);
            }
        } catch (Exception $e) {
            $this->handleFormError($e);
        }
    }
    
    /**
     * Törli az ügyfelet.
     * @param int $id Ügyfél azonosító.
     */
    public function destroy($id)
    {
        try {
            if ($this->repository->delete($id)) { // Ha a törlés sikeres, akkor beállítja a sikeres üzenet flash-t.
                $this->flash->setFlash('success', 'Sikeresen törölte az ügyfelet!');
            }
        } catch (Exception $e) { // Ha a törlés sikertelen...
            // ... akkor beállítja a sikertelen üzenet flash-t.
            $this->flash->setFlash('error', 'Az ügyfél törlése sikertelen volt!');
            if ($e instanceof RecordNotFound) {
                // Ha az ügyfél nem található, akkor 404-es HTTP kóddal irányít át.
                header('HTTP/1.0 404 Not Found');
            } else {
                // Ha pedig nem, akkor adatbázis hiba történt, ezért 500-as kóddal irányít át.
                header('HTTP/1.0 500 Server Error');
            }
        }
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel'); // Átirányítás az ügyfél listára.
        exit;
    }
    
    private function deletables()
    {
        return array(
            new DeleteByResource\Address,
            new DeleteByResource\ComputerKnowledge,
            new DeleteByResource\Education,
            new DeleteByResource\Job,
            new DeleteByResource\Knowledge,
            new DeleteByResource\ProgramInformation,
            new DeleteByResource\ServiceInterested,
            new DeleteByResource\WorkSchedule
        );
    }
    
    /**
     * Ügyfél szerkesztés form renderelése.
     * @param ArrayObject $data Rendereléshez tartozó adatok.
     * @param ClientModel $client Ügyfél, akinek az adatait rendereli.
     */
    protected function renderForm(ArrayObject $data, ClientModel $client)
    {
        if (!$data->offsetExists('formError')) {
            $data->offsetSet('formError', false);
        }
        $data->offsetSet('flash', $this->flash);
        // Form renderelése.
        $renderFacade = new RenderFacade($data, $client);
        $renderFacade->render();
    }
    
    protected function handleFormError(Exception $e)
    {
        $whitelist = array(
            'Uniweb\\Library\\Utilities\\Request\\Exception\\ValidateException',
            'Uniweb\\Library\\Utilities\\ActiveRecord\\Exceptions\\RelationCreatorException',
            'Uniweb\\Library\\Utilities\\ActiveRecord\\Exceptions\\RelationFixerException'
        );
        $message = 'Ismeretlen hiba lépett fel a művelet során!';
        if (in_array(get_class($e), $whitelist)) {
            $message = $e->getMessage();
        }
        Rimo::$_site_frame->assign('Form', sprintf('<div class="notice error"><p>%s</p></div>', $e->getMessage()));
    }
    
    /**
     * Visszatér az ügyfél szűrő objektummal.
     * @return ClientFilter
     */
    public function getFilter()
    {
        return $this->filter;
    }
    
    public function getFilterConfig()
    {
        return $this->filterConfig;
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
     * Visszatér az ügyfél repository objektummal.
     * @return ClientRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    /**
     * Beállítja az ügyfél szűrő objektumot.
     * @param ClientFilter $filter Ügyfél szűrő objektum.
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
    
    /**
     * Beállítja az ügyfél repository-t.
     * @param ClientRepository $repository Repository objektum.
     */
    public function setRepository(ClientRepository $repository)
    {
        $this->repository = $repository;
    }
}
