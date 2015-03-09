<?php
namespace Uniweb\Module\Ugyfel\Model;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Project as ClientToProject;
use Uniweb\Module\Ugyfel\Library\Exceptions\ProjectCreatorException;
use Uniweb\Module\Projekt\Model\ActiveRecord\Project;
use Uniweb\Library\DynamicFilter\Exceptions\EmptyResultException;
use Exception;

class ProjectCreator
{
    const PROJECT_DATA_ERROR = 2;
    /**
     * @var Project
     */
    protected $project;
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client
     */
    protected $clients = array();
    
    public function __construct(Project $project, array $clients)
    {
        $this->project = $project;
        $this->clients = $clients;
    }
    
    public function create()
    {
        $connection = $this->project->connection();
        $connection->transaction();
        if (empty($this->clients)) {
            throw new EmptyResultException('Projektet csak akkor hozhat létre, ha a szűrés nem eredménytelen!');
        }
        if (!$this->project->is_valid()) {
            throw new ProjectCreatorException('Nem megfelelő projekt adatok!', self::PROJECT_DATA_ERROR);
        }
        if ($this->project->save(false)) {
            foreach ($this->clients as $client) {
                if (is_object($client) && $client instanceof \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client) {
                    $clientToProject = new ClientToProject;
                    $clientToProject->ugyfel_id = $client->ugyfel_id;
                    $clientToProject->projekt_id = $this->project->projekt_id;
                    try {
                        if (!$clientToProject->save()) {
                            throw new Exception;
                        }
                    } catch (Exception $ex) {
                        throw new ProjectCreatorException('Az ügyfelet nem sikerült a projekthez kapcsolni!');
                    }
                } else {
                    throw new ProjectCreatorException('Az ügyfelet nem sikerült a projekhez kapcsolni!');
                }
            }
            $connection->commit();
        } else {
            throw new ProjectCreatorException('A projekt mentése sikertelen!');
        }
    }
    
    public function getProject()
    {
        return $this->project;
    }
}