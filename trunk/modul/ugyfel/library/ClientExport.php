<?php

class ClientExport implements ClientIOExportElementInterface
{
    /**
     * Ügyfél.
     * @var \Client
     */
    protected $client;
    /**
     * Konstruktor.
     * @param \Client $client
     */
    public function __construct(\Client $client)
    {
        $this->client = $client;
    }
    /**
     * Alapértelmezett get metódus.
     * @param string $attribute Attribútum neve.
     * @param mixed $soure Forrás.
     * @throws \ClientIOExportException
     */
    public function getIOAttribute($attribute, $soure = null)
    {
        throw new \ClientIOExportException('Definiáld a/az ' . (string)$attribute . ' get() metódusát!');
    }
    /**
     * Alapértelmezett set metódus.
     * @param string $attribute Attribútum neve.
     * @param mixed $value Attribútum értéke.
     * @throws \ClientIOExportException
     */
    public function setIOAttribute($attribute, $value)
    {
        throw new \ClientIOExportException('Definiáld a/az ' . (string)$attribute . ' set() metódusát!');
    }
    /**
     * Visszatér az ügyfél objektummal.
     * @return \Client
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * Visszatér az ügyfél státuszával.
     * @return mixed
     */
    public function getIOAttributeStatus()
    {
        return $this->client->clientdatastatus->aktualis_statusz;
    }
    /**
     * Visszatér az ügyfél nemével.
     * @return mixed
     */
    public function getIOAttributeGender()
    {
        $nem = $this->client->nem;
        switch ($nem) {
            case 'male':
                return 'Férfi';
                break;
            case 'female':
                return 'Nő';
                break;
            default:
                return 'Nincs megadva';
                break;
        }
    }
    /**
     * Visszatér az ügyfél nevével.
     * @return string
     */
    public function getIOAttributeName()
    {
        return $this->client->user_vnev . ' ' . $this->client->user_knev;
    }
    /**
     * Visszatér az ügyfél születési (leánykori) nevével.
     * @return mixed
     */
    public function getIOAttributeBirthname()
    {
        return $this->client->clientdata->szuletesi_nev;
    }
    /**
     * Visszatér az ügyfél születési helyével.
     * @return mixed
     */
    public function getIOAttributeBirthplace()
    {
        return $this->client->clientdata->szuletesi_hely;
    }
    /**
     * Visszatér az ügyfél születési idejével.
     * @return mixed
     */
    public function getIOAttributeBirthdate()
    {
        return $this->client->clientdata->readDateTimeAttribute('szuletesi_ido');
    }
    
    public function getIOAttributeMothersName()
    {
        return $this->client->clientdata->anyja_neve;
    }
    
    public function getIOAttributeZipCode()
    {
        return 'Irányítószám';
    }
    
    public function getIOAttributeCity()
    {
        return $this->client->clientdata->city->cim_varos_nev;
    }
    
    public function getIOAttributeStreet()
    {
        return 'Utca';
    }
    
    public function getIOAttributeHouseNumber()
    {
        return 'Házszám';
    }
    
    public function getIOAttributeCounty()
    {
        return $this->client->clientdata->county->cim_megye_nev;
    }
    
    public function getIOAttributePhone1()
    {
        return $this->client->clientdata->telefonszam_vezetekes;
    }
    
    public function getIOAttributePhone2()
    {
        return $this->client->clientdata->telefonszam_mobil1;
    }
    
    public function getIOAttributePhone3()
    {
        return $this->client->clientdata->telefonszam_mobil2;
    }
    
    public function getIOAttributeEmail()
    {
        return $this->client->user_email;
    }
    
    public function getIOAttributeHighestEducation()
    {
        return 'Legmagasabb iskolai végzettség';
    }
    
    public function getIOAttributeRegmunka()
    {
        return $this->bitValueToString($this->client->labormarket->regisztralt_munkanelkuli);
    }
    
    public function getIOAttributePalyakezdo()
    {
        return $this->bitValueToString($this->client->labormarket->palyakezdo);
    }
    
    public function getIOAttributeMegvmunka()
    {
        return $this->bitValueToString($this->client->labormarket->megvaltozott_mkepessegu);
    }
    
    public function getIOAttributeGyesgyed()
    {
        return $this->bitValueToString($this->client->labormarket->gyes_gyed_visszatero);
    }
    
    public function getIOAttributeUnios2ev()
    {
        return $this->bitValueToString($this->client->projectinformation->eu_prog_elm_ket_ev);
    }
    
    public function getIOAttributeHazai2ev()
    {
        return $this->bitValueToString($this->client->projectinformation->hazai_prog_elm_ket_ev);
    }
    /**
     * 
     * @param \ProgramInformation $programInformation Program információ objektum.
     */
    public function getIOAttributeProgramInformation($programInformation)
    {
        return $programInformation->program_informacio_nev;
    }
    
    public function getIOSourceProgramInformation()
    {
        return $this->client->programinformations;
    }
    
    public function getIOAttributeAllkerkarrpont()
    {
        return '???';
    }

