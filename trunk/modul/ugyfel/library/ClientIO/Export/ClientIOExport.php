<?php

class ClientIOExport extends ClientIOExportAbstract implements ClientIOExportInterface
{
    /**
     * Ügyfelek.
     * @var \SplObjectStorage
     */
    protected $clients;
    /**
     * Forráskezelő.
     * @var \ClientIOExportSourceManagerInterface
     */
    protected $sourceManager;
    /**
     * Konstruktor.
     * @param \PHPExcel $phpExcel Dokumentum objektum.
     * @param \SplObjectStorage $ioAttributes IO attribútumok.
     * @param \SplObjectStorage $clients Ügyfeleket tartalmazó objektum.
     * @param \ClientIOExportSourceManagerInterface $sourceManager Forráskezelő objektum.
     * @throws \ClientIOExportException
     */
    public function __construct(
        \PHPExcel $phpExcel,
        \SplObjectStorage $ioAttributes,
        \SplObjectStorage $clients,
        \ClientIOExportSourceManagerInterface $sourceManager
    ) {
        parent::__construct($phpExcel, $ioAttributes, $clients, $sourceManager);
        foreach ($clients as $client) {
            if (!$this->validateClient($client)) {
                throw new \ClientIOExportException('Az ügyfél nem megfelelő!');
            }
        }
    }
    /**
     * Elkészíti a dokumentum header-jét.
     */
    public function writeHeader()
    {
        $col = 0;
        $row = 1;
        $this->iterate('ioAttributes', function(\ClientIOExport $self, \ClientIOAttributeInterface $attribute) use (
            &$col, &$row
        ) {
            $self->writeHeaderItem($attribute, $col, $row);
        });
    }
    /**
     * A dokumentum header-jébe írja a paraméterül adott elemet, a megadott oszlopba és sorba.
     * @param \ClientIOAttributeInterface $attribute Attribútum.
     * @param int $col Oszlop kezdete.
     * @param int $row Sor kezdete.
     */
    public function writeHeaderItem($attribute, &$col, &$row)
    {
        if ($attribute->isMultiple()) {
            $length = $this->getSourceManager()->getSourceLength($attribute->getName());
            for ($i = 0; $i < $length; $i++) {
               $this->getPhpExcel()->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $attribute->getLabel());
               $col++;
            }                
        } else {
            $this->getPhpExcel()->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $attribute->getLabel());
            $col++;
        }
    }
    /**
     * Beleírja a dokumentumba az ügyfeleket.
     */
    public function writeClients()
    {
        $col = 0; // Alapértelmezett oszlop.
        $row = 2; // Alapértelmezett sor.        
        // Kurzorok visszaállítása az elejére.
        $this->clients->rewind();
        $this->ioAttributes->rewind();
        // Ügyfelek bejárása.
        while ($this->clients->valid()) {
            /* @var $client \ClientExport */
            $client = $this->clients->current(); // Aktuális ügyfél.
            while ($this->ioAttributes->valid()) {
                $attribute = $this->ioAttributes->current(); // Aktuális attribútum.
                $this->writeClient($attribute, $client, $col, $row);
                $this->ioAttributes->next();
            }
            $row++;
            $col = 0;
            $this->ioAttributes->rewind();
            $this->clients->next();
        }
    }
    /**
     * Beleírja az ügyfele a dokumentumba.
     * @param \ClientIOAttributeInterface $attribute Attribútum.
     * @param \ClientIOExportElementInterface $client Ügyfél.
     * @param int $col Oszlop.
     * @param int $row Sor.
     */
    public function writeClient($attribute, $client, &$col, &$row)
    {
        $isDefaultMethod = $attribute->getGetter() == $this->getDefaultGetter();
        if ($attribute->isMultiple()) {
            $clientId = $client->getClient()->user_id;
            $sourceName = $attribute->getName();
            $source = $this->getSourceManager()->getSource($sourceName);
            $clientSource = isset($source[$clientId]) ? $source[$clientId]->getData() : array();
            $length = $this->getSourceManager()->getSourceLength($sourceName);
            for ($i = 0; $i < $length; $i++) {
                $value = '';
                if (isset($clientSource[$i])) {
                    $method = $attribute->getGetter();
                    if ($isDefaultMethod) {
                        $value = call_user_func(
                            array($client, $this->getDefaultGetter()), $attribute->getName(), $clientSource[$i]
                        );
                    } else {
                        $value = call_user_func(array($client, $attribute->getGetter()), $clientSource[$i]);
                    }
                }
                $this->phpExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $col--;
        } else {
            if ($isDefaultMethod) {
                $value = call_user_func(array($client, $this->getDefaultGetter()), $attribute->getName());
            } else {
                $value = call_user_func(array($client, $attribute->getGetter()));
            }
           $this->phpExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        }
        $col++;
    }
    /**
     * Források hozzáadása a forráskezelőhöz.
     */
    public function addSources()
    {
        $this->iterate('ioAttributes', function(\ClientIOExport $self, \ClientIOAttributeInterface $attribute) {
            if ($attribute->isMultiple()) {
                $self->iterate('clients', function($self, $client) use ($attribute) {
                    $self->getSourceManager()->addSource(
                        $attribute->getName(),
                        $client->getClient()->user_id, 
                        call_user_func(array($client, $attribute->getSourceMethod()))
                    );
                });
            }
        });
    }
    /**
     * Megvizsgálja, hogy az ügyfél objektum megfelelő-e.
     * @param mixed $client
     * @return boolean
     */
    public function validateClient($client)
    {
        return is_object($client) && $client instanceof \ClientExport;
    }
    /**
     * Visszatér az ügyfelekkel.
     * @return \SplObjectStorage
     */
    public function getClients()
    {
        return $this->clients;
    }
    /**
     * Visszatér a forráskezelővel.
     * @return \ClientIOExportSourceManagerInterface
     */
    public function getSourceManager()
    {
        return $this->sourceManager;
    }
}