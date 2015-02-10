<?php

class ClientIOExportSourceManager implements \ClientIOExportSourceManagerInterface
{
    /**
     * Források.
     * @var array
     */
    protected $sources = array();
    /**
     * Hozzáad a forrásokhoz egy új forrást.
     * @param string $name Forrás neve.
     * @param int $clientId Ügyfél azonosító.
     * @param mixed $source Forrás.
     */
    public function addSource($name, $clientId, $source)
    {
        $this->sources[$name][$clientId] = new \ClientIOExportSource($name, $source);
    }
    /**
     * Megvizsgálja, hogy a forrás létezik-e.
     * @param string $source Forrás neve.
     * @return boolean
     */
    public function isSourceExists($source)
    {
        return isset($this->sources[$source]);
    }
    /**
     * Visszatér a kért forrással, ha az létezik.
     * @param string $source Forrás neve.
     * @param boolean $validate Validáljon-e. [optional]
     * @return mixed
     * @throws ClientIOExportException
     */
    public function getSource($source, $validate = true)
    {
        if ($validate === true || isset($this->sources[$source])) {
            return $this->sources[$source];
        } else {
            throw new ClientIOExportException;
        }
    }
    /**
     * Visszatér a forrás hosszával.
     * @param string $source Forrás neve.
     * @return int
     * @throws \ClientIOExportException
     */
    public function getSourceLength($source)
    {
        $data = $this->getSource($source);
        $max = 0;
        foreach ($data as $d) {
            $count = count($d);
            if ($count > $max) {
                $max = $count;
            }
        }
        return $max;
    }
    /**
     * Visszatér a forrásokkal.
     * @return array
     */
    public function getSources()
    {
        return $this->sources;
    }
}