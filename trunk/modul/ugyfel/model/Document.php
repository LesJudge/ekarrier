<?php
namespace Uniweb\Module\Ugyfel\Model;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Document as DocumentAr;
use Uniweb\Module\Ugyfel\Library\DocumentManager;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Exception;

class Document
{
    /**
     * Törli az ügyfélhez tartozó dokumentumot.
     * @param string $name Dokumentum neve.
     * @return boolean
     * @throws Exception
     */
    public function delete($name)
    {
        $document = DocumentAr::find('first', array('conditions' => array(
            'nev' => $name,
            'ugyfel_attr_dokumentum_aktiv' => 1,
            'ugyfel_attr_dokumentum_torolt' => 0
        )));
        if (!is_null($document)) {
            $dm = new DocumentManager($document);
            return $dm->delete();
        }
        throw new Exception('A keresett dokumentum nem található!');
    }
    /**
     * 
     * @param string $filename Fájlnév.
     * @throws Exception
     */
    public function download($filename)
    {
        $cd = DocumentAr::find('first', array('conditions' => array(
            'nev' => $filename,
            'ugyfel_attr_dokumentum_aktiv' => 1,
            'ugyfel_attr_dokumentum_torolt' => 0
        )));
        if (!is_null($cd)) {
            $dm = new DocumentManager($cd);
            return $dm->download();
        } else {
            throw new Exception('A keresett dokumentum nem található!');
        }
    }
    /**
     * Feltölti a paraméterül adott dokumentumot.
     * @param int $clientId Ügyfél azonosító.
     * @param array $file Dokumentum adatai.
     * @return boolean
     */
    public function upload($clientId, $file)
    {
        if (isset($file['name'])) {
            $cd = new DocumentAr;
            $cd->dokumentum_nev = $file['name'];
            $cd->ugyfel_id = $clientId;
            $dm = new DocumentManager($cd);
            return $dm->upload($file);
        } else {
            throw new Exception('Hiba a dokumentum feltöltése során!');
        }
    }
    /**
     * Lekérdezi az ügyfélhez tartozó összes dokumentumot.
     * @param int $clientId Ügyfél azonosító.
     * @return array
     * @throws Exception
     */
    public function findAllByClientId($clientId)
    {
        /* @var $client \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client */
        $clientRepo = new ClientRepository;
        $client = $clientRepo->findById($clientId);
        if (!is_null($client)) {
            $documents = $client->documents;
            $files = array();
            /* @var $document \Uniweb\Module\Ugyfel\Model\ActiveRecord\Document */
            foreach ($documents as $document) {
                $file = $document->to_array(array(
                    'only' => array(
                        DocumentAr::$primary_key,
                        'ugyfel_id',
                        'nev',
                        'dokumentum_nev'
                    ),
                )) + $document->creator->to_array(array('only' => array(
                    'user_id', 'user_fnev', 'user_knev', 'user_vnev'
                )));
                $file['letrehozas_timestamp'] = $document->letrehozas_timestamp;
                $files[] = $file;
            }
            return array('result' => true, 'files' => $files);
        }
        throw new Exception('A keresett ügyfél nem található!');
    }
}