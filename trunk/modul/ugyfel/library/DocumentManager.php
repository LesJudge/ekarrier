<?php
class DocumentManager
{
    /**
     * ClientDocument objektum.
     * @var \ClientDocument
     */
    protected $file;
    /**
     * SplFileInfo objektum.
     * @var \SplFileInfo
     */
    protected $path;
    /**
     * Könyvtár elérési útja.
     * @var string
     */
    protected $directory = 'modul/ugyfel/upload/';
    
    const DEFAULT_RIGHTS = 0544;
    
    public function __construct($file)
    {
        $this->file = $file;
        $path = new \SplFileInfo($this->directory);
        if (file_exists($this->directory) && $path->isDir() && $path->isReadable()) {
            $this->path = $path;
        } else {
            throw new \Exception('Nem megfelelő vagy nem olvasható útvonal!');
        }
    }
    /**
     * Beállítja a könyvtár jogosultságát.
     * @param int $rights Jogosultsági érték.
     * @throws \Exception
     */
    protected function setRights($rights)
    {
        if (!chmod($this->directory, $rights)) {
            throw new \Exception;
        }
    }
    /**
     * Megvizsgálja, hogy megfelelő-e a dokumentum.
     * @return boolean
     */
    public function isInstance()
    {
        return is_object($this->file) && $this->file instanceof \ClientDocument;
    }
    /**
     * Feltölti a fájlt a szerverre, valamint létrehozza a rekordot az adatbázisban.
     * @param array $file
     * @return boolean
     */
    public function upload(array $file)
    {
        if ($this->isInstance() && $this->file->is_new_record()) {
            /* @var $conn \ActiveRecord\Connection */
            $conn = $this->file->connection();
            try {
                $conn->transaction(); // Tranzakció indítása.
                $this->setRights(0744); // Írási jogot ad a könyvtárnak.
                $this->uploadFile($file); // Feltölti a fájlt.
                $this->setRights($this->getDefaultRights()); // Csak olvashatóvá teszi a könyvtárat.
                $conn->commit(); // Commit.
                return true;
            } catch (\Exception $e) {
                // Ha hiba lépne fel, akkor is olvashatóvá teszi a könyvtárat.
                $this->setRights($this->getDefaultRights());
                $conn->rollback(); // Majd rollbackel.
                return false;
            }
        }
        return false;
    }
    /**
     * Feltölti a fájlt a szerverre.
     * @param array $file
     * @return boolean
     * @throws \Exception
     */
    protected function uploadFile(array $file)
    {
        if ($this->file->save() && move_uploaded_file($file['tmp_name'], $this->directory . $this->file->nev)) {
            return true;
        }
        throw new \Exception('A feltöltés sikertelen!');
    }
    /**
     * Fájl letöltése.
     * @throws \Exception
     */
    public function download()
    {
        $filename = $this->directory . $this->file->nev;
        if ($this->path->isReadable() && file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($this->file->dokumentum_nev));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        } else {
            throw new \Exception('A letöltés sikertelen!');
        }
    }
    /**
     * Törli a fájlt a szerverről és az adatbázisból.
     * @return boolean
     */
    public function delete()
    {
        if ($this->isInstance() && !$this->file->is_new_record()) {
            /* @var $conn \ActiveRecord\Connection */
            $conn = $this->file->connection();
            try {
                $conn->transaction();
                $this->setRights(0744);
                $filename = $this->directory . $this->file->nev;
                $this->deleteFile($filename);
                $conn->commit();
                $this->setRights($this->getDefaultRights());
                return true;
            } catch (\Exception $e) {
                $this->setRights($this->getDefaultRights());
                $conn->rollback();
                return false;
            }
        }
        return false;
    }
    /**
     * Törli a paraméterül adott fájlt a szerverről.
     * @param string $filename Fájl neve.
     * @throws \Exception
     */
    protected function deleteFile($filename)
    {
        $delete = $this->file->delete();
        $result = file_exists($filename) ? $delete && unlink($filename) : $delete;
        if ($result) {
            return true;
        }
        throw new \Exception('A törlés sikertelen!');
    }
    /**
     * Visszatér az alapértelmezett könyvtár jogokkal.
     * @return int
     */
    public function getDefaultRights()
    {
        return self::DEFAULT_RIGHTS;
    }
    /**
     * Visszatér a könyvtár elérési útjával.
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }
}