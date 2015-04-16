<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Rimo;

class ErrorController
{
    public function index()
    {
        $view = Rimo::$pimple['smarty'];
        $view->assign('domainAdmin', Rimo::$_config->DOMAIN_ADMIN);
        
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/Error.tpl'));
    }
}