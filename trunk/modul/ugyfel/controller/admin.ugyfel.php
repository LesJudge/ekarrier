<?php
// Admin List
include_once 'page/admin/controller/admin.list.php';
// Smarty plugins.
require 'library/uniweb/smarty/plugins/function.dynamic_filter_checkboxes.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_radios.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_select.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_text.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_text_date.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_text_int.php';
require 'library/uniweb/smarty/plugins/function.dynamic_filter_text_like.php';
// Flash
require 'library/uniweb/Flash.php';
// Dynamic Filter
require 'library/uniweb/DynamicFiltersController.php';
require 'library/uniweb/DynamicFiltersModel.php';
// Ügyfélkezelő startup.
require 'modul/ugyfel/library/startup/admin.ugyfelkezeloStartup.php';
// User cím
require 'modul/user_cim/model/ar/UserAddress.php';
/**
 * 
 * @property Smarty $_view Smarty View.
 */
class Ugyfel_Admin_Controller extends \DynamicFiltersController
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'UgyfelList';
    /**
     * Nyelvesített-e a controller.
     * @var string
     */
    public $_multiple_lang = false;
    /**
     * Flash kezelés
     * @var \Flash
     */
    protected $flash;
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        $this->__loadModel('_List');
        parent::__construct();
        $this->flash = new Flash($_SESSION, Rimo::$_config->ugyfelFlashKey);
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnExport', 'Export');
        $this->__addEvent('BtnProject', 'Project');
        $this->__run();
    }
    /**
     * runParams.
     */
    public function __runParams()
    {
        /**
         * Sajnos máshogy nem lehetett megoldani, hogy az 'Item' értéke megmaradjon, ugyanis a '__runParams()'-ban 
         * valami mesterien felülkeni a több dimenziós tömb értékeit üres stringre.
         * 
         * Kapott kommentet a kód, hogy mit, miért, hogyan...
         */
        $model = &$this->_model; // Model változóban tárolása. Sokszor fogom használni, és nem írom ki, hogy $this.
        $prefix = $model->dynamicFiltersPrefix(); // Dinamikus szűrő prefix.
        // Beállítja az 'Item'-ek értékeit. Van, amelyiknek sikerül, és olyan is, amelyiknek nem. Ha nem, akkor 
        // segíteni kell neki!  Az ok, amiért nem lett felülkenve az egész metódus: Egyáltalán nem SOLID az egész 
        // controller, csak még nagyobb spagetti kódot és kavarodást okozna az egész.
        parent::__runParams();
        switch (filter_input(INPUT_SERVER, 'REQUEST_METHOD')) {
            // Ha GET kérés.
            case 'GET':
                // Megvizsgálja, hogy van-e kiválasztott nyelvtudás szint. (Bármelyik nyelvből, ezért több dimenziós 
                // eleve a tömb...)
                if (isset($_SESSION[$this->_name]['ugyfelDfNyelvtudasSzint'])) {
                    $index = $prefix . 'NyelvtudasSzint';
                    // Ha igen, felülírja az 'Item' értékét.
                    $model->_params[$index]->_value = $_SESSION[$this->_name][$index];
                }
                break;
            // Ha POST kérés.
            case 'POST':
                $key = $model->getSessionKey() . $prefix;
                // Closure, ami beállítja az 'Item' értékét.
                $get = function($itemName) use ($key) {
                    $index = $key . $itemName;
                    return isset($_POST[$index]) && is_array($_POST[$index]) ? $_POST[$index] : array();
                };
                $model->_params[$prefix . 'NyelvtudasNyelv']->_value = $get('NyelvtudasNyelv');
                $model->_params[$prefix . 'NyelvtudasSzint']->_value = $get('NyelvtudasSzint');
                $model->_params[$prefix . 'NyelvtudasMind']->_value = isset($_POST[$key . 'NyelvtudasMind']);                
                break;
            default:
                break;
        }
    }
    /**
     * Dinamikus szűrők beállítása.
     * @return void
     */
    protected function setDynamicFilters()
    {
        $name = $this->_name;
        $eventsExecuted = $this->_runned_event;
        $binds = array(
            'Firstname' => array(
                'field' => 'ugyfel.keresztnev',
                'method' => 'Like'
            ),
            'Lastname' => array(
                'field' => 'ugyfel.vezeteknev',
                'method' => 'Like'
            ),
            'Nickname' => array(
                'field' => 'user.user_fnev',
                'method' => 'Like'
            ),
            'Email' => array(
                'field' => 'ugyfel.email',
                'method' => 'Like'
            ),
            'Phone' => array(
                'field' => 'ugyfel.telefonszam_vezetekes',
                'method' => 'Like'
            ),
            'PhoneMobile1' => array(
                'field' => 'ugyfel.telefonszam_mobil1',
                'method' => 'Like'
            ),
            'Lakcim' => array(
                'field' => 'uu.lakcim',
                'method' => 'Like'
            ),
            'BirthLastname' => array(
                'field' => 'uasza.szuletesi_vezeteknev',
                'method' => 'Like'
            ),
            'BirthFirstname' => array(
                'field' => 'uasza.szuletesi_keresztnev',
                'method' => 'Like'
            ),
            'Birthdate' => array(
                'field' => 'uasza.szuletesi_ido',
                'method' => 'Date'
            ),
            'BirthplaceCountry' => array(
                'field' => 'uasza.szuletesi_hely_orszag_id',
                'method' => 'Like'
            ),
            'BirthplaceCity' => array(
                'field' => 'uasza.szuletesi_hely_varos_id',
                'method' => 'Like'
            ),
            'MikorReg' => array(
                'field' => 'umh.mikor_regisztralt',
                'method' => 'Date'
            ),
            'GyesGyedLejarDatum' => array(
                'field' => 'umh.gyes_gyed_lejar_datum',
                'method' => 'Date'
            ),
            'KovFelulvDatum' => array(
                'field' => 'umh.kov_felulv_date',
                'method' => 'Date'
            ),
            'VegzettsegIskola' => array(
                'field' => 'uav.ugyfel_attr_vegzettseg_iskola',
                'method' => 'Like'
            ),
            'VegzettsegKezdes' => array(
                'field' => 'uav.ugyfel_attr_vegzettseg_kezdet',
                'method' => 'Date'
            ),
            'VegzettsegVegzes' => array(
                'field' => 'uav.ugyfel_attr_vegzettseg_veg',
                'method' => 'Date'
            ),
            'VegzettsegSzak' => array(
                'field' => 'uav.ugyfel_attr_vegzettseg_szak',
                'method' => 'Like'
            )
        );
        foreach ($binds as $key => $value) {
            $this->setDynamicFilterViaClosure($key, function($filter, $model) use ($value) {
                call_user_func(array($model, 'add' . $value['method'] . 'Condition'), $filter, $value['field']);
            });
        }
        // Nem szűrő
        $this->setDynamicFilter('Nem', 'ugyfel.nem = \'{value}\'');
        // Állapot szűrő
        $this->setDynamicFilter('Allapot', 'ugyfel.user_allapot_id = {value}');
        // Hírlevél szűrő
        $this->setDynamicFilter('Newsletter', 'user.user_hirlevel = \'{value}\'');
        // Aktív szűrő
        $this->setDynamicFilter('Active', 'user.user_aktiv = \'{value}\'');
        // Munkavégzést korlátozó egyéb okok szűrő.
        $this->setDynamicFilter('MvegzesKeok', 'umh.mvegzes_keok = \'{value}\'');
        // Pályakezdő szűrő.
        $this->setDynamicFilter('Palyakezdo', 'umh.palyakezdo = {value}');
        // Regisztrált munkanélküli szűrő.
        $this->setDynamicFilter('Regmunkanelk', 'umh.regisztralt_munkanelkuli = {value}');
        // GYES-GYED visszatérő szűrő.
        $this->setDynamicFilter('GyesGyedVisszatero', 'umh.gyes_gyed_visszatero = {value}');
        // Megváltozott munkaképességű szűrő.
        $this->setDynamicFilter('MegvMkep', 'umh.megvaltozott_mkepessegu = {value}');
        // Dolgozik szűrő.
        $this->setDynamicFilter('Dolgozik', 'umh.dolgozik = {value}');
        // EU-s program szűrő.
        $this->setDynamicFilter('EuProgElmKetEv', 'up.eu_prog_elm_ket_ev = {value}');
        // Hazai program szűrő.
        $this->setDynamicFilter('HazaiProgElmKetEv', 'up.hazai_prog_elm_ket_ev = {value}');
        // Közvetítői adatbázisba került szűrő.
        $this->setDynamicFilter('KozAdatbKerul', 'up.koz_adatb_kerul = {value}');
        // Hozzájárul a munkakövzetítéshez szűrő.
        $this->setDynamicFilter('HozzajarulMunkakozv', 'up.hozjarul_munkakozv = {value}');
        // Mobilitást vállal-e szűrő.
        $this->setDynamicFilter('MobilitastVallal', 'up.mobilitast_vallal = {value}');
        // KK Tréning szűrő.
        $this->setDynamicFilter('KkTreningResztvett', 'up.kk_trening_resztvett = {value}');
        // Grafológiai elemzés szűrő.
        $this->setDynamicFilter('GrafElemzResztvett', 'up.graf_elemz_resztvett = {value}');
        // Jogi tanácsadáson résztvett-e szűrő.
        $this->setDynamicFilter('JogiTadasResztvett', 'up.jogi_tadas_resztvett = {value}');
        // Képzés tanácsadáson résztvett-e szűrő.
        $this->setDynamicFilter('KepzTanadResztvett', 'up.kepz_tanad_resztvett = {value}');
        // Munka tanácsadáson résztvett-e szűrő.
        $this->setDynamicFilter('MunkaTanadResztvett', 'up.munka_tanad_resztvett = {value}');
        // Pszichológiai tanácsadáson résztvett-e szűrő.
        $this->setDynamicFilter('PszichTanadResztvett', 'up.pszich_tanad_resztvett = {value}');
        // Együttműködési megállapodás programról szűrő.
        $this->setDynamicFilter('EgyMegallKtttnkProg', 'up.egy_megall_ktttnk_prog = {value}');
        // Együttműködési megállapodás képzésről szűrő.
        $this->setDynamicFilter('EgyMegallKtttnkKepz', 'up.egy_megall_ktttnk_kepz = {value}');
        // Melyik képzésbe került be szűrő.
        $this->setDynamicFilter('KepzesBekerult', 'up.kepzes_bekerult = {value}');
        // Hova érkezett szűrő.
        $this->setDynamicFilter('HovaErkezett', 'up.hova_erkezett_id = {value}');
        // Nyelvtudás - Nyelv szerinti szűrés
        $this->setDynamicFilterViaClosure('NyelvtudasNyelv', function($filter, $model) use ($eventsExecuted, $name) {
            if ($eventsExecuted == 0) {
                $prefix = $model->dynamicFiltersPrefix();
                $langs = $model->getItemValue($prefix . 'NyelvtudasNyelv');
                $levels = $model->getItemValue($prefix . 'NyelvtudasSzint');
                $all = (boolean)$model->getItemValue($prefix . 'NyelvtudasMind');
                $levelIds = array_keys($model->getDynamicFilter('NyelvtudasSzint')->_select_value);
                if (!empty($langs)) {
                    $str = '';
                    foreach ($langs as $langId) {
                        $createFrom = isset($levels[$langId]) ? $levels[$langId] : $levelIds;
                        foreach ($createFrom as $levelId) {
                            $str .= '(' . (int)$langId . ',' . (int)$levelId . '),';
                        }
                    }
                    $in = rtrim($str, ',');
                    $model->_join .= ' INNER JOIN ugyfel_attr_nyelvtudas un ON ugyfel.ugyfel_id IN (SELECT un.ugyfel_id 
                        FROM ugyfel_attr_nyelvtudas un
                        WHERE (un.nyelvtudas_nyelv_id, un.nyelvtudas_szint_id) IN (' . $in . ') 
                        GROUP BY un.ugyfel_id' . ($all ? 
                            ' HAVING COUNT(un.nyelvtudas_nyelv_id) >= ' . count($langs) : 
                        '') . ') ';
                    $_SESSION[$name][$prefix . 'NyelvtudasNyelv'] = $langs;
                    $_SESSION[$name][$prefix . 'NyelvtudasSzint'] = $levels;
                    $_SESSION[$name][$prefix . 'NyelvtudasMind'] = $all;
                }
            }
        });
        $this->setDynamicFilterViaClosure('SzIsmeret', function($filter, $model) use ($eventsExecuted, $name) {
            if ($eventsExecuted == 0) {
                try {
                    $prefix = $model->dynamicFiltersPrefix();
                    $cks = array_values($model->getDynamicFilter('SzIsmeret')->_value);
                    $likes = array_values($model->getDynamicFilter('SzIsmeretLike')->_value);
                    $all = (boolean)$model->getDynamicFilter('SzIsmeretMind')->_value;
                    $ccks = count($cks);
                    $clikes = count($likes);
                    if (is_array($cks) && is_array($likes) && ($ccks == $clikes) && $ccks > 0) {
                        $join = ' INNER JOIN ugyfel_attr_szgep_ismeret uasi ON ugyfel.ugyfel_id IN (SELECT ugyfel_id 
                            FROM ugyfel_attr_szgep_ismeret WHERE ';
                        $i = 0;
                        $str = '';
                        foreach ($cks as $ck) {
                            $str .= ' ismeret LIKE \'' . mysql_real_escape_string($model->createLike($ck, $likes[$i])) . '\' OR ';
                            $i++;
                        }
                        $join .= rtrim($str, ' OR ');
                        $join .= ' GROUP BY ugyfel_id ';
                        if ($all) {
                            $join .= 'HAVING COUNT(ismeret) >= ' . $ccks;
                        }
                        $join .= ') ';
                        $model->_join .= $join;
                        $model->_params[$prefix . 'SzIsmeretMind']->_value = $all;
                        $_SESSION[$name][$prefix . 'SzIsmeret'] = $cks;
                        $_SESSION[$name][$prefix . 'SzIsmeretLike'] = $likes;
                        $_SESSION[$name][$prefix . 'SzIsmeretMind'] = $all;
                    } else {
                        throw new \Exception;
                    }
                } catch (\Exception $e) {
                    throw new \Exception_Form_Error('Nem megfelelő számítógépes ismeret szűrési feltételek!');
                }                
            }
        });
        // Végzettség - Szint
        $this->setDynamicFilterViaClosure('VegzettsegSzint', function($filter, $model) {
            $model->addDynamicFilterCondition($filter, 'uav.vegzettseg_id IN (' . implode(',', $filter->_value) . ')');
        });
        // Program információ szűrő
        $this->setDynamicFilterViaClosure('ProgramInformacio', function($filter, $model) use ($eventsExecuted) {
            if ($eventsExecuted == 0) {
                $model->_join .= ' INNER JOIN ugyfel_attr_program_informacio uapi ON ugyfel.ugyfel_id = uapi.ugyfel_id ';
                $model->addDynamicFilterCondition(
                    $filter, 'uapi.program_informacio_id IN (' . implode(',', $filter->_value) . ')'
                );
            }
        });
        // Munkarend szűrő
        $this->setDynamicFilterViaClosure('Munkarend', function($filter, $model) use ($eventsExecuted) {
            if ($eventsExecuted == 0) {
                $model->_join .= ' INNER JOIN ugyfel_attr_munkarend uam ON ugyfel.ugyfel_id = uam.ugyfel_id ';
                $model->addDynamicFilterCondition(
                    $filter, 'uam.munkarend_id IN(' . implode(',', $filter->_value) . ')'
                );
            }
        });
    }
    /**
     * Render.
     */
    public function __show()
    {
        parent::__show();
        $exportConfig = require 'modul/ugyfel/config/admin.clientIO.config.php';
        $this->_view->assign('exportAttributes', $exportConfig['attributes']);
        if ($this->flash->hasFlash('clientNotFound')) {
            $this->_view->assign('FormError', $this->flash->getFlash('clientNotFound'));
        }
        $this->_view->assign('exportNameXls', $this->_name . $this->_params['TxtExportXls']->_name);
        $this->_view->assign('opIntEqual', Ugyfel_List_Model::OP_INT_EQUAL);
        $this->_view->assign('opIntGreaterThan', Ugyfel_List_Model::OP_INT_GREATER_THAN);
        $this->_view->assign('opIntGreaterThanOrEqual', Ugyfel_List_Model::OP_INT_GREATER_THAN_OR_EQUAL);
        $this->_view->assign('opIntLessThan', Ugyfel_List_Model::OP_INT_LESS_THAN);
        $this->_view->assign('opIntLessThanOrEqual', Ugyfel_List_Model::OP_INT_LESS_THAN_OR_EQUAL);
        $this->_view->assign('opLikeAnywhere', Ugyfel_List_Model::OP_LIKE_ANYWHERE);
        $this->_view->assign('opLikeEqual', Ugyfel_List_Model::OP_LIKE_EQUAL);
        $this->_view->assign('opLikePost', Ugyfel_List_Model::OP_LIKE_POST);
        $this->_view->assign('opLikePre', Ugyfel_List_Model::OP_LIKE_PRE);
        $this->_view->assign('opSqlBetween', Ugyfel_List_Model::OP_SQL_BETWEEN);
        $this->_view->assign('client', new \Client);
        $this->_view->assign('ClientBirthData', new \ClientBirthData);
        $this->_view->assign('ClientDataStatus', new \ClientDataStatus);
        $this->_view->assign('laborMarket', new \LaborMarket);
        $this->_view->assign('projectInformation', new \ProjectInformation);
        $this->_view->assign('userEducation', new \UserEducation);
        $this->_view->addPluginsDir('library/uniweb/smarty/plugins/');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Checkboxes');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Radios');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Select');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Text');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Text_Date');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Text_Int');
        $this->_view->loadPlugin('Smarty_Function_Dynamic_Filter_Text_Like');
        $this->_view->assign('intLabels', array(
            'opIntEqual' => 'egyenlő',
            'opIntLessThan' => 'kisebb',
            'opIntLessThanOrEqual' => 'kisebb, vagy egyenlő',
            'opIntGreaterThan' => 'nagyobb',
            'opIntGreaterThanOrEqual' => 'nagyobb, vagy egyenlő'
        ));
        $this->_view->assign('dateLabels', array(
            'opIntEqual' => 'ban/ben',
            'opIntLessThan' => 'előtt',
            'opIntLessThanOrEqual' => 'előtt, vagy az évben',
            'opIntGreaterThan' => 'után',
            'opIntGreaterThanOrEqual' => 'után, vagy az évben'
        ));
        $this->_view->assign('cknowledgesAc', json_encode(array_values(array_unique(ArHelper::result2Options(
            UcKnowledge::findAllActiveNotDeleted(), 'ugyfel_attr_szgep_ismeret_id', 'ismeret')
        ))));
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ugyfel/view/admin.ugyfel_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        parent::onClick_Filter();
        $this->setWhereInput("ugyfel.vezeteknev LIKE '%:item%' OR  ugyfel.keresztnev  LIKE '%:item%'", 'FilterSzuro');
        /*
        if ($this->getItemValue('FilterStatus') == 1) {
            $this->setWhereInput('user_aktiv=1 AND user_megerositve=1', 'FilterStatus');
        }
        elseif ($this->getItemValue("FilterStatus") == 2) {
            $this->setWhereInput('user_aktiv=0 OR user_megerositve=0', 'FilterStatus');
        }
        else {
            unset($_SESSION[$this->_name]['FilterStatus']);
        }
        */
    }
    /**
     * Projekt létrehozása.
     * @throws \Exception
     */
    public function onClick_Project()
    {
        // Megfelelő header beállítása.
        header_remove('Content-Type');
        header('Content-Type: application/json');
        try {
            if (isset($_POST['name']) && strlen($_POST['name']) > 2) {
                // Szűrés az ügyfelekre.
                $this->onClick_Filter();
                $this->_model->__createWhere();
                $data = $this->_model->__loadList();
                require 'page/admin/model/admin.edit_model.php';
                require 'modul/projekt/model/projekt_Edit_Model.php';
                $pem = new Projekt_Edit_Model;
                $pem->__addForm();
                foreach ($data as $client) {
                    $clientIds[$client['ID']] = null;
                }
                $pem->_params['TxtNev']->_value = htmlspecialchars(trim($_POST['name']));
                $pem->_params['TxtMegjegyzes']->_value = $clientIds;
                $pem->_params['ChkAktiv']->_value = 1;
                $pem->__insert();
                $response = array(
                    'result' => true,
                    'message' => 'Sikeresen létrehozta a projektet!'
                );
            } else {
                throw new \Exception('A névnek legalább 3 karakter hosszúnak kell lennie!', 1);
            }
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            $response = array('result' => false, 'message' => 'A szűrés nem adott vissza eredményt!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            $message = $e->getCode() == 1 ? $e->getMessage() : 'A projekt név már foglalt! Válasszon másikat!';
            $response = array('result' => false, 'message' => $message);
        }
        echo json_encode($response);
        exit;
    }
    /**
     * Ügyfél export.
     * @throws \Exception
     */
    public function onClick_Export()
    {
        // Szükséges állományok betöltése.
        require 'modul/ugyfel/library/startup/admin.clientIOStartup.php'; // ClientIO
        require 'modul/ugyfelmo/library/ClientExport.php'; // Ügyfél export.
        require 'library/Excel/PHPExcel.php';
        $attributes = $this->_params['TxtExportXls']->_value;
        if (is_array($attributes) && !empty($attributes)) {
            try {
                // Ügyfelek lekérdezése.
                $this->onClick_Filter();
                $this->_model->__createWhere();
                $data = $this->_model->__loadList();
                // Ügyfelek.
                $clients = new \SplObjectStorage;
                foreach ($data as $client) {
                    $clients->attach(new \ClientExport(Client::find($client['ID'])));
                }
                // Export konfiguráció.
                $exportConfig = require 'modul/ugyfel/config/admin.clientIO.config.php';
                // Új ügyfél export objektum.
                $clientIOExport = new ClientIOExport(
                    new \PHPExcel,
                    new \SplObjectStorage,
                    $clients,
                    new \ClientIOExportSourceManager
                );
                $clientIOExport->setAttributes($exportConfig['attributes']);
                $clientIOExport->setDefaultGetter($exportConfig['defaultGetter']);
                $clientIOExport->setDefaultSetter($exportConfig['defaultSetter']);
                $clientIOExport->setUpIoAttributes(array_keys($attributes));
                $xls = $clientIOExport->export();
                $file = '/tmp/' . time() . '.xlsx';
                $writer = new PHPExcel_Writer_Excel2007($xls);
                $writer->save($file);
                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename=' . basename($file));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    readfile($file);
                }
                exit;
            } catch (\ClientIOExportException $cioee) {
                echo $cioee->getMessage();
            } catch (\ClientIOException $cioe) {
                echo $cioe->getMessage();
            } catch (\Exception_MYSQL_Null_Rows $emnr) {
                //echo '<pre>', print_r($emnr, true), '</pre>';
                //exit;
                //throw new \Exception('Nincs exportálható ügyfél');
                $this->_view->assign('FormError', 'Error');
            }
        } else {
            throw new \Exception('Nem megfelelő attribútumok');
        }
    }
}