    public function getIOAttributeMunkapcs()
    {
        return '???';
    }

    public function getIOAttributeTelassz()
    {
        return '???';
    }

    public function getIOAttributeVallval()
    {
        return '???';
    }

    public function getIOAttributeAllaskulcs()
    {
        return $this->bitValueToString($this->client->projectinformation->kk_trening_resztvett);
    }
    
    public function getIOAttributePsziszoc()
    {
        return '???';
    }
    
    public function getIOAttributeGrafologia()
    {
        return $this->bitValueToString($this->client->projectinformation->graf_elemz_resztvett);
    }
    
    public function getIOAttributeAllaskertan()
    {
        return '???';
    }
    
    public function getIOAttributePszichtan()
    {
        return $this->bitValueToString($this->client->projectinformation->pszich_tanad_resztvett);
    }
    
    public function getIOAttributeJogitan()
    {
        return $this->bitValueToString($this->client->projectinformation->jogi_tadas_resztvett);
    }
    
    public function getIOAttributeKepzesitan()
    {
        return $this->bitValueToString($this->client->projectinformation->kepz_tanad_resztvett);
    }
    
    public function getIOAttributeMunkatan()
    {
        return $this->bitValueToString($this->client->projectinformation->munka_tanad_resztvett);
    }
    
    public function getIOAttributeEgyuttmukprog()
    {
        return $this->bitValueToString($this->client->projectinformation->egy_megall_ktttnk_prog);
    }
    
    public function getIOAttributeEgyuttmukkepzes()
    {
        return $this->bitValueToString($this->client->projectinformation->egy_megall_ktttnk_kepz);
    }
    /**
     * Visszatér a szolgáltatás nevével.
     * @param \Service $service
     */
    public function getIOAttributeSzolgaltatas($service)
    {
        return $service->szolgaltatas_nev;
    }
    /**
     * Visszatér az ügyfelet érdeklő szolgáltatásokkal.
     * @return \Services[]
     */
    public function getIOSourceSzolgaltatas()
    {
        return $this->client->services;
    }
    
    public function getIOAttributeKapcsfel()
    {
        return '???';
    }
    /**
     * Visszatér az ügyfél iskolai végzettségének nevével.
     * @param \UserEducation $education
     */
    public function getIOAttributeEducation($education)
    {
        return $education->user_attr_vegzettseg_iskola;
    }
    /**
     * Visszatér az ügyfélhez tartozó végzettségekkel.
     * @return mixed
     */
    public function getIOSourceEducation()
    {
        return $this->client->educations;
    }
    /**
     * Visszatér a "nyelvtudás nyelvével".
     * @param \UserKnowledge $knowledge Nyelvtudás objektum.
     * @return mixed
     */
    public function getIOAttributeLanguage($knowledge)
    {
        return $knowledge->language->nyelvtudas_nyelv_nev;
    }
    /**
     * Visszatér az ügyfélhez tartozó nyelvtudásokkal.
     * @return mixed
     */
    public function getIOSourceLanguage()
    {
        return $this->client->knowledges;
    }
    /**
     * 
     * @param \UserKnowledge $knowledge
     * @return mixed
     */
    public function getIOAttributeNyelvvizsgatipus($knowledge)
    {
        return $knowledge->level->nyelvtudas_szint_nev;
    }
    
    public function getIOAttributeKategoria($kategoria)
    {
        return '???';
    }
    
    public function getIOSourceKategoria()
    {
        return array(0, 1, 2, 3, 4);
    }
    /**
     * 
     * @param \Job $job
     * @return mixed
     */
    public function getIOAttributeBetolt($job)
    {
        return $job->munkakor_nev;
    }
    
    public function getIOSourceBetolt()
    {
        return $this->client->jobs;
    }
    
    public function getIOAttributeHozzajarul()
    {
        return $this->bitValueToString($this->client->projectinformation->hozjarul_munkakozv);
    }
    
    public function getIOAttributeMobilitas()
    {
        return $this->bitValueToString($this->client->projectinformation->mobilitast_vallal);
    }
    /**
     * 
     * @param \WorkSchedule $workSchedule
     * @return mixed
     */
    public function getIOAttributeMunkarend($workSchedule)
    {
        return $workSchedule->munkarend_nev;
    }
    
    public function getIOSourceMunkarend()
    {
        return $this->client->workschedules;
    }
    
    public function getIOAttributeMunkakorkategoria()
    {
        return '???';
    }
    
    public function getIOAttributeMunkaallapot()
    {
        return '???';
    }
    
    public function getIOAttributeOnline()
    {
        return '???';
    }
    
    public function getIOAttributeMegjegyzes()
    {
        return '???';
    }
    /**
     * Visszatér a BIT mező értékének string megfelelőjével.
     * @param mixed $value Érték.
     * @return string
     */
    protected function bitValueToString($value)
    {
        return is_null($value) ? 'ismeretlen adat' : ($value) ? 'Igen' : 'Nem';
    }
}