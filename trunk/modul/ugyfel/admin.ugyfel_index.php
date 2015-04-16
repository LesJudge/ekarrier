<?php
// Modul előkészítése.
require 'modul/ugyfel/admin.moduleStartup.php';
// Slim példányosítása.
$app = Rimo::$pimple['slim'];
// Ügyfél URL-ek.
/* @var $app \Slim\Slim */
$app->group('/ugyfel', function() use ($app) {
    /* @var $clientController \Uniweb\Module\Ugyfel\Controller\ClientController */
    $clientController = Rimo::$pimple['clientController'];
    /* @var $filterController \Uniweb\Module\Ugyfel\Controller\FilterController */
    $filterController = Rimo::$pimple['clientFilterController'];
    /* @var $documentController \Uniweb\Module\Ugyfel\Controller\DocumentController */
    $documentController = new \Uniweb\Module\Ugyfel\Controller\DocumentController($app);
    /* @var $addressController \Uniweb\Module\Ugyfel\Controller\AddressController */
    $addressController = new \Uniweb\Module\Ugyfel\Controller\AddressController($app);
    /* @var $statisticsController \Uniweb\Module\Ugyfel\Controller\StatisticsController */
    $statisticController = new \Uniweb\Module\Ugyfel\Controller\StatisticsController($app);
    /* @var $contactController \Uniweb\Module\Ugyfel\Controller\ContactController */
    $contactController = new \Uniweb\Module\Ugyfel\Controller\ContactController($app);
    
    $verifyAccess = function($functionName) use ($app) {
        if (!isset(UserLoginOut_Controller::$_rights['__loadController']['ugyfel'][$functionName])) {
            $app->redirect(Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/permission-denied', 403);
        }
    };
    
    // Ügyfelek listázása.
    $app->get('([^/]*)', function() use ($verifyAccess) { $verifyAccess('list'); }, array($clientController, 'index'));
    // Ügyfél létrehozás form.
    $app->get('/create', function() use ($verifyAccess) { $verifyAccess('create'); }, array($clientController, 'create'));
    // Ügyfél létrehozása.
    $app->post('/', function() use ($verifyAccess) { $verifyAccess('create'); }, array($clientController, 'store'));
    // Ügyfél szerkesztés form.
    $app->get('/:id/edit', function() use ($verifyAccess) { 
        $verifyAccess('edit'); 
    }, array($clientController, 'edit'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél módosítása.
    $app->put('/:id', array($clientController, 'update'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél törlése.
    $app->delete('/:id', array($clientController, 'destroy'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél szűrő létrehozása.
    $app->post('/filter', array($filterController, 'create'));
    // Ügyfél szűrő törlése.
    $app->delete('/filter', array($filterController, 'destroy'));
    // Projekt létrehozása.
    $app->post('/project', array(Rimo::$pimple['clientProjectController'], 'store'));
    // Ügyfél exportálása .pdf-be.
    $app->get('/:id/pdf', array(Rimo::$pimple['clientPdfExportController'], 'export'))->conditions(array(
        'id' => '[1-9]+[0-9]*'
    ));
    // Ügyfélhez tartozó dokumentumok lekérdezése.
    $app->get('/:id/documents', array($documentController, 'all'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél dokumentum letöltése.
    $app->get('/document/:filename/download', array($documentController, 'download'))->conditions(array(
        'filename' => '[a-zA-Z0-9]+\.[a-zA-Z]{3,4}'
    ));
    // Dokumentum feltöltése az ügyfélhez.
    $app->post('/:id/document', array($documentController, 'upload'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Dokumentum törlése.
    $app->delete('/document/:filename', array($documentController, 'destroy'));
    // Ügyfélhez tartozó esetnapló bejegyzések.
    $app->get('/:id/contacts', array($contactController, 'contacts'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfélhez tartozó esetnapló bejegyzés mentése.
    $app->post('/:id/contacts', array($contactController, 'create'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél születési adatai.
    $app->get('/:id/birthplace', array($addressController, 'birthplace'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfélkezelő statisztika.
    $app->get('/statistics', array($statisticController, 'index'));
    // Ügyfelek exportálása .xls-be.
    $app->post('/xlsexport', array(Rimo::$pimple['clientXlsExportController'], 'export'));
    // Bármilyen felmerülő hiba kezelése.
    $app->any('/error', array(new \Uniweb\Module\Ugyfel\Controller\ErrorController($app), 'index'));
    // Hozzáférés megtagadva.
    $app->any('/permission-denied', function() use ($app) {
        $view = Rimo::$pimple['smarty'];
        $view->assign('domainAdmin', Rimo::$_config->DOMAIN_ADMIN);
        $app->status(403);
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/PermissionDenied.tpl'));
    });
});
// Nem található URL.
$app->notFound(function() {
    $view = Rimo::$pimple['smarty'];
    $view->assign('domainAdmin', Rimo::$_config->DOMAIN_ADMIN);
    Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/NotFound.tpl'));
});
// Nem várt hiba.
$app->error(function (\Exception $e) use ($app) {
    $app->redirect(Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/error', 500);
});
// Run!
$app->run();