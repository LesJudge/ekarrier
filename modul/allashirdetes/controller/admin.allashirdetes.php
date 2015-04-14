<?php
//require 'page/admin/controller/admin.list.php';

class Allashirdetes_Admin_Controller extends Admin_List
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'AdminAllahirdetesList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * Controller inicializálása.
     */
    public function __construct()
    {
        $this->__loadModel('_List');
        parent::__construct();
        $this->__addEvent('BtnGenDoc', 'GenDoc');
        $this->__addEvent('BtnGenPdf', 'GenPdf');
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    /**
     * Render.
     */
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/allashirdetes/view/admin.allashirdetes_list.tpl')
        );
    }
    /**
     * Szűrő.
     */
    public function onClick_Filter()
    {
        $nameFilter = "megnevezes LIKE '%:item%' OR
                                      ismerteto LIKE '%:item%'";
        $this->setWhereInput($nameFilter, 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch ($filterStatus) {
            case 1:
                $this->setWhereInput('allashirdetes_aktiv = 1', 'FilterStatus');
                break;
            case 2:
                $this->setWhereInput('allashirdetes_aktiv = 0', 'FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
        // Cég filter
        $filterCeg = (int)$this->getItemValue('FilterCeg');
        if ($filterCeg) {
            $this->setWhereInput('c.ceg_id=' . $filterCeg, 'FilterCeg');
        } else {
            unset($_SESSION[$this->_name]['FilterCeg']);
        }
        // Ellenőrzött szűrő
        $filterEllenorzott = (int)$this->getItemValue('FilterMasHirdetes');
        switch ($filterEllenorzott) {
            case 1:
                $this->setWhereInput('ellenorzott = 1', 'FilterMasHirdetes');
                break;
            case 2:
                $this->setWhereInput('ellenorzott = 0', 'FilterMasHirdetes');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterMasHirdetes']);
                break;
        }
        // Egyedi szűrő
        $filterEgyedi = (int)$this->getItemValue('FilterEgyedi');
        switch ($filterEgyedi) {
            case 1:
                $this->setWhereInput('egyedi = 1', 'FilterEgyedi');
                break;
            case 2:
                $this->setWhereInput('egyedi = 0', 'FilterEgyedi');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterEgyedi']);
                break;
        }
        // Más hirdetése szűrő
        $filterMasHird = (int)$this->getItemValue('FilterMasHirdetes');
        switch ($filterMasHird) {
            case 1:
                $this->setWhereInput('mas_hirdetese = 1', 'FilterMasHirdetes');
                break;
            case 2:
                $this->setWhereInput('mas_hirdetese = 0', 'FilterMasHirdetes');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterMasHirdetes']);
                break;
        }
    }
    /**
     * Dokumentum generálás az adott álláshirdetésből.
     */
    public function onClick_GenDoc()
    {
        $eventKey = $this->_name . 'BtnGenDoc';
        if (
            !empty($this->_action_type)
            &&
            isset($this->_action_type[$eventKey])
            &&
            ($jobId = $this->_action_type[$eventKey]) > 0
        ) {
            $pathinfo = pathinfo(__DIR__);
            // Require dependencies.
            require 'page/admin/model/admin.edit_model.php';
            require 'modul/user_cim/model/UserAddressFinder.php';
            require $pathinfo['dirname'] . '/model/AllashirdetesBaseEditModel.php';
            require $pathinfo['dirname'] . '/model/allashirdetes_Edit_Model.php';
            require $pathinfo['dirname'] . '/model/allashirdetes_Site_Show_Model.php';
            require_once 'library/phpword/src/PhpWord/Autoloader.php';
            // Autoload PHPWord dependencies.
            \PhpOffice\PhpWord\Autoloader::register();
            // Fájl generálása.
            $file = Allashirdetes_Edit_Model::generateDocx($jobId);
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                unlink($file);
                exit;
            }
        } else {
            echo 'Invalid request!';
        }
    }
    
    public function onClick_GenPdf()
    {
        $eventKey = $this->_name . 'BtnGenPdf';
        if (
            !empty($this->_action_type)
            &&
            isset($this->_action_type[$eventKey])
            &&
            ($jobId = $this->_action_type[$eventKey]) > 0
        ) {
            require_once('library/MPDF/mpdf.php');
            $pathinfo = pathinfo(__DIR__);
            // Require dependencies.
            require 'page/admin/model/admin.edit_model.php';
            require 'modul/user_cim/model/UserAddressFinder.php';
            require $pathinfo['dirname'] . '/model/AllashirdetesBaseEditModel.php';
            require $pathinfo['dirname'] . '/model/allashirdetes_Edit_Model.php';
            require $pathinfo['dirname'] . '/model/allashirdetes_Site_Show_Model.php';
            $file = Allashirdetes_Edit_Model::downloadPdf($jobId);
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                unlink($file);
                exit;
            }
        }
    }
}