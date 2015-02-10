<?php
require 'library/uniweb/interface/ValidateRequest.php';
require 'library/uniweb/controller/AjaxController.php';
require 'modul/ugyfel/library/startup/admin.ugyfelkezeloStartup.php';
/**
 * Esetnapló AJAX controller.
 */
class UgyfelEsetnaplo_Admin_Controller extends \AjaxController
{
    const MSG_FATAL_ERROR = 'Végzetes hiba lépett fel a művelet során!';
    /**
     * Megjelenítés.
     */
    public function __show()
    {
        try {
            header_remove('Content-Type');
            header('Content-Type: application/json');
            $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
            switch ($requestMethod) {
                case 'GET':
                    $request = filter_input_array(INPUT_GET);
                    break;
                case 'POST':
                    $request = filter_input_array(INPUT_POST);
                    break;
                default:
                    throw new Exception('Nem megfelelő kérés!', 1);
            }
            /* @var $method string */
            $method = isset($request['method']) ? $request['method'] : null;
            switch ($method) {
                case 'create':
                    $data = isset($request['ClientContact']) && is_array($request['ClientContact']) 
                        ? $request['ClientContact'] 
                        : array();
                    echo json_encode($this->create($data));
                    break;
                case 'delete':
                    $contactId = isset($request['contactId']) ? $request['contactId'] : 0;
                    if ($contactId > 0) {
                        $result = $this->delete($contactId);
                    } else {
                        $result = array(
                            'result' => false,
                            'message' => 'A bejegyzés törlése sikertelen!'
                        );
                    }
                    echo json_encode($result);
                    break;
                case 'refresh':
                    $clientId = (int)filter_input(INPUT_GET, 'clientId');
                    $result = array(
                        'result' => false,
                        'contacts' => array(),
                        'message' => 'A keresett ügyfél nem található!'
                    );
                    if ($clientId > 0) {
                        $result = $this->refresh($clientId);
                    }
                    echo json_encode($result);
                    break;
                default:
                    throw new \Exception('Ismeretlen metódus!', 1);
            }
        } catch (\Exception $e) {
            $this->invalidRequest(false, $e->getCode() == 1 ? $e->getMessage() : 'Ismeretlen hiba!');
        }
        exit;
    }
    /**
     * Menti a felhasználóhoz az esetnapló bejegyzést.
     * @param array $data Esetnapló adatokat tartalmazó tömb.
     * @return array
     */
    public function create(array $data)
    {
        try {
            $cc = new \ClientContact($data);
            return array(
                'result' => $cc->save(),
                'message' => $cc->errors->get_raw_errors()
            );
        } catch (\Exception $e) {
            return array(
                'result' => false,
                'message' => self::MSG_FATAL_ERROR
            );
        }
    }
    /**
     * Törli az esetnapló bejegyzést azonosító alapján.
     * @param int $contactId Esetnapló azonosító.
     * @return array
     */
    public function delete($contactId)
    {
        try {
            /* @var $cc ClientContact */
            $cc = ClientContact::find($contactId);
            $cc->ugyfel_attr_esetnaplo_torolt = 1;
            $result = $cc->save();
            return array(
                'result' => $result,
                'message' => $result ? '' : 'A törlés sikertelen!'
            );
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            return array(
                'result' => false,
                'message' => 'A keresett bejegyzés nem található!'
            );
        }
    }
    /**
     * Ügyfél azonosító alapján lekérdezi az összes aktív, nem törölt esetnapló bejegyzést.
     * @param int $clientId Ügyfél azonosító.
     * @return array
     */
    public function refresh($clientId)
    {
        $scope = ClientContact::scopeActiveNotDeletedByClient($clientId) + array('include' => array('creator', 'type'));
        $contacts = ClientContact::find('all', $scope);
        $result = array();
        foreach ($contacts as $contact) {
            $result[] = $contact->to_array(array(
                'only' => array('ugyfel_attr_esetnaplo_id', 'megjegyzes', 'felvetel_ideje', 'letrehozas_timestamp', 
                    'letrehozo_id'
                )
            )) + $contact->creator->to_array(array(
                'only' => array('user_id', 'user_vnev', 'user_knev', 'user_fnev')
            )) + $contact->type->to_array(array(
                'only' => array('nev')
            ));
        }
        return array(
            'result' => true,
            'contacts' => $result,
            'message' => ''
        );
    }
    /**
     * Nem teljesíthető kérés esetén lefutó metódus.
     */
    public function invalidRequest()
    {
        $args = func_get_args();
        $getArgument = function($key, $default) use ($args) {
            return isset($args[$key]) ? $args[$key] : $default;
        };
        echo json_encode(array(
            'result' => $getArgument(0, false),
            'message' => $getArgument(1, self::MSG_FATAL_ERROR)
        ));
    }
}