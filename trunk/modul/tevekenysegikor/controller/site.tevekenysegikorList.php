<?php
require 'modul/seo/model/seo_Site_Model.php';
require 'page/admin/controller/admin.list.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
/**
 * @property Munkakor_Site_List_Model $_model Munkakör Site List model.
 * @property Smarty $_view Smarty
 */
class TevekenysegikorList_Site_Controller extends Admin_List
{
    public $_name = 'SiteTevekenysegikorList';
    protected $_multiple_lang = false;
    
    public function __construct()
    {   
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Site_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddLink', 'addLink');
        $this->__addEvent('BtnDeleteLink', 'deleteLink');
        $this->__run();
    }
    
    public function __show()
    {
       
        parent::__show();
        
        
        //$this->_view->assign('tooltips', Rimo::$_config->tooltips);
        $lId = Rimo::$_config->SITE_NYELV_ID;
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        
        //Linkek
        $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);  
        $this->_view->assign("linkMode","on");
        $this->_view->assign("addLinkOption","on");
        $this->_view->assign("links",$links);
        
        //SEO
        $seo = seo_Site_Model::model()->getSeoItemByKey('tevkorkereso',$lId);
        
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('Indikator', array());
        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/tevekenysegikor/view/site.tevekenysegikor_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        
        //Főkat szűrő
        $filterCsoport = $this->getItemValue('FilterCsoport');
          
             if(is_null($filterCsoport) || $filterCsoport == '')
        {
            unset($_SESSION[$this->_name]['FilterCsoport']);
        }
        else
        {
            $this->setWhereInput(' (SELECT
                                mk3.munkakor_kategoria_id 
                                FROM munkakor_kategoria mk3
                                WHERE mk3.baloldal < mk.baloldal AND mk3.jobboldal > mk.jobboldal AND mk3.munkakor_kategoria_aktiv = 1 AND mk3.munkakor_kategoria_torolt = 0 AND mk3.szint = 1) = '.(int)$filterCsoport, 'FilterCsoport');
        } 
        
        
        //Alkat szűrő
        $filterKor = $this->getItemValue('FilterKor');
          
             if(is_null($filterKor) || $filterKor == '')
        {
            unset($_SESSION[$this->_name]['FilterKor']);
        }
        else
        {
            $this->setWhereInput('mk.munkakor_kategoria_id = '.(int)$filterKor, 'FilterKor');
        }
        
        
        
        //Szektor szűrő
        $filterSzektor = $this->getItemValue('FilterSzektor');
          
             if(is_null($filterSzektor) || $filterSzektor == '')
        {
            unset($_SESSION[$this->_name]['FilterSzektor']);
        }
        else
        {
            $this->setWhereInput('ah.szektor_id IN('.(int)$filterSzektor.')', 'FilterSzektor');
        }
        
        
        //Poz szűrő
        $filterPozicio = $this->getItemValue('FilterPozicio');
          
             if(is_null($filterPozicio) || $filterPozicio == '')
        {
            unset($_SESSION[$this->_name]['FilterPozicio']);
        }
        else
        {
            $this->setWhereInput('ah.pozicio_id IN('.(int)$filterPozicio.')', 'FilterPozicio');
        } 
        
        
    }
    /*
    protected function getList()
    {
        try{
            $this->_view->assign('Fejlec', $this->_model->tableHeader);
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
        }
        catch (Exception_Mysql_Null_Rows $e) {
        	$this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormInfo', 'Nincs megjeleníthető szolgáltatás!');
        }
        catch (Exception $e) {
            //echo $e->getMessage();
        	$this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba lépett fel a művelet során!');
        }
    }
    */
    
    public function onClick_addLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."tevekenysegikor-kereso/");
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."tevekenysegikor-kereso/");
    }
    
    public function onClick_deleteLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
        ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
    }
}