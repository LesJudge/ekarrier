<?php
/**
 * @property Ceg_Ajax_Model $_model
 */
class CegAjax_Admin_Controller extends RimoController
{

        public function __construct()
        {
                $this->__loadModel('_Ajax');
                $this->__run();
        }

        public function __show()
        {
                try
                {
                        if(isset($_REQUEST['action']))
                        {
                                switch($_REQUEST['action'])
                                {
                                        case 'getCmpsByJobId':
                                                echo json_encode($this->getCmpsByJobId());
                                                break;
                                        default:
                                                throw new Exception(500);
                                                break;
                                }
                        }
                        else
                        {
                                throw new Exception(500);
                        }
                }
                catch(Exception $e)
                {
                        header('HTTP/1.0 '.$e->getMessage());
                }
        }
        
        protected function getCmpsByJobId()
        {
                if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['jobId']))
                {
                        return $this->_model->getCompetenciesByJobId($_GET['jobId'],Rimo::$_config->ADMIN_NYELV_ID);
                }
                else
                {
                        throw new Exception(500);
                }
        }

}