<?php
require 'modul/user_cim/model/UserAddressFinder.php';
require 'library/uniweb/JsonHelper.php';
/**
 * @property User_cim_Finder_Model $_model
 */
class User_cimIrszamkeresoAjax_Site_Controller extends RimoController
{

    public $_name = 'IrszamKeresoAjax';

    public function __construct()
    {
        $this->__run();
    }
    public function __show()
    {
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            &&
            isset($_REQUEST['term'])
        ) {
            $json = false;
            $result = UserAddressFinder::model()->findLocationByZipCode($_REQUEST['term'], false);
            if ($result) {
                $json = array();
                foreach ($result as $location) {
                    $merge = array(
                        'label' => $location['iranyitoszam'] . ' - ' . $location['varos'] . ' - ' . $location['megye'],
                        'value' => $location['iranyitoszam']
                    );
                    $json[] = array_merge($location, $merge);
                }
            }
            echo json_encode($json);
            exit;
        } else {
            throw new Exception_404;
        }
    }
}