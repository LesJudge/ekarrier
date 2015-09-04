<?php
include_once "page/admin/controller/admin.list.php";

class UgyfellinkekAjax_Site_Controller extends RimoController{
    
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
                    case 'filtergroup':
                        if(isset($_GET['category']) && !empty($_GET['category'])){
                            echo json_encode($this->_model->filterByGroup($_GET['category']));
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