<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\AbstractClientDataDecorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket as LaborMarketModel;

class LaborMarket extends AbstractClientDataDecorator
{
    protected $laborMarket;
    
    public function __construct(LaborMarketModel $laborMarket)
    {
        $this->laborMarket = $laborMarket;
    }
    
    public function getPalyakezdo($default = '')
    {
        return $this->getBitValue($this->laborMarket->get_palyakezdo(), $default);
    }
    
    public function getRegisztraltMunkanelkuli($default = '')
    {
        return $this->getBitValue($this->laborMarket->get_regisztralt_munkanelkuli(), $default);
    }
    
    public function getMikorRegisztralt($default = '')
    {
        $year = $this->laborMarket->mikor_regisztralt_ev;
        $month = $this->laborMarket->mikor_regisztralt_honap;
        $day = $this->laborMarket->mikor_regisztralt_nap;
        
        $date = '';
        
        if (!is_null($year)) {
            $date .= $year;
        }
        
        if (!is_null($month)) {
            $date .= '-' . ($month >= 10 ?: '0' . $month);
        }
        
        if (!is_null($day)) {
            $date .= '-' . ($day >= 10 ?: '0' . $day);
        }
        
        return $date != '' ?: $default;
    }
    
    public function getGyesGyedVisszatero($default = '')
    {
        return $this->getBitValue($this->laborMarket->get_gyes_gyed_visszatero(), $default);
    }
    
    public function getGyesGyedLejaratiDatum($default = '')
    {
        return $this->getValue($this->laborMarket->get_gyes_gyed_lejarati_datum(), $default);
    }
    
    public function getMegvaltozottMunkakepessegu($default = '')
    {
        return $this->getBitValue($this->laborMarket->get_megvaltozott_munkakepessegu(), $default);
    }
    
    public function getKovetkezoFelulvizsgalatIdeje($default = '')
    {
        return $this->getValue($this->laborMarket->get_kovetkezo_felulvizsgalat_ideje(), $default);
    }
    
    public function getDolgozik($default = '')
    {
        return $this->getBitValue($this->laborMarket->get_dolgozik(), $default);
    }
    
    public function getLaborMarket()
    {
        return $this->laborMarket;
    }
    
    public function setLaborMarket(LaborMarketModel $laborMarket)
    {
        $this->laborMarket = $laborMarket;
    }
}