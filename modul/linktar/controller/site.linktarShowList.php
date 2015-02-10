<?php
/**
 * @property Linktar_Show_Model $model
 */
class LinktarShowList_Site_Controller extends RimoController
{
    
    public $_name='LinktarShow';
    
    public function __construct()
    {
        $this->__loadModel('_Show');
        //parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        $site_frame=Rimo::$_site_frame;
        $view=$this->_view;
        
        $view->assign('links',$this->_model->getLinks());
        
        $site_frame->assign('PageName','Linktár');
        $site_frame->assign('Indikator',array());
        $site_frame->assign('site_title','site_title');
        $site_frame->assign('site_description','site_description');
        $site_frame->assign('site_keywords','site_keywords');
        $site_frame->assign('Content',$this->__generateForm('modul/linktar/view/site.linktar_show.tpl'));
    }
    
}