<?php
namespace Uniweb\Module\Ugyfel\Controller;

use ActiveRecord\ConnectionManager;
use Rimo;
use Slim\Slim;
use Smarty;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Uniweb\Module\Ugyfel\Model\Statistics;

class StatisticsController extends SlimBasedController
{
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }
    
    public function index()
    {
        $connectionManager = new ConnectionManager;
        $statistics = new Statistics($connectionManager->get_connection()->connection);
        /* @var $view Smarty */
        $view = Rimo::$pimple['smarty'];
        $view->assign('countClients', $statistics->countClients());
        $view->assign('programInformations', $statistics->programInformations());
        $view->assign('workschedules', $statistics->workschedules());
        $view->assign('educations', $statistics->educations());
        echo $view->fetch('modul/ugyfel/view/Admin/Statistics.tpl');
        $this->stop();
    }
}