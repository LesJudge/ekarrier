<?php
namespace Uniweb\Module\Ugyfel\Controller;

use ActiveRecord\RecordNotFound;
use Rimo;
use Uniweb\Module\Ugyfel\Library\Export\Pdf\Client as ClientPdf;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;

class PdfExportController
{
    /**
     * @var ClientRepository
     */
    private $repository;
    
    /**
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Ügyfél exportálása .pdf-be.
     * @param int $id Ügyfél azonosító.
     */
    public function export($id)
    {
        try { 
            $clientPdf = new ClientPdf($this->repository->findById($id, true));
            $clientPdf->export()->Output();
            exit;
        } catch (RecordNotFound $ex) {
            Rimo::$_site_frame->assign('Form', '<div class="notice error"><p>A keresett ügyfél nem található!</p></div>');
        }
    }
    
    /**
     * Visszatér a repository objektummal.
     * @return ClientRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    /**
     * Beállítja a repository objektumot.
     * @param ClientRepository $repository Repository objektum.
     */
    public function setRepository(ClientRepository $repository)
    {
        $this->repository = $repository;
    }
}