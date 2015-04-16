<?php
namespace Uniweb\Module\Ugyfel\Library\Export\Pdf;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client as ClientModel;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\BirthData as BirthDataDecorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\LaborMarket as LaborMarketDecorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\ProjectInformation as ProjectInformationDecorator;
use Uniweb\Module\Ugyfel\Library\Facade\Form\OptionsFacade;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapServices;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapProgramInformations;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapWorkSchedules;
use Rimo;
use mPDF;
use ReflectionClass;
use ArrayObject;

class Client
{
    protected $client;
    
    public function __construct(ClientModel $client)
    {
        $this->client = $client;
    }
    
    public function export()
    {
        /* @var $smarty \Smarty */
        $smarty = Rimo::$pimple['smarty'];
        $smarty->assign('domain', Rimo::$_config->DOMAIN);
        $smarty->assign('date', date('Y.m.d'));
        // Aláhúzás osztályok.
        $smarty->assign('underlineClasses', array("" => "no-underline", 0 => "underline-no", 1 => "underline-yes"));
        // Ügyfél objektum.
        $smarty->assign('client', $this->client);
        // Születési adatok decorator.
        $smarty->assign('birthdataDecorator', new BirthDataDecorator($this->client->birthdata));
        // Cím decorator.
        $reflector = new ReflectionClass('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Decorator\\Address');
        //$smarty->assign('addressDecorator', $reflector->newInstanceWithoutConstructor());
        $smarty->assign('addressDecorator', $reflector->newInstance());
        // Munkaerőpiaci helyzete decorator.
        $smarty->assign('laborMarketDecorator', new LaborMarketDecorator($this->client->labormarket));
        // Projektinformáció decorator.
        $smarty->assign(
            'projectInformationDecorator', new ProjectInformationDecorator($this->client->projectinformation)
        );
        $options = new ArrayObject;
        $optionsFacade = new OptionsFacade(Rimo::$pimple['gregwarCacheAdapter']);
        $optionsFacade->assign($options);
        // Végzettség típusok.
        $smarty->assign('educationTypes', $options->offsetGet('beallitasEducations'));
        // Ügyfél végzettségei.
        $educations = array();
        foreach ($this->client->educations as $education) {
           $educations[] = $education->vegzettseg_id; 
        }
        $smarty->assign('educations', $educations);
        // Szolgáltatások.
        $mapServices = new MapServices($options->offsetGet('szolgaltatasServices'), $this->client->services);
        $smarty->assign('services', $mapServices->map());
        // Programinformációk.
        $mapProgramInformations = new MapProgramInformations($options->offsetGet('beallitasProgramInformation'), $this->client->programinformations);
        $smarty->assign('programInformations', $mapProgramInformations->map());
        // Munkarendek.
        $mapWorkschedules = new MapWorkSchedules($options->offsetGet('beallitasWorkSchedule'), $this->client->workschedules);
        $smarty->assign('workschedules', $mapWorkschedules->map());
        // .pdf létrehozása.
        $mPdf = new mPDF;
        $mPdf->WriteHTML($smarty->fetch('modul/ugyfel/Assets/Pdf/ClientPdfTemplate.tpl'));
        return $mPdf;
    }
}