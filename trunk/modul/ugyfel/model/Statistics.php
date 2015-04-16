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
    
    public function countClients()
    {
        $statement = $this->pdo->prepare('SELECT COUNT(ugyfel_id) as cnt FROM ugyfel WHERE ugyfel_torolt = 0');
        $statement->execute();
        return (int)$statement->fetchColumn(0);
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
    
    public function workschedules()
    {
        $statement = $this->pdo->prepare('SELECT 
            m.munkarend_id,
            m.nev,
            COUNT(uam.munkarend_id) as cnt
        FROM
            munkarend m
                LEFT JOIN
            ugyfel_attr_munkarend uam ON m.munkarend_id = uam.munkarend_id
                AND uam.ugyfel_attr_munkarend_torolt = 0
        GROUP BY m.munkarend_id;');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function educations()
    {
        $statement = $this->pdo->prepare('SELECT 
            v.vegzettseg_id,
            v.nev,
            COUNT(uav.vegzettseg_id) as cnt
        FROM
            vegzettseg v
                LEFT JOIN
            ugyfel_attr_vegzettseg uav ON v.vegzettseg_id = uav.vegzettseg_id
                AND uav.ugyfel_attr_vegzettseg_torolt = 0
        GROUP BY v.vegzettseg_id;');
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