<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Uniweb\Module\Ugyfel\Model\Statistics;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Slim\Slim;
use Rimo;

class StatisticsController extends SlimBasedController
{
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }
    
    public function index()
    {
        $statistics = new Statistics((new \ActiveRecord\ConnectionManager)->get_connection()->connection);
        /* @var $view \Smarty */
        $view = Rimo::$pimple['smarty'];
        $view->assign('programInformations', $statistics->programInformations());
        echo $view->fetch('modul/ugyfel/view/Admin/Statistics.tpl');
        $this->stop();
    }
}