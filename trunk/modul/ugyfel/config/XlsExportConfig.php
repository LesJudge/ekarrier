<?php
return array(
    'status' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Status',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Státusz',
        'key' => 'status'        
    ),
    'clientId' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ClientId',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Ügyfélazonosító',
        'key' => 'uazon'        
    ),
    'gender' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Gender',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Neme',
        'key' => 'neme'        
    ),
    'firstname' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Firstname',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Keresztnév',
        'key' => 'keresztnev'
    ),
    'lastname' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Lastname',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Vezetéknév',
        'key' => 'vezeteknev'
    ),
    'birthLastname' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Birthdata\\Lastname',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Születési vezetéknév',
        'key' => 'szulveznev'
    ),
    'birthFirstname' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Birthdata\\Firstname',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Születési keresztnév',
        'key' => 'szulkernev'
    ),
    'birthplace' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Birthdata\\Birthplace',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Születési hely',
        'key' => 'szulhely'
    ),
    'birthdate' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Birthdata\\Birthdate',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Születési idő',
        'key' => 'szulido'
    ),
    'mothername' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Mothername',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Anyja neve',
        'key' => 'anyjaneve'
    ),
    'zipcode' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Address\\Zipcode',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Irányítószám',
        'key' => 'irszam'
    ),
    'city' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Address\\City',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Település',
        'key' => 'telepules'
    ),
    'street' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Address\\Street',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Utca',
        'key' => 'utca'
    ),
    'houseNumber' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Address\\HouseNumber',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Házszám',
        'key' => 'hazszam'
    ),
    'county' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Address\\County',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Megye',
        'key' => 'megye'
    ),
    'phoneLandline' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Phone\\Landline',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Vezetékes',
        'key' => 'phone1'
    ),
    'phoneMobile1' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Phone\\MobilePrimary',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Mobil - Elsődleges',
        'key' => 'phone2'
    ),
    'phoneMobile2' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Phone\\MobileSecondary',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Mobil - Másodlagos',
        'key' => 'phone3'
    ),
    'email' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Email',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'E-mail cím',
        'key' => 'email'
    ),
    'highestEducation' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\HighestEducation',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Legmagasabb iskolai végzettség',
        'key' => 'legmagvegzettseg'
    ),
    'registeredUnemployed' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\LaborMarket\\IsRegisteredUnemployed',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Regisztrált munkanélküli?',
        'key' => 'regmunka'
    ),
    'entrant' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\LaborMarket\\IsEntrant',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Pályakezdő?',
        'key' => 'palyakezdo'
    ),
    'changedWorkingAbility' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\LaborMarket\\IsChangedWorkingAbility',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Megváltozott munkaképességű?',
        'key' => 'megvmunka'
    ),
    'gyesGyedReEntrant' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\LaborMarket\\IsGYESGYEDReEntrant',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'GYES-ről, GYED-ről visszatérő-e?',
        'key' => 'gyesgyed'
    ),
    'euProgramLastTwoYears' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\EuProgramLastTwoYears',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Uniós finanszírozású programban részt vett-e az utóbbi 2 évben?',
        'key' => 'unios2ev'
    ),
    'homeProgramLastTwoYears' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\HomeProgramLastTwoYears',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Hazai finanszírozású programban részt vett-e az utóbbi 2 évben?',
        'key' => 'hazai2ev'
    ),
    'programInformation' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProgramInformation',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Honnan hallott rólunk?',
        'key' => 'honnan'
    ),
    'coopAgreementProgram' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\CoopAgreementProgram',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Kötött-e együttműködési megállapodást a programban?',
        'key' => 'egyuttmukprog'
    ),
    'coopAgreementTraining' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\CoopAgreementTraining',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Kötött-e együttműködési megállapodást képzésben?',
        'key' => 'egyuttmukkepzes'
    ),
    'service' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Service',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Szolgáltatások, amik érdeklik',
        'key' => 'szolgaltatas'
    ),
    'contactTime' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ContactTime',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Kapcsolatfelvétel ideje',
        'key' => 'kapcsfel'        
    ),
    'language' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Knowledge\\Language',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Nyelvvizsga nyelv',
        'key' => 'nyelvvizsganyelv'
    ),
    'level' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Knowledge\\Level',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Nyelvvizsga típus',
        'key' => 'nyelvvizsgatipus'
    ),
    'job' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Job',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Betölteni kívánt munkakörök',
        'key' => 'betolt'
    ),
    'hozJarulMunkakozv' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\HozJarulMunkakozv',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Hozzájárul-e a munkaközvetítéshez?',
        'key' => 'hozzajarul'
    ),
    'isAbleToRelocate' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\ProjectInformation\\IsAbleToRelocate',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Mobilis-e?',
        'key' => 'mobilitas'
    ),
    'workschedule' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Workschedule',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Munkarend',
        'key' => 'munkarend'
    ),
    'jobCategory' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\JobCategory',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Munkakör kategória',
        'key' => 'munkakorkategoria'
    ),
    'employmentStatus' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\EmploymentStatus',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Simple',
        'label' => 'Munkába állás állapota',
        'key' => 'munkaallapot'
    ),
    'education' => array(
        'reader' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Reader\\Education',
        'assigner' => '\\Uniweb\\Module\\Ugyfel\\Library\\Xls\\Assigner\\Multiple',
        'label' => 'Végzettség megnevezés',
        'key' => 'vegzettseg_megnevezes'
    )
);