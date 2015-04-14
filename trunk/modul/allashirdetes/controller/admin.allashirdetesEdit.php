<?php
//require 'page/admin/controller/admin.edit.php';
//require 'page/admin/model/admin.edit_model.php';
require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
require 'modul/user_cim/model/UserAddressFinder.php';
require 'library/uniweb/model/AjaxModel.php';
require 'modul/munkakor/model/munkakor_Ajax_Model.php';
/**
 * @property Allashirdetes_Edit_Model $_model Model.
 * @property Smarty $_view View.
 */
class AllashirdetesEdit_Admin_Controller extends Admin_Edit
{
    public $_name = 'AdminAllashirdetesEdit';

    public function __construct()
    {
        $this->__loadModel('_Edit');
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
        $ma = new \Munkakor_Ajax_Model;
        $this->_view->assign('munkakorMain', $ma->findAllMainCategory());
        //$this->_view->assign('elvarasOptions', json_encode($this->_model->findAllElvaras()));
        //$this->_view->assign('feladatOptions', json_encode($this->_model->findAllFeladat()));
        $this->_view->assign('amitKinalunkOptions', json_encode($this->_model->findAllAmitKinalunk()));
        $this->_view->assign('piTkor', AllashirdetesBaseEditModel::PI_TKOR);
        $this->_view->assign('piAmitKinalunk', AllashirdetesBaseEditModel::PI_AMIT_KINALUNK);
        $this->_view->assign('piElvarasok', AllashirdetesBaseEditModel::PI_ELVARASOK);
        $this->_view->assign('piFeladatok', AllashirdetesBaseEditModel::PI_FELADATOK);
        $this->_view->assign('recordStatus', $this->_model->modifyID > 0);
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/allashirdetes/view/admin.allashirdetes_edit.tpl')
        );
    }
}