{filter_text filterTemplateId="firstnameFilter" filterKey="firstname" filterLabel="Keresztnév"}
{filter_text filterTemplateId="lastnameFilter" filterKey="lastname" filterLabel="Vezetéknév"}
{filter_text filterTemplateId="emailFilter" filterKey="email" filterLabel="E-mail cím"}
{filter_text filterTemplateId="birthFirstnameFilter" filterKey="birthFirstname" filterLabel="Születési keresztnév"}
{filter_text filterTemplateId="birthLastnameFilter" filterKey="birthLastname" filterLabel="Születési vezetéknév"}
{filter_text filterTemplateId="motherNameFilter" filterKey="motherName" filterLabel="Anyja neve"}
{filter_text filterTemplateId="phoneLandlineFilter" filterKey="phoneLandline" filterLabel="Vezetékes telefonszám"}
{filter_text filterTemplateId="phoneMobile1Filter" filterKey="phoneMobile1" filterLabel="Elsődleges mobilszám"}
{filter_text filterTemplateId="phoneMobile2Filter" filterKey="phoneMobile2" filterLabel="Másodlagos mobilszám"}
{filter_text filterTemplateId="dolgozikCegFilter" filterKey="dolgozikCeg" filterLabel="Hol dolgozik (cég neve)"}
{filter_text filterTemplateId="dolgozikCimFilter" filterKey="dolgozikCim" filterLabel="Hol dolgozik (cég címe)"}
{filter_text filterTemplateId="dolgozikMunkakorFilter" filterKey="dolgozikMunkakor" filterLabel="Milyen munkakörben dolgozik"}
{filter_text filterTemplateId="munkavegzestKorlatozoEgyebOkokFilter" filterKey="munkavegzestKorlatozoEgyebOkok" filterLabel="Munkavégzést korlátozó egyéb okok"}
{filter_true_or_false filterTemplateId="palyakezdoFilter" filterKey="palyakezdo" filterLabel="Pályakezdő"}
{filter_true_or_false filterTemplateId="regisztraltMunkanelkuliFilter" filterKey="regisztraltMunkanelkuli" filterLabel="Regisztrált munkanélküli"}
{filter_true_or_false filterTemplateId="gyesGyedVisszateroFilter" filterKey="gyesGyedVisszatero" filterLabel="GYES-GYED visszatérő"}
{filter_true_or_false filterTemplateId="megvaltozottMunkakepesseguFilter" filterKey="megvaltozottMunkakepessegu" filterLabel="Megváltozott munkaképességű"}
{filter_true_or_false filterTemplateId="dolgozikFilter" filterKey="dolgozik" filterLabel="Dolgozik"}
{filter_true_or_false filterTemplateId="euProgramFilter" filterKey="euProgram" filterLabel="Az elmúlt 2 évben Uniós finanszírozású foglalkoztatási programban részt vett-e ?"}
{filter_true_or_false filterTemplateId="hazaiProgramFilter" filterKey="hazaiProgram" filterLabel="A programba bevonás idején hazai foglalkoztatási programban részt vett-e ?"}
{filter_true_or_false filterTemplateId="kozvetitioAdatbazisbaKivanKerulniFilter" filterKey="kozvetitioAdatbazisbaKivanKerulni" filterLabel="Közvetítői adatbázisba kíván-e kerülni"}
{filter_true_or_false filterTemplateId="mobilitastVallalFilter" filterKey="mobilitastVallal" filterLabel="Mobilitást vállal ?"}
{filter_true_or_false filterTemplateId="hozzajarulAMunkakozvetiteshezFilter" filterKey="hozzajarulAMunkakozvetiteshez" filterLabel="Hozzájárul a munkaközvetítéshez ?"}
{filter_true_or_false filterTemplateId="egyMegallProgFilter" filterKey="egyMegallProg" filterLabel="Együttműködési megállapodást kötöttünk-e vele a programba ?"}
{filter_true_or_false filterTemplateId="egyMegallKepzFilter" filterKey="egyMegallKepz" filterLabel="Együttműködési megállapodást kötöttünk-e vele a képzésbe ?"}
{filter_date filterTemplateId="birthdateFilter" filterKey="birthdate" filterLabel="Születési idő"}
{filter_date filterTemplateId="mikorRegisztraltFilter" filterKey="mikorRegisztralt" filterLabel="Mikor regisztrált"}
{filter_date filterTemplateId="gyesGyedLejaratiDatumFilter" filterKey="gyesGyedLejaratiDatum" filterLabel="GYES-GYED lejárati dátum"}
{filter_date filterTemplateId="kovetkezoFelulvizsgalatIdejeFilter" filterKey="kovetkezoFelulvizsgalatIdeje" filterLabel="Következő felülvizsgálat ideje"}
<script type="text/html" id="educationFilter" data-filter-key="education" data-script-type="filter">
<div class="dynamic-filter-filter dynamic-filter-text" data-role="filter" data-filter-key="education">
    <label>Tanulmány</label>
    <div class="clearfix"></div>
    <label>Típus</label>
    <select name="filter[education][educationId]">
        <option value="">--Kérem, válasszon!--</option>
        {foreach from=$beallitasEducations item=education}
        <option value="{$education->vegzettseg_id}" {if $education->vegzettseg_id eq $client->vegzettseg_id}selected="selected"{/if}>{$education->nev}</option>
        {/foreach}
    </select>
    <div class="clear"></div>
    <label>Megnevezés</label>
    <input name="filter[education][denomination]" type="text" />
    <select name="filter[education][match]">
        <option value="anywhere">bárhol</option>
        <option value="startsWith">elején</option>
        <option value="endsWith">végén</option>
        <option value="equals">teljes egyezés</option>
    </select>
