<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Uniweb\Module\Ugyfel\Model\ProjectCreator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client as ClientModel;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;
use Uniweb\Module\Ugyfel\Library\Exceptions\ProjectCreatorException;
use Uniweb\Module\Projekt\Model\ActiveRecord\Project;
use Uniweb\Library\DynamicFilter\FilterSetup;
use Uniweb\Library\DynamicFilter\Factory;
use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;
use Uniweb\Library\DynamicFilter\Exceptions\EmptyResultException;
use Uniweb\Library\DynamicFilter\Exceptions\FactoryException;
use Uniweb\Library\Flash\Flash;
use Rimo;

class ProjectController
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
     * Projekt létrehozása.
     */
    public function store()
    {
        if (!is_null($this->filter->read())) {
            try {
                $post = filter_input_array(INPUT_POST);
                if (isset($post['project']['nev'])) {
                    $project = new Project;
                    $project->nev = $post['project']['nev'];
                    $filterSetup = new FilterSetup(
                        $this->filter, 
                        new Factory(ClientModel::connection()->connection), 
                        Rimo::$pimple['clientFilterConfig']
                    );
                    $filterSetup->setUp($this->filter->read());
                    $projectCreator = new ProjectCreator($project, $this->filter->filter());
                    $projectCreator->create();
                    $this->flash->setFlash('success', 'Sikeresen létrehozta a projektet!');
                } else {
                    $this->flash->setFlash('error', 'Hiányzó projekt név!');
                }
            } catch (ProjectCreatorException $pce) {
                if ($pce->getCode() === ProjectCreator::PROJECT_DATA_ERROR) {
                    $this->flash->setFlash('error', 'A projekt neve nem megfelelő, vagy foglalt!');
                } else {
                    $this->flash->setFlash('error', $pce->getMessage());
                }
            } catch (EmptyResultException $ere) {
                $this->flash->setFlash('error', $ere->getMessage());
            } catch (DynamicFilterException $dfe) {
                $this->flash->setFlash('error', $dfe->getMessage());
            } catch (FilterException $fe) {
                $this->flash->setFlash('error', $fe->getMessage());
            } catch (FactoryException $fex) {
                $this->flash->setFlash('error', $fex->getMessage());
            }
        } else {
            $this->flash->setFlash('error', 'Szűrés nélkül nem hozhat létre projektet!');
        }
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
        exit;
    }
}