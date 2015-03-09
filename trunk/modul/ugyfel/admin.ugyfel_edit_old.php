<?php
use Uniweb\Module\Ugyfel\Library\ActiveRecord\EditCreatorConfig;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Library\Facade\Form;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Fixer as RelationFixer;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator as RelationCreator;
use Uniweb\Library\Utilities\ActiveRecord\Observer\ValidateAdapter;
use Uniweb\Library\Utilities\ActiveRecord\Observer\SaveAdapter;
use Uniweb\Library\Resource\Observer\StatefulResourceSubject;
use Uniweb\Library\Resource\Observer\ValidateObserver;
use Uniweb\Library\Resource\Observer\SaveObserver;
// Config betöltése.
$moduleConfig = require 'modul/ugyfel/config/ModuleConfig.php';
Rimo::$pimple->register(new \Uniweb\Module\Ugyfel\Library\DependencyInjection\EditFlashProvider);
// Config hozzáadása a RimoConfig-hoz.
Rimo::__addConfig()->set($moduleConfig);
// AltoRouter
$router = new \AltoRouter;
$router->setBasePath(Rimo::$_config->clientRouterBasePath);

$router->map('GET|POST', '/[ugyfelek]?/?', function() {
    Rimo::__loadController('');
});

$router->map('GET', '/create/?', function() {
    $client = new Client;
    $relationFixer = new RelationFixer($client); // Nem létező kapcsolatok felépítése, hogy a view-ban ne legyen hiba.
    $relationFixer->fix();
    
    $data = new ArrayObject;
    $facade = new Facade($data, $client, Rimo::$pimple['clientEditFlash']);
    $facade->make();
    
    $view = Rimo::$pimple['smarty'];
    foreach ($data as $key => $value) {
        $view->assign($key, $value);
    }
    $view->loadPlugin('Smarty_Function_Ar_Error');
    $head = array();
    $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
    Rimo::$_site_frame->assign('head', $head);
    Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
});

$router->map('GET', '/edit/[i:id]/?', function($id) {
     /* @var $flash \Uniweb\Library\Flash\Flash */
    $flash = Rimo::$pimple['clientEditFlash'];
    $clientRepo = new ClientRepository;
    try {
        $client = $clientRepo->findById($id);
        $data = new ArrayObject;
        $facade = new Facade($data, $client, $flash);
        $facade->make();

        $view = Rimo::$pimple['smarty'];
        foreach ($data as $key => $value) {
            $view->assign($key, $value);
        }
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
    } catch (\ActiveRecord\RecordNotFound $rnf) {
        $flash->setFlash('error', 'A keresett ügyfél nem található!');
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/create/');
        exit;
    } catch (\Exception $e) {
        //echo '<pre>', print_r($e->getTrace(), true), '</pre>';
        //exit;
        echo $e->getMessage();
        exit;
        echo 'Végzetes hiba!';
    }
});

