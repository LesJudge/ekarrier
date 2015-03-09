<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\AbstractClientDataDecorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation as ProjectInformationModel;

class ProjectInformation extends AbstractClientDataDecorator
{
    protected $projectInformation;
    
    public function __construct(ProjectInformationModel $projectInformation)
    {
        $this->projectInformation = $projectInformation;
    }
    
    public function getEuProgElmKetEv($default = '')
    {
        return $this->getBitValue($this->projectInformation->get_eu_prog_elm_ket_ev(), $default);
    }
    
    public function getProjectInformation()
    {
        return $this->projectInformation;
    }
    
    public function setProjectInformation(ProjectInformationModel $projectInformation)
    {
        $this->projectInformation = $projectInformation;
    }
}