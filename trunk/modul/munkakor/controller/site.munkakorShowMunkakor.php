<?php
/**
 * @property Munkakor_ShowMunkakor_Model $_model
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
//class MunkakorShowMunkakor_Site_Controller extends RimoController
//include_once 'page/admin/controller/admin.edit.php';
//include_once 'page/admin/model/admin.edit_model.php';
class MunkakorShowMunkakor_Site_Controller extends Page_Edit
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteMunkakor';
    /**
     * Constructor
     */
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);        
        $this->__loadModel('_ShowMunkakor');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddMunkakor', 'addMunkakor');
        
        $this->__run();
    }
    /**
     * Render
     * @throws Exception_404
     */
    public function __show()
    {
        try {
            $lId = Rimo::$_config->SITE_NYELV_ID;
            // Lekérdezi a munkakör adatait.
            $jobData = $this->_model->findJobByUrl($_GET['link'], $lId);
            $this->_view->assign('jobData', $jobData);
            // Lekérdezi a munkakörhöz tartozó állásajánlatokat.
            $offers = $this->_model->findOffersByJobId($jobData['munkakor_id']);
            $this->_view->assign('offers', $offers);
            $this->_view->assign('feladatok', $this->_model->findFeladatok($jobData['munkakor_id']));
            $this->_view->assign('elvarasok', $this->_model->findElvarasok($jobData['munkakor_id']));
            // Tooltipek átadása a nézetnek.
            $this->_view->assign('tooltips', Rimo::$_config->tooltips);
            $this->_view->assign('activeTooltip', 2);
            // Megtekintés növelése.
            if ($_COOKIE['munkakor_megtekintes'] != $jobData['munkakor_id']) {
                $this->_model->updateViewed($jobData['munkakor_id'], $lId);
            }
            setcookie('munkakor_megtekintes', $jobData['munkakor_id'], time() + 300);
            // Render
            Rimo::$_site_frame->assign('PageName', false);
            Rimo::$_site_frame->assign('Indikator', array());
            Rimo::$_site_frame->assign('site_title', $jobData['munkakor_nev']);
            Rimo::$_site_frame->assign('site_description', $jobData['munkakor_leiras']);
            Rimo::$_site_frame->assign('site_keywords', $jobData['munkakor_meta_kulcsszo']);
            Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkakor/view/site.munkakor_show.tpl'));
        } catch (Exception_MYSQL $em) {
            throw new Exception_404;
        }  catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    
    public function onClick_addMunkakor() {
        $lId = Rimo::$_config->SITE_NYELV_ID;
        $jobData = $this->_model->findJobByUrl($_GET['link'], $lId);
        $this->_model->addMunkakor(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), $jobData['munkakor_id']);
    }
    
}