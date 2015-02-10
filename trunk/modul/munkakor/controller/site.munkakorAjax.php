<?php
require 'library/uniweb/interface/ValidateRequest.php';
require 'library/uniweb/controller/AjaxController.php';
require 'library/uniweb/model/AjaxModel.php';
require 'library/uniweb/ar/ArHelper.php';
/**
 * @property Munkakor_Ajax_Model $_model Model
 */
class MunkakorAjax_Site_Controller extends AjaxController
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
                    switch ($method) {
                        case 'all':
                            echo json_encode($this->_model->findAllMainCategory());
                            break;
                        case 'filterbymain':
                            $mainId = (int)filter_input(INPUT_GET, 'mainId');
                            echo json_encode($this->_model->findByMainId($mainId));
                            break;
                        case 'filterbysub':
                            $subId = (int)filter_input(INPUT_GET, 'subId');
                            echo json_encode($this->_model->findBySubId($subId));
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