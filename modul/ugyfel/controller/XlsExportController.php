<?php
namespace Uniweb\Module\Ugyfel\Controller;

use Rimo;
use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;
use Uniweb\Library\DynamicFilter\Exceptions\EmptyResultException;
use Uniweb\Library\DynamicFilter\Exceptions\FactoryException;
use Uniweb\Library\DynamicFilter\Factory;
use Uniweb\Library\DynamicFilter\FilterSetup;
use Uniweb\Library\Flash\Flash;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;
use Uniweb\Module\Ugyfel\Library\Xls\XlsExport;
use Uniweb\Module\Ugyfel\Library\Xls\XlsExportException;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client as ClientModel;

class XlsExportController
{
    /**
     * @var ClientFilter
     */
    private $filter;
    
    /**
     * @var Flash
     */
    private $flash;
    
    /**
     * @param ClientFilter $filter Ügyfél szűrő objektum.
     * @param Flash $flash Flash objektum.
     */
    public function __construct(ClientFilter $filter, Flash $flash)
    {
        $this->filter = $filter;
        $this->flash = $flash;
    }
    
    /**
     * Export
     */
    public function export()
    {
        if (!is_null($this->filter->read())) {
            try {
                $post = filter_input_array(INPUT_POST);
                if (isset($post['xlsexport'])) {
                    $exportKeys = array_keys($post['xlsexport']);
                    $config = Rimo::$pimple['clientXlsExportConfig'];
                    $exportConfig = array();
                    // Exportálandó attribútumok ellenőrzése, előkészítése.
                    foreach ($exportKeys as $exportKey) {
                        if (isset($config[$exportKey])) {
                            $exportConfig[] = $config[$exportKey];
                        } else {
                            throw new XlsExportException('Nem megfelelő attribútum azonosító!');
                        }
                    }
                    // Szűrés.
                    $filterSetup = new FilterSetup(
                        $this->filter, 
                        new Factory(ClientModel::connection()->connection), 
                        Rimo::$pimple['clientFilterConfig']
                    );
                    $filterSetup->setUp($this->filter->read());
                    $clients = $this->filter->filter();
                    // Ügyfelek adatainak exportálása .xls-be.
                    $xlsExport = new XlsExport($clients, $exportConfig);
                    //$xls = $xlsExport->export();
                    $xlsExport->export();
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=export.xlsx');
                    //readfile($xls);
                    exit;
                } else {
                    $this->flash->setFlash('error', 'Nem váltasztott ki exportálandó attribútumot!');
                }
            } catch (XlsExportException $xee) {
                $this->flash->setFlash('error', $xee->getMessage());
            } catch (EmptyResultException $ere) {
                $this->flash->setFlash('error', $ere->getMessage());
            } catch (DynamicFilterException $dfe) {
                $this->flash->setFlash('error', $dfe->getMessage());
            } catch (FilterException $fe) {
                $this->flash->setFlash('error', $fe->getMessage());
            } catch (FactoryException $fex) {
                $this->flash->setFlash('error', $fex->getMessage());
            }
        } else {
            $this->flash->setFlash('error', 'Szűrés nélkül nem exportálhat!');
        }
        
        header('Location: ' . Rimo::$_config->DOMAIN_ADMIN . 'ugyfel');
        exit;
    }
}