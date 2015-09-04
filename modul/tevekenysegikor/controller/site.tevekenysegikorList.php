<?php
require 'modul/seo/model/seo_Site_Model.php';
//require 'page/admin/controller/admin.list.php';
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
//        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Site_List');
        
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        
        $lId = Rimo::$_config->SITE_NYELV_ID;
        
        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
        
        $obj = $tartalom->getTartalomByID(25);
        $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
        
        if( isset($_GET['oldal'])   || $this->getItemValue('FilterCsoport') > -1 
                                    || $this->getItemValue('FilterKor') > -1
                                    || $this->getItemValue('FilterSzektor') > 0
                                    || $this->getItemValue('FilterPozicio') > 0)
        {
            $this->_view->assign("jumpToAnc","1");
        }
        if($_REQUEST["extra"]=== '1'){
            $this->_view->assign('extra','extra');
        }
        
        
        //SEO
        $seo = seo_Site_Model::model()->getSeoItemByKey('tevkorkereso',$lId);
        
        Rimo::$_site_frame->assign('PageName', $obj[0]["tartalom_cim"]);
        Rimo::$_site_frame->assign('Indikator', array());
        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/tevekenysegikor/view/site.tevekenysegikor_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        
        $filterMunkakor = $this->getItemValue('TxtSearchByName');
        if (!empty($filterMunkakor)) {
            $this->setWhereInput("munkakor_nev LIKE '%". mysql_real_escape_string($filterMunkakor)."%'", 'TxtSearchByName');
        } else {
            unset($_SESSION[$this->_name]['TxtSearchByName']);
        }
        //Főkat szűrő
        $filterCsoport = $this->getItemValue('FilterCsoport');
          
        if(is_null($filterCsoport) || $filterCsoport == '-1')
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
          
        if(is_null($filterKor) || $filterKor == '-1')
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
            $_REQUEST['extra'] = '1';
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
            $_REQUEST['extra'] = '1';
        }     
    }
   
}

