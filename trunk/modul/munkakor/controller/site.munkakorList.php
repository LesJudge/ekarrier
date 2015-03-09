<?php

/**
 * @property Munkakor_Site_List_Model $_model Munkakör Site List model.
 * @property Smarty $_view Smarty
 */
class MunkakorList_Site_Controller extends Admin_List
{
    public $_name = 'SiteMunkakorList';
    protected $_multiple_lang = false;
    
    public function __construct()
    {   $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Site_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        
        //print_r($this->_params['FilterKategoriak']->_value);
        if($this->_params['TxtSearchByName']->_value){
            $this->_model->listWhere['search']="munkakor_nev LIKE '%".mysql_real_escape_string($this->_params['TxtSearchByName']->_value)."%'";
        }
        parent::__show();
        
        
        $this->_view->assign('tooltips', Rimo::$_config->tooltips);
        //$this->_view->assign('pageTitle', $this->_model->seoData['kategoria_cim']);
        $this->_view->assign('pageTitle', 'munkakörök');
        
        $this->_view->assign('parents', $this->_model->parents);
        
        Rimo::$_site_frame->assign('PageName', false);
        Rimo::$_site_frame->assign('Indikator', array());
        Rimo::$_site_frame->assign('site_title', $this->_model->seoData['kategoria_cim']);
        Rimo::$_site_frame->assign('site_description', $this->_model->seoData['kategoria_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $this->_model->seoData['kategoria_meta_kulcsszo']);
        
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkakor/view/site.munkakor_list.tpl'));
    }
    
    public function onClick_Filter()
    {/*
        
        if (!isset($_SESSION['lastMkCategory'])) {
            $_SESSION['lastMkCategory'] = $_GET['caturl'];
        }
        if ($_SESSION['lastMkCategory'] == $_GET['caturl']) {
            $filterKategoriak = $this->getItemValue('FilterKategoriak');
            if (is_array($filterKategoriak) && !empty($filterKategoriak)) {
                $this->setWhereInput(
                    'mak.munkakor_attr_kategoria_id IN (' . implode(',', $filterKategoriak) . ')', 'FilterKategoriak'
                );
            } else {
                unset($_SESSION[$this->_name]['FilterKategoriak']);
            }            
        } else {
            $_SESSION['lastMkCategory'] = $_GET['caturl'];
            unset($_SESSION[$this->_name]['FilterKategoriak']);
        }
       */ 
          
        $filterKategoriak = $this->_params['FilterKategoriak']->_value;
        if(!empty($filterKategoriak)){
            $this->setWhereInput('mak.munkakor_attr_kategoria_id IN (' . implode(',', $filterKategoriak) . ')', 'FilterKategoriak');
        }else{
            $this->_params['FilterKategoriak']->_value = null;
            unset($_SESSION[$this->_name]['FilterKategoriak']);
        }
        $filterSearch = $this->getItemValue('TxtSearchByName');
        $this->setWhereInput("munkakor_nev LIKE '%".mysql_real_escape_string($filterSearch)."%'",'TxtSearchByName');
    }
    
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
        	$this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba lépett fel a művelet során!');
        }
    }
}