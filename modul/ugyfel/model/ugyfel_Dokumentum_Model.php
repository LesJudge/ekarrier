<?php

class Ugyfel_Dokumentum_Model
{
    /**
     * Törli az ügyfélhez tartozó dokumentumot.
     * @param int $documentId Dokumentum azonosító.
     * @return array
     */
    public function delete($documentId)
    {
        try {
            if ((int)$documentId > 0) {
                $dm = new \DocumentManager(ClientDocument::find($documentId));
                $result = $dm->delete();
                return array(
                    'result' => $result,
                    'message' => $result ? 'Sikeresen törölte a dokumentumot!' : 'A dokumentum törlése sikertelen!'
                );
            } else {
                throw new \ActiveRecord\RecordNotFound('A keresett dokumentum nem található!');
            }
        } catch (\ActiveRecord\RecordNotFound $rnf) {
            return array(
                'result' => false,
                'message' => 'A keresett dokumentum nem található!'
            );
        }
    }
    /**
     * 
     * @param type $filename
     * @throws \Exception
     */
    public function download($filename)
    {
        $cd = \ClientDocument::find('first', array('conditions' => array('nev' => $filename)));
        if (!is_null($filename) && !is_null($cd)) {
            $dm = new \DocumentManager($cd);
            $dm->download();
        } else {
            throw new \ErrorException('A keresett fájl nem található!');
        }
    }
    /**
     * Feltölti a paraméterül adott dokumentumot.
     * @param array $file Dokumentum adatai.
     * @param int $clientId Ügyfél azonosító.
     * @return boolean
     */
    public function upload(array $file, $clientId)
    {
        try {
            $cd = new \ClientDocument;
            $cd->dokumentum_nev = $file['name'];
            $cd->ugyfel_id = $clientId;
            $dm = new \DocumentManager($cd);
            return $dm->upload($file);
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * Lekérdezi az ügyfélhez tartozó összes dokumentumot.
     * @param int $clientId Ügyfél azonosító.
     * @return array
     */
    public function refresh($clientId)
    {
        $documents = ClientDocument::find('all', array(
            'conditions' => array('ugyfel_id' => $clientId), 'include' => array('creator')
        ));
        $files = array();
        /* @var $document ClientDocument */
        foreach ($documents as $document) {
            $files[] = $document->to_array(array(
                'only' => array(
                    ClientDocument::$primary_key,
                    'ugyfel_id',
                    'nev',
                    'dokumentum_nev',
                    'letrehozas_timestamp'
                )
            )) + $document->creator->to_array(array('only' => array(
                'user_id', 'user_fnev', 'user_knev', 'user_vnev'
            )));
        }
        return array(
            'result' => true,
            'files' => $files
        );
    }
}