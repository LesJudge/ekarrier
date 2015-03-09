<?php
namespace Uniweb\Module\Ugyfel\Model;
use PDO;

class Statistics
{
    /**
     * @var PDO
     */
    protected $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function programInformations()
    {
        $statement = $this->pdo->prepare('SELECT 
            pi.program_informacio_id, pi.nev, COUNT(uapi.program_informacio_id) as cnt
        FROM program_informacio pi
        LEFT JOIN ugyfel_attr_program_informacio uapi ON pi.program_informacio_id = uapi.program_informacio_id 
        AND uapi.ugyfel_attr_program_informacio_torolt = 0
        GROUP BY pi.program_informacio_id;');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPdo()
    {
        return $this->pdo;
    }
    
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}