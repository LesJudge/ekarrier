<?php
namespace Uniweb\Module\Ugyfel\Library;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Document;
use SplFileInfo;
use Exception;

class DocumentManager
{
    /**
     * ClientDocument objektum.
     * @var Document
     */
    protected $file;
    /**
     * SplFileInfo objektum.
     * @var SplFileInfo
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
        $path = new SplFileInfo($this->directory);
        if (file_exists($this->directory) && $path->isDir() && $path->isReadable()) {
            $this->path = $path;
        } else {
            throw new Exception('Hiba lépett fel a dokumentumkezelő inicializálása során!');
        }
    }
    /**
     * Beállítja a könyvtár jogosultságát.
     * @param int $rights Jogosultsági érték.
     * @throws Exception
     */
    protected function setRights($rights)
    {
        if (!chmod($this->directory, $rights)) {
            throw new Exception;
        }
    }
    /**
     * Megvizsgálja, hogy megfelelő-e a dokumentum.
     * @return boolean
     */
    public function isInstance()
    {
        return is_object($this->file) && $this->file instanceof Document;
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
            } catch (Exception $e) {
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
     * @throws Exception
     */
    protected function uploadFile(array $file)
    {
        if (
            $this->file->save() && move_uploaded_file($file['tmp_name'], $this->directory . $this->file->dokumentum_nev
        )) {
            return true;
        }
        throw new Exception('A feltöltés sikertelen!');
    }
    /**
     * Fájl letöltése.
     * @return string Fájlnév
     * @throws Exception
     */
    public function download()
    {
        $filename = $this->directory . $this->file->dokumentum_nev;
        if ($this->path->isReadable() && file_exists($filename)) {
            return $filename;
        } else {
            throw new Exception('A letöltés sikertelen!');
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
                //$this->setRights(0744);
                //$filename = $this->directory . $this->file->dokumentum_nev;
                //$this->deleteFile($filename);
                $this->file->ugyfel_attr_dokumentum_torolt = 1;
                $this->file->save();
                $conn->commit();
                //$this->setRights($this->getDefaultRights());
                return true;
            } catch (Exception $e) {
                //$this->setRights($this->getDefaultRights());
                $conn->rollback();
                return false;
            }
        }
        return false;
    }
    /**
     * Törli a paraméterül adott fájlt a szerverről.
     * @param string $filename Fájl neve.
     * @throws Exception
     */
    protected function deleteFile($filename)
    {
        $this->file->torolt = 1;
        $delete = $this->file->save();
        $result = file_exists($filename) ? $delete && unlink($filename) : $delete;
        if ($result) {
            return true;
        }
        throw new Exception('A törlés sikertelen!');
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