$router->map('POST', '/create/?', function() {
    $flash = Rimo::$pimple['clientEditFlash']; // Szerkesztés flash.
    $client = new Client($_POST['client']); // Új ügyfél.
    $prepare = $_POST['relationships']; // Kapcsolatok.
    
    $creators = new EditCreatorConfig(new ArrayObject);
    $relationCreator = new RelationCreator($client, $prepare, $creators->getConfig()->getArrayCopy());
    $related = $relationCreator->create(); // Kapcsolódó objektumok.
    // Kapcsolatok fixálása a kapcsolódó objektumok alapján.
    $fixer = new RelationFixer($client);
    $fixer->fix($related);
    // Validálás subject.
    $validateSubject = new StatefulResourceSubject($client);
    foreach ($related as $r) {
        if (is_array($r)) {
            foreach ($r as $s) {
                $validateSubject->attach(new ValidateObserver(new ValidateAdapter($s)));
            }
        } else {
            $validateSubject->attach(new ValidateObserver(new ValidateAdapter($r)));
        }
    }
    $validateSubject->notify();
    
    try {
        if ($client->is_valid() && $validateSubject->isOk()) {
            $connection = $client->connection();
            $connection->transaction();
            try {
                $saved = $client->save(false);
                $saveSubject = new StatefulResourceSubject($client);
                if ($saved) {
                    $observers = $validateSubject->getObservers();
                    foreach ($observers as $observer) {
                        $saveSubject->attach(new SaveObserver(new SaveAdapter($observer->getModel()->getModel())));
                    }
                }
                $saveSubject->notify();
                if ($saved && $saveSubject->isOk()) {
                    $connection->commit();
                    $flash->setFlash('success', 'Sikeresen mentette az ügyfelet!');
                    header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/edit/' . $client->ugyfel_id . '/');
                    exit;
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
                exit;
                $connection->rollback();
            }
        } else {
            throw new Exception;
        }
    } catch (Exception $ex) {
        $data = new ArrayObject;
        $facade = new Facade($data, $client, $flash);
        $facade->make();
        $view = Rimo::$pimple['smarty'];
        foreach ($data as $key => $value) {
            $view->assign($key, $value);
        }
        $view->loadPlugin('Smarty_Function_Ar_Error');
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
    }
});

$router->map('POST', '/edit/[i:id]/?', function($id) {
    $clientRepository = new ClientRepository;
    $flash = Rimo::$pimple['clientEditFlash']; // Szerkesztés flash.
    /* @var $client \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client */
    //$client = $clientRepository->findById($id);
    $client = Client::find_by_pk($id, array(
        'conditions' => array(
            'ugyfel_torolt' => 0
        )
    ));
    $clientData = $_POST['client'];
    foreach ($clientData as $key => $value) {
        $client->{$key} = $value;
    }
    $prepare = $_POST['relationships']; // Kapcsolatok.
    //echo '<pre>', print_r($prepare, true), '</pre>';
    //exit;
    
    $creators = new EditCreatorConfig(new ArrayObject);
    $relationCreator = new RelationCreator($client, $prepare, $creators->getConfig()->getArrayCopy());
    $related = $relationCreator->create(); // Kapcsolódó objektumok.
    // Kapcsolatok fixálása a kapcsolódó objektumok alapján.
    $fixer = new RelationFixer($client);
    $fixer->fix($related);
    // Validálás subject.
    $validateSubject = new StatefulResourceSubject($client);
    foreach ($related as $r) {
        if (is_array($r)) {
            foreach ($r as $s) {
                $validateSubject->attach(new ValidateObserver(new ValidateAdapter($s)));
            }
        } else {
            $validateSubject->attach(new ValidateObserver(new ValidateAdapter($r)));
        }
    }
    $validateSubject->notify();
    
    try {
        if ($client->is_valid() && $validateSubject->isOk()) {
            $connection = $client->connection();
            $connection->transaction();
            try {
                $saved = $client->save(false);
                $client->query(
                    'UPDATE ugyfel_attr_program_informacio SET ugyfel_attr_program_informacio_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_munkarend SET ugyfel_attr_munkarend_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_szolgaltatas_erdekelt SET ugyfel_attr_szolgaltatas_erdekelt_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_szamitogepes_ismeret SET ugyfel_attr_szamitogepes_ismeret_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_vegzettseg SET ugyfel_attr_vegzettseg_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_nyelvtudas SET ugyfel_attr_nyelvtudas_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_cim SET ugyfel_attr_cim_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                $client->query(
                    'UPDATE ugyfel_attr_munkakor SET ugyfel_attr_munkakor_torolt = ? WHERE ugyfel_id = ?', 
                    array(1, $client->ugyfel_id)
                );
                
                //var_dump($value);
                //exit;

                $saveSubject = new StatefulResourceSubject($client);
                if ($saved) {
                    $observers = $validateSubject->getObservers();
                    foreach ($observers as $observer) {
                        $saveSubject->attach(new SaveObserver(new SaveAdapter($observer->getModel()->getModel())));
                    }
                }
                $saveSubject->notify();
                if ($saved && $saveSubject->isOk()) {
                    $connection->commit();
                    $flash->setFlash('success', 'Sikeresen mentette az ügyfelet!');
                    header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/edit/' . $client->ugyfel_id . '/');
                    exit;
                }
            } catch (Exception $ex) {
                //echo $ex->getMessage();
                //exit;
                $connection->rollback();
            }
        } else {
            /*
            $observers = $validateSubject->getObservers();
            foreach ($observers as $observer) {
                echo '<pre>', print_r($observer->getModel()->getModel()->errors->to_array(), true), '</pre>';
            }
            exit;
             * 
             */
            throw new Exception;
        }
    } catch (Exception $ex) {
        $data = new ArrayObject;
        $facade = new Facade($data, $client, $flash);
        $facade->make();
        $view = Rimo::$pimple['smarty'];
        foreach ($data as $key => $value) {
            $view->assign($key, $value);
        }
        $view->loadPlugin('Smarty_Function_Ar_Error');
        $head = array();
        $head[] = '<link rel="stylesheet" type="text/css" href="../css_min/admin_ugyfelkezelo_edit.css" />';
        Rimo::$_site_frame->assign('head', $head);
        Rimo::$_site_frame->assign('Form', $view->fetch('modul/ugyfel/view/Admin/Edit/Form.tpl'));
    }
    
    //echo 'Update client';
    //echo '<pre>', print_r($_POST, true), '</pre>';
    //exit;
});
$match = $router->match();

if( $match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']); 
} else {
    echo 'Hiba';
    //Rimo::__loadController($_REQUEST['al']);
}