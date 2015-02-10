<?php
/**
 * @property Munkakor_KiegeszitesEdit_Model $_model
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorKiegeszit_Site_Controller extends Page_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'SiteMunkakorKiegeszitesEdit';

    public function __construct()
    {   
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        UserLoginOut_Site_Controller::verifyJogcsoportAccess(RimoConfig::USER_RG);
        $this->__loadModel('_KiegeszitesEdit');
        if(isset($_GET['type']) && !isset($_GET['id'])) {
            switch($_GET['type']) {
                case 'tartalom':
                    $this->_model->init('munkakor_tartalom_kiegeszites', true);
                    break;
                /*
                case 'elvarasok':
                    $this->_model->init('munkakor_elvarasok_kiegeszites', false);
                    break;
                */
                default:
                    throw new Exception_404;
                    break;
            }
            try {
                $jobData = $this->_model->getJobByUrl($_GET['munkakor'], Rimo::$_config->SITE_NYELV_ID);
                $this->_model->setJobData($jobData);
            } catch(Exception_MYSQL_Null_Rows $emnr) {
                throw new Exception_404;
            }
        }
        else {
            throw new Exception_404;
        }
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave',$this->_name));
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        $jobData = $this->_model->getJobData();
        $this->_view->assign('content', $this->_model->getJobContent());
        // Render
        Rimo::$_site_frame->assign('Indikator', false);
        Rimo::$_site_frame->assign('PageName', $jobData['munkakor_nev'].' - Szerkesztés');
        Rimo::$_site_frame->assign('site_title', $jobData['munkakor_nev'].' - Szerkesztés');
        Rimo::$_site_frame->assign('site_description', $jobData['munkakor_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $jobData['munkakor_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkakor/view/site.munkakor_kiegeszit.tpl'));
    }
    
    public function onClick_New()
    {
        try {
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            $this->_model->__insert();
            $this->onSave_Other($this->_model->insertID);
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message('Sikeres mentés!');
        } catch(Exception_MYSQL $em) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error('Végzetes hiba lépett fel a művelet során!');
        }
    }
}