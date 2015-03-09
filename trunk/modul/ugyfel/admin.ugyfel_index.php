<?php
// Modul előkészítése.
require 'modul/ugyfel/admin.moduleStartup.php';
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
    // Ügyfelek listázása.
    $app->get('([^/]*)', array($clientController, 'index'));
    // Ügyfél létrehozás form.
    $app->get('/create', array($clientController, 'create'));
    // Ügyfél létrehozása.
    $app->post('/', array($clientController, 'store'));
    // Ügyfél szerkesztés form.
    $app->get('/:id/edit', array($clientController, 'edit'))->conditions(array('id' => '[1-9]+[0-9]*'));
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
    
    $app->get('/:id/contacts', array($contactController, 'contacts'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfél születési adatai.
    $app->get('/:id/birthplace', array($addressController, 'birthplace'))->conditions(array('id' => '[1-9]+[0-9]*'));
    // Ügyfélkezelő statisztika.
    $app->get('/statistics', array($statisticController, 'index'));
    // Ügyfelek exportálása .xls-be.
    $app->post('/xlsexport', array(Rimo::$pimple['clientXlsExportController'], 'export'));
});
// Nem található URL.
$app->notFound(function() {
    Rimo::$_site_frame->assign('Form', '<div class="notice error"><p>A keresett oldal nem található!</p></div>');
});
// Nem várt hiba.
$app->error(function (\Exception $e) use ($app) {
    echo 'ERROR FUNCTION', '<br />', get_class($e), '<br />';
    echo $e->getMessage();
    exit;
    //ob_clean();
    //Rimo::$_site_frame->clearAllAssign();
    //Rimo::$_site_frame->assign('Form', Rimo::$pimple['smarty']->fetch('modul/ugyfel/view/Admin/Edit/Error.tpl'));
    //Rimo::$pimple['smarty']->display('modul/ugyfel/view/Admin/Edit/Error.tpl');
});
// Run!
$app->run();