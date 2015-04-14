<?php
require 'library/uniweb/interface/ValidateRequest.php';
require 'library/uniweb/controller/AjaxController.php';
require 'library/uniweb/model/AjaxModel.php';
require 'library/uniweb/ar/ArHelper.php';
/**
 * @property User_cim_Ajax_Model $_model Model.
 */
class User_cimAjaxSearch_Site_Controller extends AjaxController
{
    protected $ajaxOnly = false;
    
    public function __run()
    {
        $this->__loadModel('_Ajax');
        parent::__run();
    }
    
    public function __show()
    {
        header_remove('Content-Type');
        try {
            header('Content-Type: application/json');
            $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
            switch ($requestMethod) {
                case 'GET':
                    $method = filter_input(INPUT_GET, 'method');
                    $param = filter_input(INPUT_GET, 'param');
                    switch ($method) {
                        case 'iranyitoszam':
                            echo json_encode($this->_model->findByZipCode($param));
                            break;
                        case 'megye':
                            echo json_encode($this->_model->findByCounty($param));
                            break;
                        case 'varos':
                            echo json_encode($this->_model->findByCity($param));
                            break;
                        default:
                            throw new \Exception;
                    }
                    break;
                default:
                    throw new \Exception;
            }
            exit;
        } catch (\Exception $e) {
            header('Content-Type: text/html');
            throw new Exception_404;
        }
    }
}