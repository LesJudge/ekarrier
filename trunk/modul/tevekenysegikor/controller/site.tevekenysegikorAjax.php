<?php
include_once "page/admin/controller/admin.list.php";

class TevekenysegikorAjax_Site_Controller extends RimoController{
    
    public function __construct()
    {
        $this->_view = new Smarty;
        $this->__loadModel('_Ajax_List');
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
	
    public function __run()
    {
        try
        {
            if(isset($_GET['todo']))
            {
                $todo = $_GET['todo'];
                switch($todo)
                {
                    case 'filterbygroup':
                        if(isset($_GET['gid']) && (int)$_GET['gid'] > 0){
                            echo json_encode($this->_model->filterByGroup((int)$_GET['gid']));
                        }
                    break;
                   
                    case 'filterbycircle':
                        if(isset($_GET['cid']) && (int)$_GET['cid'] > 0){
                            echo json_encode($this->_model->filterByCircle((int)$_GET['cid']));
                        }
                    break;
                    
                }
            }
            exit;

        }
        catch(Exception $e)
        {
            die();
        }
    }
    
}
?>