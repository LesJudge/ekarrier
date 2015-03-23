<?php
include_once "page/admin/controller/admin.list.php";

class ForumHozzaszolas_Admin_Controller extends Admin_List {
    public $_name = "ForumHozzaszolasList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->_model = $this->__loadPublicModel("hozzaszolas","_List");
        $this->_model->_tableName = "forum_hozzaszolas";
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/forum/view/admin.forum_hozzaszolas_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hozzaszolas_bekuldo LIKE '%:item%' OR hozzaszolas_tartalom LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterNyelv")){
            $this->setWhereInput("hozzaszolas_nyelv=:item", "FilterNyelv");
        }else{ 
            unset($_SESSION[$this->_name]["FilterNyelv"]);
        }
        if($this->getItemValue("FilterKapcsolodo")){
            $this->setWhereInput("kapcsolodo_id=:item", "FilterKapcsolodo");
        }
        else{ 
            unset($_SESSION[$this->_name]["FilterKapcsolodo"]);
        }
        
        $filterChecked=$this->getItemValue('FilterChecked');
                switch($filterChecked)
                {
                        case 1:
                                $this->setWhereInput('checked = 0','FilterChecked');
                                break;
                        case 2:
                                $this->setWhereInput('checked = 1','FilterChecked');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterChecked']);
                                break;
                }
    }   
}
?>