<?php
require 'modul/ugyfel/library/startup/admin.ugyfelkezeloStartup.php';
// Flash
require 'library/uniweb/Flash.php';
// Ügyfél mentés
require 'modul/ugyfel/model/ar/ClientSave.php';
require 'modul/ugyfel/library/ClientDocx.php';
// AR Error renderer.
require 'library/uniweb/smarty/ArErrorRenderer.php';
// E-mail küldés.
require 'modul/email/site.email.php';
// Munkakör AJAX model. Az ügyfélhez tartozó munkakörök feldolgozása miatt van rá szükség.
require 'modul/munkakor/model/munkakor_Ajax_Model.php';
require 'modul/user_cim/model/user_cim_Ajax_Model.php';
require 'modul/ugyfel/library/startup/admin.clientEditFormStartup.php';
/**
 * @property Smarty $_view Nézet Smarty objektum.
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class UgyfelEdit_Admin_Controller extends RimoController
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'UgyfelEdit';
    /**
     * Client model.
     * @var ClientSave
     */
    protected $client;
    /**
     * Flash kezelés.
     * @var \Flash
     */
    protected $flash;
    /**
     * Nézet változók.
     * @var array
     */
    protected $data = array();
    
    public function __construct()
    {
        $this->_action_type = &$_REQUEST;
        $this->flash = new Flash($_SESSION, Rimo::$_config->ugyfelFlashKey);
        try {
            $this->initModels();
        } catch (\ClientFactoryException $cfe) {
            echo $cfe->getMessage();
            exit;
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            $this->flash->setFlash('clientNotFound', 'A keresett ügyfél nem található!');
            header('Location:' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/');
            exit;
        }
        $this->__addEvent('BtnSave', 'Save');
        $this->__addEvent('BtnExport', 'Export');
        $this->__run();
    }
    /**
     * Form megjelenítése.
     */
    public function __show()
    {
        $this->init();
        if ($this->flash->hasFlash('saveSuccess')) {
            $this->data['FormMessage'] = $this->flash->getFlash('saveSuccess');
        }
        // Variable assign.
        foreach ($this->data as $key => $value) {
            $this->_view->assign($key, $value);
        }
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ugyfel/view/admin.ugyfel_edit.tpl'));
    }

    protected function initModels()
    {
        $userId = (int)filter_input(INPUT_GET, 'id');
        $include = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'GET';
        if (!$this->client) {
            if ($userId > 0) {
                $cs = ClientFactory::create(ClientFactory::MODE_EXISTING, $userId, $include);
            } else {
                $cs = ClientFactory::create(ClientFactory::MODE_NEW);
            }
        }
        $this->client = $cs;
        $clientData = ClientEditData::createClientData($cs);
        $clientEditOptions = ClientEditOptionsFacade::generateOptions();
        $this->data = array_merge(array(), $clientData, $clientEditOptions);
        $location = $birthplace = array();
        $this->data['location'] = json_encode($location);
        $this->data['birthplace'] = json_encode($birthplace);
        $this->data['models']['userEducation'] = new \UserEducation;
        $this->data['ucKnowledgeModel'] = new \UcKnowledge;
    }
    /**
     * Inicializálás.
     */
    protected function init()
    {
        // Betölti az AR renderelő Smarty plugint.
        // Ennek majd át kell kerülnie a core-ba!
        $this->_view->addPluginsDir('library/uniweb/smarty/plugins/');
        $this->_view->loadPlugin('Smarty_Function_Ar_Error');
        $this->data['mode'] = $this->client->is_new_record() ? 'Létrehozás' : 'Módosítás';
    }
    /**
     * Ügyfél mentése.
     */
    public function onClick_Save()
    {
        $this->validateRequest();
        try {
            $this->client->set_attributes(filter_input_array(INPUT_POST));
            if ($this->client->save()) {
                $this->redirectAfterSave();
            } else {
                $models = $this->client->getModels();
                foreach ($models as $key => $value) {
                    if (is_array($value)) {
                        $this->data[$key] = ArHelper::serializeSheepItModels($value);
                    } else {
                        $this->data[$key] = $value;
                    }
                }
                throw new \Exception_Form_Error('Nem megfelelő adatok! Kérem, ellenőrizze azokat!');
            }
        } catch (\Exception $e) {
            $message = 'Ismeretlen hiba!';
            $whitelist = array(
                'RuntimeException',
                'UnexpectedValueException',
                'ModelException',
                'Exception_Form_Error'
            );
            if (in_array(get_class($e), $whitelist)) {
                $message = $e->getMessage();
            }
            //echo '<pre>', print_r($e->getTrace(), true), '</pre>';
            //exit;
            //echo $e->getMessage();
            throw new Exception_Form_Error($message);
        }
    }
    
    public function onClick_Export()
    {
        require 'library/phpword/src/PhpWord/Autoloader.php';
        $docxConfig = require 'modul/ugyfel/config/admin.clientDocx.config.php';
        // Autoload PHPWord dependencies.
        \PhpOffice\PhpWord\Autoloader::register();
        $clientDocx = new ClientDocx($this->client, $docxConfig);
        $file = $clientDocx->generateDocx();
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        }
        exit;
    }
    /**
     * Megvizsgálja, hogy megfelelő create/update kérés érkezett-e.
     * @return boolean
     * @throws Exception_Form_Error
     */
    private function validateRequest()
    {
        $post = filter_input_array(INPUT_POST);
        if (
            isset($post['client'])
            &&
            isset($post['passwordAgain'])
            &&
            isset($post['models']['labor_market'])
            &&
            isset($post['models']['project_information'])
            //&&
            //$post['client']['user_jelszo'] === $post['passwordAgain']
        ) {
            //echo '<pre>', print_r($post['models'], true), '</pre>';
            //exit;
            return true;
        } else {
            throw new Exception_Form_Error('A kérés nem megfelelő, ezért a művelet nem végrehajtható!');
        }
    }
    /**
     * Mentés után átirányítja a felhasználót az ügyfél formra.
     */
    private function redirectAfterSave()
    {
        $this->flash->setFlash('saveSuccess', 'Sikeresen mentette az ügyfelet!');
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel/edit/' . $this->client->ugyfel_id);
        exit;
    }
}