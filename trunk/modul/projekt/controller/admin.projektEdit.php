<?php
//use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
//use Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket;
//use Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation;

class ProjektEdit_Admin_Controller extends Admin_Edit
{
    const MESSAGE_ERROR_NEW = 'Ehhez a feature-höz önnek nincs jogosultsága!';
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminProjektEdit';
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->__loadModel('_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    /**
     * Render.
     */
    public function __show()
    {
        parent::__show();
        $this->_view->assign('recordStatus', $this->_model->modifyID > 0);
        $this->_view->assign('client', new \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client);
        $this->_view->assign('laborMarket', new LaborMarket);
        $this->_view->assign('projectInformation', new ProjectInformation);
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/projekt/view/admin.projekt_edit.tpl')
        );
    }
    /**
     * Új projekt mentése.
     */
    public function onClick_New()
    {
        $this->disableFeature();
    }
    /**
     * Új projekt felvitel form elkészítése.
     */
    protected function onLoad_New()
    {
        $this->disableFeature();
    }
    /**
     * Megtiltja a feature használatát.
     * @throws \Exception_Form_Error
     */
    protected function disableFeature()
    {
        $this->_view->assign('fatalError', true);
        throw new \Exception_Form_Error(self::MESSAGE_ERROR_NEW);
    }
}