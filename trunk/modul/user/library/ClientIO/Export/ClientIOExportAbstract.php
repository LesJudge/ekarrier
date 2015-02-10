<?php

abstract class ClientIOExportAbstract extends \ClientIO implements \ClientIOExportInterface
{
    /**
     * Konstruktor.
     * @param \PHPExcel $phpExcel Dokumentum objektum.
     * @param \SplObjectStorage $ioAttributes IO attribútumok.
     * @param \SplObjectStorage $clients Ügyfeleket tartalmazó objektum.
     * @param \ClientIOExportSourceManagerInterface $sourceManager Forráskezelő objektum.
     */
    public function __construct(
        \PHPExcel $phpExcel,
        \SplObjectStorage $ioAttributes,
        \SplObjectStorage $clients,
        \ClientIOExportSourceManagerInterface $sourceManager
    ) {
        parent::__construct($phpExcel, $ioAttributes);
        // Ügyfelek beállítása.
        $this->clients = $clients;
        // Forráskezelő inicializálása.
        $this->sourceManager = $sourceManager;
    }
    /**
     * Előkészíti a forrásokat, elkészíti a dokumentum header-jét, valamint beleírja az ügyfeleket.
     * @return \PHPExcel
     */
    public function export()
    {
        $this->phpExcel->setActiveSheetIndex(0);
        $this->addSources();
        $this->writeHeader();
        $this->writeClients();
        return $this->phpExcel;
    }
}