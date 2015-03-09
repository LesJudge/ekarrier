<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\Address;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\ComputerKnowledge;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\Education;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\Job;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\Knowledge;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\ProgramInformation;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\ServiceInterested;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\WorkSchedule;

class EditConfig
{    
    public function getConfig()
    {
        return array(
            'commentactivity' => new CreateByData,
            'commentclientinformation' => new CreateByData,
            'commentcontact' => new CreateByData,
            'commentdocument' => new CreateByData,
            'commenteducation' => new CreateByData,
            'commentjob' => new CreateByData,
            'commentlabormarket' => new CreateByData,
            'commentlogin' => new CreateByData,
            'commentpersonaldata' => new CreateByData,
            'commentproject' => new CreateByData,
            'commentprojectinformation' => new CreateByData,
            'employmentstatus' => new CreateByData,
            'jobcategory' => new CreateByData,
            'labormarket' => new CreateByData,
            'projectinformation' => new CreateByData,
            'status' => new CreateByData,
            'birthdata' => new CreateByData,
            'highesteducation' => new CreateByData,
            'addresses' => new Address,
            'documents' => new CreateByData,
            'contacts' => new CreateByData,
            'educations' => new Education,
            'knowledges' => new Knowledge,
            'computerknowledges' => new ComputerKnowledge,
            'services' => new ServiceInterested,
            'programinformations' => new ProgramInformation,
            'workschedules' => new WorkSchedule,
            'projects' => new CreateByData,
            'jobs' => new Job
        );
    }
}