</div>
</script>
<script type="text/html" id="highestEducationFilter" data-filter-key="highestEducation" data-script-type="filter">
<div class="dynamic-filter-filter dynamic-filter-text" data-role="filter" data-filter-key="highestEducation">
    <label>Legmagasabb iskolai végzettség</label>
    <select name="filter[highestEducation][educationId]">
        <option value="">--Kérem, válasszon!--</option>
        {foreach from=$beallitasEducations item=education}
        <option value="{$education->vegzettseg_id}" {if $education->vegzettseg_id eq $client->vegzettseg_id}selected="selected"{/if}>{$education->nev}</option>
        {/foreach}
    </select>
    <div class="clear"></div>
</div>
</script>
<script type="text/html" id="serviceFilter" data-filter-key="service" data-script-type="filter">
<div class="dynamic-filter-filter" data-role="filter" data-filter-key="service">
    <label for="clientBirthdateFilterBirthdate">Szolgáltatás</label>
    <select name="filter[service][serviceId]">
        {foreach from=$szolgaltatasServices item=service}
        <option value="{$service->szolgaltatas_id}">{$service->nev}</option>
        {/foreach}
    </select>
    <div class="clear"></div>
    <div style="margin-bottom: 6px; margin-top: 6px;">
        <strong style="font-size: 14px;">Részt akar venni</strong>
        <input name="filter[service][want_to_participate]" type="checkbox" style="font-size: 20px;" />
    </div>
    <div class="clear"></div>
    <div style="margin-bottom: 6px;">
        <strong style="font-size: 14px;">Részt vett</strong>
        <input name="filter[service][attended]" type="checkbox" style="font-size: 20px;" />
    </div>
    <div class="clear"></div>
    <div class="service-filter-date">
        <input name="filter[service][when]" type="text" style="width: 160px;" />
        <select name="filter[service][whenMatch]">
            <option value="lessThan">korábban, mint</option>
            <option value="lessThanOrEqual">korábban, vagy ekkor</option>
            <option value="equals">pontosan ekkor</option>
            <option value="greaterThanOrEquals">később, mint vagy ekkor</option>
            <option value="greaterThan">később, mint</option>
            <option value="between">intervallum</option>
        </select>
        <div class="clear"></div>
        <input name="filter[service][whenBetween]" type="text" style="width: 160px; display: none;" />
    </div>
</div>
</script>
<style type="text/css">
.dynamic-filter-filter {
    float: left;
    display: inline-block;
    margin-bottom: 14px;
    width: 33%;
}
.dynamic-filter-filter.dynamic-filter-text input[type="text"] {
    width: 50%;
}
.dynamic-filter-filter.dynamic-filter-text .selector {
    left: 6px;
    top: 2px;
    width: 28%;
}
.dynamic-filter-filter button[data-button-role="delete"] {
    border: 1px solid #999;
    display: inline-block;
    float: right;
    height: 28px;
    right: 10px;
    width: 28px;
}
</style>