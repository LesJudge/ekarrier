<!DOCTYPE html>
<htmlpageheader name="myHeader1">
<div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">My document</div>
</htmlpageheader>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Ügyfél adatok</title>
        <style type="text/css">
            @page {
                odd-header-name: html_MyHeader1;
                odd-footer-name: html_MyFooter1;
                /*
                margin-left: 1.25cm;
                margin-header: 6mm;
                margin-top: 3.8cm;
                margin-footer: 0mm;
                */
                margin-footer: 0mm;
                margin: 0px;
            }
            body {
                //font-family: sans-serif;
                font-family: Times New Roman;
                font-size: 14px;
            }
            .header-logo {
                //float: left;
                width: 190px;
            }
            #table-szemelyes-adatok, 
            #table-project-information {
                width: 100%;
            }
            #table-project-information {
                margin-top: 10px;
            }
            .table td {
                padding: 5px 10px;
            }
            .table td.col-label {
                font-weight: bold;
                text-align: right;
            }
            .no-underline .yes, .no-underline .no {
                text-decoration: none;
            }
            .underline-yes .yes, .underline-no .no {
                font-weight: bold;
                text-decoration: underline;
            }
            #table-project-information td.yes, #table-project-information td.no {
                text-align: center;
            }
            div.page {
                padding-left: 1.25cm;
                padding-right: 1.25cm;
                padding-top: 4cm;
            }
        </style>
    </head>
    <body>
        <htmlpageheader name="MyHeader1">
            <div style="padding-bottom: 16px; padding-left: 1.25cm; padding-right: 1.25cm;">
                <img class="header-logo" src="{$domain}resources/ekarrierlogo.png" />
                <div style="background: black; width: 100%; height: 2px; margin-top: 10px;"></div>
            </div>
        </htmlpageheader>
                
        <div class="page">
            <div style="text-align: center;">
                <strong>TÁMOP-1.4.3.-12/1-2012-0141</strong>
            </div>
            <div style="text-align: center;">„e-KARRIER” – Elektronikus Munkaerőpiaci Adatbázis és Karrierpont Hálózat</div>
            <p style="text-align: center; text-decoration: underline;">
                <strong>Kapcsolatfelvételi adatlap</strong>
            </p>
            <p>Programunk az inaktív pályakezdőknek, a regisztrált munkanélkülieknek és a GYED-ről, GYES-ről visszatérők körének nyújt segítséget. Elsősorban a középfokú végzettségű, a felsőfokú oktatásba nem belépő ill. nem dolgozó emberek számára szeretnénk megoldási lehetőséget ajánlani!</p>
            <p>Egyrészt olyan információkkal és tanácsokkal szeretnénk ellátni ügyfeleinket, amelyek hozzájárulnak elhelyezkedésükhöz, életpályájuk alakításához, valamint elősegíti szabadidejük hasznos eltöltését, másrészt OKJ-s és akkreditált képzéseket kínálunk a programban résztvevőknek!</p>
            <p>Emellett jogi-, pályázati-, pályaorientációs-, életvezetési-, vállalkozásindítási tanácsadással segítjük a programhoz csatlakozókat, akik újszerű álláskeresési technikákban (pl. videó-önéletrajz készítése, skype-os állásinterjú, stb.) is gyakorlatot szerezhetnek.</p>
            <p style="text-align: center;">
                <strong>A rendelkezésünkre bocsájtott adatokat a CSAT Egyesület az érvényben lévő adatvédelmi szabályoknak megfelelően kezeli!</strong>
            </p>
            <table id="table-szemelyes-adatok" class="table" border="1">
                <tr>
                    <th colspan="2">Személyes adatai</th>
                </tr>
                <tr>
                    <td class="col-label">Név:</td>
                    <td>{$client->vezeteknev} {$client->keresztnev}</td>
                </tr>
                <tr>
                    <td class="col-label">Születési név:</td>
                    <td>{$client->birthdata->vezeteknev} {$client->birthdata->keresztnev}</td>
                </tr>
                {assign var="birthplace" value=$birthdataDecorator->getFullBirthplace()}
                {if $birthplace}
                <tr>
                    <td class="col-label">Születési hely:</td>
                    <td>{$birthplace}</td>
                </tr>
                {/if}
                {assign var="birthdate" value=$birthdataDecorator->getBirthdate()}
                {if $birthdate}
                <tr>
                    <td class="col-label">Születési idő:</td>
                    <td>{$birthdate}</td>
                </tr>
                {/if}
                {if $client->email}
                <tr>
                    <td class="col-label">E-mail cím:</td>
                    <td>{$client->email}</td>
                </tr>
                {/if}
                {foreach from=$client->addresses item=address}
                <tr>
                    <td class="col-label">{$address->type->nev}:</td>
                    <td>
                        {$addressDecorator->setAddress($address)}
                        {$addressDecorator->getFullAddress()}
                    </td>
                </tr>
                {/foreach}
                {if $client->telefonszam_vezetekes}
                <tr>
                    <td class="col-label">Vezetékes telefonszám:</td>
                    <td>{$client->telefonszam_vezetekes}</td>
                </tr>
                {/if}
                {if $client->telefonszam_mobil1}
                <tr>
                    <td class="col-label">Elsődleges mobiltelefonszám:</td>
                    <td>{$client->telefonszam_mobil1}</td>
                </tr>
                {/if}
                {if $client->telefonszam_mobil2}
                <tr>
                    <td class="col-label">Másodlagos mobiltelefonszám:</td>
                    <td>{$client->telefonszam_mobil2}</td>
                </tr>
                {/if}
            </table>
        </div>
        <pagebreak />
        
        <div class="page">
            <table id="table-munkaeropiaci-helyzet" class="table" border="1">
                <tr>
                    <td class="col-label">Jelenlegi helyeze:</td>
                    <td>
                        <ul>
                            <li>
                                Pályakezdő: <strong>{$laborMarketDecorator->getPalyakezdo('nincs megadva')}</strong>
                            </li>
                            <li>
                                Regisztrált munkanélküli-e: <strong>{$laborMarketDecorator->getRegisztraltMunkanelkuli('nincs megadva')}</strong>
                            </li>
                            <li>
                                Mikor regisztrált: <strong>{$laborMarketDecorator->getMikorRegisztralt('nincs megadva')}</strong>
                            </li>
                            <li>
                                GYED-ről, GYES-ről visszatérő: <strong>{$laborMarketDecorator->getGyesGyedVisszatero('nincs megadva')}</strong>
                            </li>
                            <li>
                                Mikor jár le: <strong>{$laborMarketDecorator->getGyesGyedLejaratiDatum('nincs megadva')}</strong>
                            </li>
                            <li>
                                Megváltozott munkaképességű: <strong>{$laborMarketDecorator->getMegvaltozottMunkakepessegu('nincs megadva')}</strong>
                            </li>
                            <li>
                                Munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül): 
                                {if $client->labormarket->munkavegzest_korlatozo_egyeb_okok}<br />{$client->labormarket->munkavegzest_korlatozo_egyeb_okok}{else}nincs megadva{/if}
                            </li>
                            <li>
                                Dolgozik: <strong>{$laborMarketDecorator->getDolgozik('nincs megadva')}</strong>
                            </li>
                            {if $client->labormarket->dolgozik and ($client->labormarket->dolgozik_nev or $client->labormarket->dolgozik_cim or $client->labormarket->dolgozik_munkakor)}
                                {if $client->labormarket->dolgozik_nev}
                                <li>
                                    Cég neve: <strong>{$client->labormarket->dolgozik_nev}</strong>
                                </li>
                                {/if}
                                {if $client->labormarket->dolgozik_cim}
                                <li>
                                    Cég címe: <strong>{$client->labormarket->dolgozik_cim}</strong>
                                </li>
                                {/if}
                                {if $client->labormarket->dolgozik_munkakor}
                                <li>
                                    Munkakör: <strong>{$client->labormarket->dolgozik_munkakor}</strong>
                                </li>
                                {/if}
                            {/if}
                        </ul>
                    </td>
                </tr>
            </table>
            <table id="table-project-information" class="table" border="1">
                <tr>
                    <td colspan="2">
                        <strong>Az elmúlt 2 évben Uniós finanszírozású foglalkoztatási programban részt vett-e ?</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->eu_prog_elm_ket_ev]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>A programba bevonás idején hazai foglalkoztatási programban részt vett-e ?</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->hazai_prog_elm_ket_ev]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Kívánok a munkaerő közvetítői tevékenységrendszerükbe és adatbázisukba kerülni</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->kozvetitio_adatbazisba_kivan_kerulni]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Hozzájárult-e munkaközvetítéshez ?</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->hozzajarul_a_munkakozvetiteshez]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Mobilitást vállal-e ?</strong>
                    </td>y
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->mobilitast_vallal]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Megjegyzes:</strong> {$client->projectinformation->mobilitast_vallal_megjegyzes}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Együttműködési megállapodást kötöttünk-e vele a programba ?</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->egy_megall_ktttnk_prog]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Együttműködési megállapodást kötöttünk-e vele a képzésbe ?</strong>
                    </td>
                </tr>
                <tr class="{$underlineClasses[$client->projectinformation->egy_megall_ktttnk_kepz]}">
                    <td class="yes">Igen</td>
                    <td class="no">Nem</td>
                </tr>
            </table>    
        </div>
        <pagebreak />
        
        <div class="page">
            <div></div>
            <strong>Iskolai végzettség</strong>
            <ul>
                {foreach from=$educationTypes item=educationType}
                <li {if in_array($educationType->vegzettseg_id, $educations)}style="font-weight: bold; text-decoration: underline;"{/if}>{$educationType->nev}</li>
                {/foreach}
            </ul>
            <strong>Milyen szolgáltatásokban szeretne részt venni ?</strong>
            <ul>
                {foreach from=$services item=service}
                <li {if $service->getChecked()}style="font-weight: bold; text-decoration: underline;"{/if}>{$service->getName()}</li>
                {/foreach}
            </ul>
        </div>
        <pagebreak />
        
        <div class="page">
            <div></div>
            <strong>Honnan szerzett információt a programunkról ?</strong>
            <ul>
                {foreach from=$programInformations item=programInformation}
                <li>
                    <span {if $programInformation->getChecked()}style="font-weight: bold; text-decoration: underline;"{/if}>{$programInformation->getName()}</span>
                    {if $programInformation->getMisc()}({$programInformation->getMisc()}){/if}
                </li>
                {/foreach}
            </ul>
            <strong>Munkarendek</strong>
            <ul>
                {foreach from=$workschedules item=workschedule}
                <li>
                    <span {if $workschedule->getChecked()}style="font-weight: bold; text-decoration: underline;"{/if}>{$workschedule->getName()}</span>
                    {if $workschedule->getMisc()}({$workschedule->getMisc()}){/if}
                </li>
                {/foreach}
            </ul>
        </div>
        <pagebreak />
        
        <div class="page">
            <p>A programról az információkat megkaptam, szándékomat fejezem ki az abban való részvételre! Kérem a programról történő további tájékoztatást!</p>
            <p style="padding-top: 20px;">Dátum: {$date}</p>
            <div style="width: 30%; padding-top: 6px; margin-top: 100px; float: right; text-align: center; border-top: 1px solid;">aláírás</div>
        </div>
            
        <htmlpagefooter name="MyFooter1">
            <table cellspacing="0" tyle="width: 100%;">
                <tr>
                    <td style="font-size: 12px; padding-left: 40px; padding-top: 40px;">
                        <strong>CSAT Egyesület</strong><br />
                        <i>„e-KARRIER”</i> TÁMOP-1.4.3.-12/1-2012-0141<br />
                        Cím: 4025 Debrecen, Arany János utca 2. F.2.<br />
                        Nyilvántart. szám: 09-0278-04<br />
                        Akkreditációs lajstromszám: 1089<br />
                        e-mail: info@csat.hu<br />
                        <a href="http://www.csat.hu/">www.csat.hu</a><br />
                        <a href="http://www.szechenyi2020.hu/">www.ujszechenyiterv.gov.hu</a>
                    </td>
                    <td style="text-align: right; width: 50%;">
                        <img src="{$domain}resources/szechenyilogo.png" border="0" style="width: 400px;" />
                    </td>
                </tr>
            </table>
        </htmlpagefooter>
    </body>
</html>