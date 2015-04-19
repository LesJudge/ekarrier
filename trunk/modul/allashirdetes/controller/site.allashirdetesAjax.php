<?php

class AllashirdetesAjax_Site_Controller extends RimoController
{
    const ACTION_INDEX = 'action';
    public $_name = 'AjaxAllashirdetes';
    
    public function __construct()
    {
        $this->__run();
        exit;
    }
    
    public function __show()
    {
        if (isset($_REQUEST[self::ACTION_INDEX])) {
            $action = 'action' . $_REQUEST[self::ACTION_INDEX];
            if (method_exists($this, $action)) {
                call_user_func(array($this, $action));
            }
        }
    }
    
    protected function actionFindexpsandtasks()
    {
        $result = array(
            'elvarasok' => array(),
            'feladatok' => array()
        );
        if (isset($_POST['jobIds']) && is_array($_POST['jobIds']) && !empty($_POST['jobIds'])) {
            require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
            require 'modul/allashirdetes/model/allashirdetes_Edit_Model.php';
            $aem = new Allashirdetes_Edit_Model;
            $result['elvarasok'] = $aem->findAllElvaras($_POST['jobIds']);
            $result['feladatok'] = $aem->findAllFeladat($_POST['jobIds']);
        }
        echo json_encode($result);
    }
    
    protected function actionJobpreview()
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        if (isset($_GET['jobId']) && ($jobId = (int)$_GET['jobId']) > 0) {
            // Class dependencies.
            require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
            require 'modul/allashirdetes/model/allashirdetes_Edit_Model.php';
            require 'modul/allashirdetes/model/allashirdetes_Site_Show_Model.php';
            //require 'library/MPDF/mpdf.php';
            //require 'library/mpdf/mpdf/mpdf.php';
            try {
                $preview = Allashirdetes_Edit_Model::generatePdfPreview($jobId);

                var_dump($preview);

                $thumbnail = $preview->getImageBlob();
                echo "<img src='data:image/jpg;base64,".base64_encode($thumbnail)."' />";
            } catch (\UnexpectedValueException $uve) {
                echo $uve->getMessage();
            }
        } else {
            
        }
    }
}