<?php
namespace Uniweb\Module\Ugyfel\Controller;
use Uniweb\Module\Ugyfel\Model\Document;
use Uniweb\Library\Mvc\Controller\SlimBasedController;
use Slim\Slim;
use Exception;

class DocumentController extends SlimBasedController
{
    /**
     * @param Slim $slim Slim objektum.
     */
    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }
    /**
     * Ügyfélhez tartozó dokumentumok lekérdezése.
     * @param int $id Ügyfél azonosító.
     */
    public function all($id)
    {
        $this->slim->response->headers->set('Content-Type', 'application/json');
        try {
            $document = new Document;
            $documents = $document->findAllByClientId($id);
            echo json_encode($documents);
        } catch (Exception $ex) {
            $this->slim->response->setStatus(404);
            $this->slim->response->setBody($ex->getMessage());
        }
        $this->stop();
    }
    /**
     * Dokumentum letöltése.
     * @param string $filename Dokumentum neve.
     */
    public function download($filename)
    {
        try {
            $document = new Document;
            $file = $document->download($filename);
            $this->slim->response->headers->set('Content-Type', 'application/octet-stream');
            $this->slim->response->headers->set('Content-Disposition', 'attachment; filename=' . basename($file));
            $this->slim->response->headers->set('Expires', 0);
            $this->slim->response->headers->set('Cache-Control', 'must-revalidate');
            $this->slim->response->headers->set('Pragma', 'public');
            $this->slim->response->headers->set('Content-Length', filesize($file));
            readfile($file);
        } catch (Exception $ex) {
            $this->slim->response->setStatus(404);
            $this->slim->response->setBody($ex->getMessage());
        }
        $this->stop();
    }
    /**
     * Dokumentum feltöltése az ügyfélhez.
     * @param int $clientId Ügyfél azonosító.
     */
    public function upload($clientId)
    {
        try {
            $file = isset($_FILES['file']) && is_array($_FILES['file']) ? $_FILES['file'] : array();
            $document = new Document;
            if ($document->upload($clientId, $file)) {
                echo json_encode(array('message' => 'Sikeresen feltöltötte a dokumentumot!'));
            } else {
                throw new Exception('A dokumentum feltöltése sikertelen!');
            }
        } catch (Exception $ex) {
            $this->slim->response->setStatus(500);
            $this->slim->response->setBody($ex->getMessage());
        }
        $this->stop();
    }
    /**
     * Dokumentum törlése.
     * @param string $filename Dokumentum neve.
     */
    public function destroy($filename)
    {
        $this->slim->response->headers->set('Content-Type', 'application/json');
        try {
            $document = new Document;
            $result = false;
            $message = 'A dokumentum törlése sikertelen!';
            if ($document->delete($filename)) {
                $result = true;
                $message = 'Sikeresen törölte a dokumentumot!';
            }
            echo json_encode(array('result' => $result, 'message' => $message));
        } catch (Exception $ex) {
            $this->slim->response->setStatus(404);
            $this->slim->response->setBody($ex->getMessage());
        }
        $this->stop();
    }
}