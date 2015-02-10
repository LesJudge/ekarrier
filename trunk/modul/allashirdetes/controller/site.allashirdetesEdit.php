<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
require 'page/admin/controller/admin.edit.php';
require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
require 'modul/user_cim/model/UserAddressFinder.php';
require 'modul/ceg/model/CompanyHelperModel.php';
/**
 * @property Ceg_Allashirdetes_SiteEdit_Model $_model
 * @property Smarty $_view
 */
class AllashirdetesEdit_Site_Controller extends Admin_Edit
{
    public $_name = 'SiteAllashirdetesEdit';

    public function __construct()
    {
        // Megvizsgálja, hogy van-e jogosultsága a felhasználónak.
        UserLoginOut_Site_Controller::verifyJogcsoportAccess(RimoConfig::COMPANY_RG);
        // Megvizsgálja, hogy cég-e.
        $companyId = (int) CompanyHelperModel::model()->findCompanyByUserId(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Site_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
        $this->__run();
    }

    public function __runParams()
    {
        parent::__runParams();
        $this->_model->removeAccentsFromLink();
        $this->_model->removeDelimitterFromKulcsszo();
    }

    public function __show()
    {
        parent::__show();
        $this->_view->assign('cities', $this->_model->findCities4Autocomplete());
        $this->_view->assign('tkorOptions', json_encode($this->_model->findAllMunkakor()));
        //$this->_view->assign('elvarasOptions', json_encode($this->_model->findAllElvaras()));
        //$this->_view->assign('feladatOptions', json_encode($this->_model->findAllFeladat()));
        $this->_view->assign('amitKinalunkOptions', json_encode($this->_model->findAllAmitKinalunk()));
        $this->_view->assign('piTkor', AllashirdetesBaseEditModel::PI_TKOR);
        $this->_view->assign('piAmitKinalunk', AllashirdetesBaseEditModel::PI_AMIT_KINALUNK);
        $this->_view->assign('piElvarasok', AllashirdetesBaseEditModel::PI_ELVARASOK);
        $this->_view->assign('piFeladatok', AllashirdetesBaseEditModel::PI_FELADATOK);
        $this->_view->assign('recordStatus', $this->_model->modifyID > 0);
        Rimo::$_site_frame->assign(
            'Content',
            $this->__generateForm('modul/allashirdetes/view/admin.allashirdetes_edit.tpl')
        );
    }
}