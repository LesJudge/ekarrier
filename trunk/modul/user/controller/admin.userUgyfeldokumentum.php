<?php
require 'library/uniweb/interface/ValidateRequest.php';
require 'library/uniweb/controller/AjaxController.php';
require 'modul/user/library/startup/admin.ugyfelkezeloStartup.php';
require 'modul/user/library/DocumentManager.php';
/**
 * @property User_UgyfelDokumentum_Model $_model Model
 */
class UserUgyfeldokumentum_Admin_Controller extends AjaxController
{
    protected $ajaxOnly = false;
    
    public function __run()
    {
        $this->__loadModel('_UgyfelDokumentum');
        parent::__run();
    }
    
    public function __show()
    {
        try {
            $getMethod = function($request) {
                return isset($request['method']) ? $request['method'] : null;
            };
            $getItem = function($data, $item, $default) {
                return isset($data[$item]) ? $data[$item] : $default;
            };
            $setContentType = function($contentType) {
                header_remove('Content-Type');
                header('Content-Type: ' . $contentType);
            };
            $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
            switch ($requestMethod) {
                case 'POST':
                    $request = filter_input_array(INPUT_POST);
                    $method = $this->isAjaxRequest() ? $getMethod($request) : null;
                    $setContentType('application/json');
                    switch ($method) {
                        case 'delete':
                            $documentId = $getItem($request, 'documentId', 0);
                            echo json_encode($this->_model->delete($documentId));
                            break;
                        case 'upload':
                            try {
                                $clientId = $getItem($request, 'clientId', 0);
                                if (isset($_FILES['file']) && is_array($_FILES['file']) &&  $clientId > 0) {
                                    $result = $this->_model->upload($_FILES['file'], $clientId);
                                    if ($result) {
                                        header('HTTP/1.0 200 OK');
                                        $json = array(
                                            'message' => 'Sikeres feltöltés!'
                                        );
                                    } else {
                                        throw new \Exception('A feltöltés sikertelen!');
                                    }
                                } else {
                                    throw new \Exception('A feltöltés sikertelen!');
                                }
                            } catch (\Exception $e) {
                                header('HTTP/1.0 500 Internal Server Error');
                                $json = array(
                                    'error' => 'A feltöltés sikertelen!'
                                );                                
                            }
                            echo json_encode($json);
                            break;
                        default:
                            throw new \Exception('Ismeretlen metódus!', 2);
                    }
                    break;
                case 'GET':
                    $request = filter_input_array(INPUT_GET);
                    $method = $getMethod($request);
                    switch ($method) {
                        case 'download':
                            $filename = $getItem($request, 'filename', null);
                            $this->_model->download($filename);
                            break;
                        case 'refresh':
                            try {
                                if (!$this->isAjaxRequest()) {
                                    throw new \Exception;
                                }
                                $setContentType('application/json');
                                $clientId = isset($request['clientId']) ? (int)$request['clientId'] : 0;
                                if ($clientId > 0) {
                                    $response = $this->_model->refresh($clientId);
                                } else {
                                    throw new \Exception;
                                }
                            } catch (\Exception $e) {
                                $response = array('result' => false, 'files' => array());
                            }
                            echo json_encode($response);
                            break;
                        default:
                            break;
                    }
                    break;
                default:
                    throw new \Exception('Ismeretlen metódus!', 2);
            }
            exit;
        } catch (\ErrorException $ee) {
            $this->_view->assign('message', $ee->getMessage());
            Rimo::$_site_frame->assign('Form', $this->__generateForm(
                'modul/user/view/admin.user_ugyfel_dokumentum.tpl'
            ));
        } catch (\Exception $e) {
            $this->invalidRequest();
        }
    }
}