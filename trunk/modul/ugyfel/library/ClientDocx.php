<?php
class ClientDocx
{
    /**
     *
     * @var array
     */
    protected $config = array();
    /**
     * Ügyfél objektum.
     * @var Client
     */
    private $client;
    
    public function __construct(\Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }
    
    protected function getConfigItem($item)
    {
        return isset($this->config[$item]) ? $this->config[$item] : null;
    }
    
    public function generateDocx()
    {
        $initSection = function(&$section) {
            $pageStyle = $section->getSettings();
            $pageStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Font::centimeterSizeToTwips(1.5));
            $pageStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Font::centimeterSizeToTwips(1.5));
            $pageStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Font::centimeterSizeToTwips(3.2));
            $pageStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Font::centimeterSizeToTwips(1.5));
            $pageStyle->setHeaderHeight(350);
        };
        $settings = $this->config['settings'];
        $styles = $this->config['styles'];
        $texts = $this->config['texts'];
        $tts = $settings['tableTextSpace'];
        $uhDataF = $styles['uhDataF'];
        $footerTexts = $texts['footer'];
        // PhpWord objektum létrehozása.
        $phpWord = new \PhpOffice\PhpWord\PhpWord;
        //$properties = $phpWord->getDocumentProperties();
        // Alapbeállítások.
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);
        $docxImagesPath = 'resources/client/docximages/';
        // Új oldal hozzáadása a dokumentumhoz.
        $page1 = $phpWord->addSection();
        $initSection($page1);
        // Élőfej hozzáadása a dokumentumhoz.
        $header = $page1->addHeader();
        // E-Karrier logo beszúrása a fejlécbe.
        $header->addImage($docxImagesPath . 'logo.png', array(
            'height' => 60,
            'positioning' => 'absolute',
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
            'width' => 140,
            'wrappingStyle' => 'square'
        ));
        // Új Széchenyi terv logo beszúrása a fejlécbe.
        $header->addImage($docxImagesPath . 'uj_szechenyi_terv.png', array(
            'align' => 'right',
            'height' => 44,
            'posVerticalRel' => 'line',
            'width' => 150,
        ));
        // Élőláb hozzáadása a dokumentumhoz.
        $footer = $page1->addFooter();        
        $footerFont = array('size' => 9);
        // Magyarország megújul logo hozzáadása a dokumentumhoz.
        $footer->addImage($docxImagesPath . 'magyarorszag_megujul.png', array(
            //'align' => 'right',
            'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            //'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_CENTER,
            //'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'width' => 180,
            'wrappingStyle' => 'infront'
            /*
            'positioning' => 'absolute',
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
            'width' => 180,
            'wrappingStyle' => 'square'
            */
            /*
        'width' => \PhpOffice\PhpWord\Shared\Drawing::centimetersToPixels(3),
        'height' => \PhpOffice\PhpWord\Shared\Drawing::centimetersToPixels(3),
        'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
        'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
        //'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        //'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'marginLeft' => \PhpOffice\PhpWord\Shared\Drawing::centimetersToPixels(15.5),
        'marginTop' => \PhpOffice\PhpWord\Shared\Drawing::centimetersToPixels(1.55)
             * 
             */
        ));
        $footer->addText($footerTexts[0], $footerFont, array('spaceAfter' => 240));
        $footer->addText($footerTexts[1], $footerFont);
        $footer->addText($footerTexts[2], $footerFont);
        $footer->addText($footerTexts[3], $footerFont);
        $footer->addText($footerTexts[4], $footerFont);
        $footer->addLink('http://' . $footerTexts[5], $footerTexts[5], $footerFont);
        $footer->addText($footerTexts[6], $footerFont);
        //$footer->addWatermark($docxImagesPath . 'magyarorszag_megujul.png');
        $page1->addText(null);
        // Szöveg megjelenítése az első oldalon.
        $page1->addText($texts[0], array('bold' => true), array('align' => 'center'));
        $page1->addText($texts[1], null, array('align' => 'center'));
        $page1->addText($texts[2], array('bold' => true, 'underline' => 'single'), $styles['p1PaddingText']);
        $page1->addText($texts[3]);
        $page1->addText($texts[4]);
        $page1->addText($texts[5]);
        $page1->addText($texts[6], array('bold' => true), array(
            'align' => 'center', 
            'spaceAfter' => 600, 
            'spaceBefore' => 400
        ));
        // Ügyfél személyes adatait tartalmazó táblázat.
        //$fullWidth = 8750;
        $fullWidth = 11000;
        $valueWidth = $fullWidth / 1.45;
        $labelWidth = $fullWidth - $valueWidth;
        $halfWidth = $fullWidth / 1.50;
        // Ügyfél adatok tábla elkészítése.
        $table = $page1->addTable($styles['baseTable']);
        $addRow = function($label, $value) use ($table, $labelWidth, $valueWidth) {
            $table->addRow();
            $table->addCell($labelWidth, array(
                'borderRightColor' => 006699,
                'borderRightSize' => 6
            ))->addText($label . ':', array('bold' => true));
            $table->addCell($valueWidth)->addText($value, null, array('spaceAfter' => 100));
        };
        // Ügyfél adatok tábla fejléce.
        $table->addRow();
        $cell = $table->addCell();
        $cell->getStyle()->setGridSpan(2);
        $cell->addText('Személyes adatai', array('bold' => true), array(
            'align' => 'center',
            'spaceAfter' => $tts,
            'fontSize' => 16
        ));
        // Ügyfél adatok tábla feltöltése.
        $addRow('Név', $this->client->getFullname());
        //$addRow('Születési név', $this->client->clientdata->szuletesi_nev);
        $birthData = $this->client->clientbirthdata;
        $addRow('Születési név', $birthData->szuletesi_vezeteknev . ' ' . $birthData->szuletesi_keresztnev);
        $birthPlaceCountry = $birthPlaceCity = '';
        if ((int)$birthData->szuletesi_hely_orszag_id > 0) {
            $bpCountry = Country::find('first', array(
                'conditions' => array(
                    'cim_orszag_id' => $birthData->szuletesi_hely_orszag_id
                )
            ));
            if (is_object($bpCountry)) {
                $birthPlaceCountry = $bpCountry->nev;
            }
        }
        if ((int)$birthData->szuletesi_hely_varos_id > 0) {
            $bpCity = City::find('first', array(
                'conditions' => array(
                    'cim_varos_id' => $birthData->szuletesi_hely_varos_id
                )
            ));
            if (is_object($bpCity)) {
                $birthPlaceCity = $bpCity->cim_varos_nev;
            }
        }
        //$addRow('Születési hely', $this->client->clientdata->szuletesi_hely);
        $addRow('Születési hely', $birthPlaceCountry . ' ' . $birthPlaceCity);
        //$addRow('Születési idő', $this->client->clientdata->szuletesi_ido);
        $addRow('Születési idő', $birthData->szuletesi_ido);
        //$addRow('Elérhetőség, lakcím', $this->client->clientdata->lakcim);
        $addRow('Elérhetőség, lakcím', 'Lakcím');
        $addRow('Telefon', $this->client->telefonszam_vezetekes);
        $addRow('E-mail cím', $this->client->email);
        // n:m lista.
        $nmList = function($section, $options, $selected, $idField, $nameField) use ($uhDataF) {
            if (!empty($options)) {
                foreach ($options as $option) {
                    $section->addListItem(
                        $option->{$nameField}, 
                        0, 
                        in_array($option->{$idField}, $selected) ? $uhDataF : null
                    );
                }
            }
        };
        $yesNo = function($value) {
            if ($value === 1 || $value === true) {
                return 'Igen';
            } elseif ($value === 0 || $value === false) {
                return 'Nem';
            } else {
                return 'Ismeretlen';
            }
        };
        // Második oldal hozzáadása a dokumentumhoz.
        $page2 = $phpWord->addSection();
        $initSection($page2);
        // Élőfej megtörése.
        $page2->addText(null);
        $lm = $this->client->labormarket;
        // Munkaerőpiaci helyzet tábla.
        $lmTable = $page2->addTable($styles['baseTable']);
        $lmTable->addRow();
        $lmTable->addCell(2500, array(
            'borderRightColor' => 006699,
            'borderRightSize' => 6
        ))->addText($texts[7], array('bold' => true));
        $lmTableCell = $lmTable->addCell($fullWidth);
        $addLmTableCol = function($field, $value, $style = null) use ($lmTableCell, $lm) {
            $li = $lmTableCell->addListItemRun(0, null, $style);
            $li->addText($lm->getAttributeLabel($field) . ': ');
            $li->addText($value, array('bold' => true));
        };
        // Munkaerőpiaci helyzet táblázat feltöltése.
        $addLmTableCol('palyakezdo', $yesNo($lm->palyakezdo));
        $addLmTableCol('regisztralt_munkanelkuli', $yesNo($lm->regisztralt_munkanelkuli));
        $addLmTableCol('mikor_regisztralt', $lm->getMikorRegisztraltFormatted('Y-m-d'));
        $addLmTableCol('gyes_gyed_visszatero', $yesNo($lm->gyes_gyed_visszatero));
        $addLmTableCol('gyes_gyed_lejar_datum', $lm->getGyesGyedLejarDatumFormatted('Y-m-d'));
        $addLmTableCol('megvaltozott_mkepessegu', $yesNo($lm->megvaltozott_mkepessegu));
        $addLmTableCol('kov_felulv_date', $lm->getKovFelulvDateFormatted('Y-m-d'));
        $addLmTableCol('mvegzes_keok', $lm->mvegzes_keok);
        $addLmTableCol('dolgozik', $yesNo($lm->dolgozik), array(
            'spaceAfter' => 100
        ));
        // Táblázat megtörése.
        $page2->addText(null);
        // Projekt információ táblázat.
        $table3 = $page2->addTable($styles['baseTable']);
        $projectInformation = $this->client->projectinformation;
        $addPiUnderlineRow = function($field) use ($projectInformation, $table3, $fullWidth, $tts, $uhDataF) {
            $table3->addRow();
            $label = $table3->addCell($fullWidth - 4000);
            $label->getStyle()->setGridSpan(3);
            $label->addText($projectInformation->getAttributeLabel($field), array('bold' => true), array(
                'spaceAfter' => $tts,
                //'spaceBefore' => $tts
            ));
            //$table3->addRow();
            $pStyle = array('align' => 'center');
            $underline = function($value, $supposed) use ($uhDataF) {
                return $value === $supposed ? $uhDataF : null;
            };
            $table3->addCell(2000)->addText('Igen', $underline($projectInformation->{$field}, 1), $pStyle);
            $table3->addCell(2000)->addText('Nem', $underline($projectInformation->{$field}, 0), $pStyle);
        };
        // Projekt információs adatok megjelenítése.
        $pi2Underline = array(
            'eu_prog_elm_ket_ev',
            'hazai_prog_elm_ket_ev',
            'koz_adatb_kerul',
            'hozjarul_munkakozv',
            'mobilitast_vallal',
            //'kk_trening_resztvett',
            //'graf_elemz_resztvett',
            //'jogi_tadas_resztvett',
            //'kepz_tanad_resztvett',
            //'munka_tanad_resztvett',
            //'pszich_tanad_resztvett',
            'egy_megall_ktttnk_prog',
            'egy_megall_ktttnk_kepz'
        );
        foreach ($pi2Underline as $field) {
            $addPiUnderlineRow($field);
        }
        // Harmadik oldal hozzáadása.
        $page3 = $phpWord->addSection();
        $initSection($page3);
        $page3->addText($texts[10], $styles['nmHeadingF'], array('spaceBefore' => 60) + $styles['nmHeadingP']);
        $nmList(
            $page3,
            Education::findAllActiveNotDeleted(),
            ArHelper::result2Options($this->client->educations, 'vegzettseg_id', 'vegzettseg_id'),
            'vegzettseg_id',
            'vegzettseg_nev'
        );
        // Munkarend
        $page3->addText('Munkarendek', $styles['nmHeadingF'], $styles['nmHeadingP']);
        $nmList(
            $page3,
            WorkSchedule::findAllActiveNotDeleted(),
            ArHelper::result2Options($this->client->workschedules, 'munkarend_id', 'munkarend_id'),
            'munkarend_id',
            'munkarend_nev'
        );
        // Képzések
        /*
        $page3->addText($texts[8], $styles['nmHeadingF'], $styles['nmHeadingP']);
        $nmList(
            $page3, 
            Training::findAllActiveNotDeleted(), 
            ArHelper::result2Options($this->client->trainings, 'kepzes_id', 'kepzes_id'), 
            'kepzes_id', 
            'kepzes_nev'
        );
        */
        // Szolgáltatások
        $page3->addText($texts[9], $styles['nmHeadingF'], $styles['nmHeadingP']);
        $nmList(
            $page3,
            Service::findAllActiveNotDeleted(),
            ArHelper::result2Options($this->client->services, 'szolgaltatas_id', 'szolgaltatas_id'),
            'szolgaltatas_id',
            'szolgaltatas_nev'
        );
        // Negyedik oldal hozzáadása.
        $page4 = $phpWord->addSection();
        $initSection($page4);
        $page4->addText($texts[11], $styles['nmHeadingF'], array('spaceBefore' => 60) + $styles['nmHeadingP']);
        $pis = ProgramInformation::findAllActiveNotDeleted();
        if (!empty($pis)) {
            $spis = ArHelper::result2Options($this->client->programinformations, 'program_informacio_id', 'egyeb');
            /* @var $pi \ProgramInformation */
            foreach ($pis as $pi) {
                $style = isset($spis[$pi->program_informacio_id]) ? $uhDataF : null;
                if ($pi->has_field) {
                    $li = $page4->addListItemRun();
                    $li->addText($pi->program_informacio_nev . ': ', $style);
                    $li->addText($spis[$pi->program_informacio_id]);
                } else {
                    $page4->addListItem($pi->program_informacio_nev, 0, $style);
                }
            }
        }
        $page4->addText($texts[12], null, array('spaceAfter' => 380, 'spaceBefore' => 140));
        $page4->addText('Dátum: ' . date('Y.m.d'));
        $phpWord->addParagraphStyle('rightTab', array(
            'spaceBefore' => 1300,
            'tabs' => array(
                new \PhpOffice\PhpWord\Style\Tab('right', 8090)
            )
        ));
        $page4->addText("\taláírás", null, 'rightTab');
        // Mentés a /tmp könyvtárba.
        $format = '.docx';
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        //$temp = '/tmp/' . time() . $format;
	$temp = ‘/docx/‘ . time() . $format;
        $xmlWriter->save($temp);
        return $temp;
    }
    
    public function getClient()
    {
        return $this->client;
    }
}