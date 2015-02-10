<div class="field">
    <div class="form_row">
        <label>Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?</label>
        <label>
            <input 
                id="projectInfoEuProg0" 
                name="projectInfo[eu_prog_elm_ket_ev]" 
                type="radio" 
                value="0"
                {if $projectInfo->eu_prog_elm_ket_ev === 0} checked="checked"{/if} 
            /><!--/#projectInfoEuProg0-->
            Nem
        </label>
        <label>
            <input 
                id="projectInfoEuProg1" 
                name="projectInfo[eu_prog_elm_ket_ev]" 
                type="radio" 
                value="1"
                {if $projectInfo->eu_prog_elm_ket_ev === 1} checked="checked"{/if} 
            /><!--/#projectInfoEuProg1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='eu_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Hazai finanszírozású programban részt vett-e az elmúlt 2 évben ?</label>
        <label>
            <input 
                id="ProjectInfoHazaiProg0" 
                name="projectInfo[hazai_prog_elm_ket_ev]" 
                type="radio" 
                value="0"
                {if $projectInfo->hazai_prog_elm_ket_ev === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoHazaiProg0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoHazaiProg1" 
                name="projectInfo[hazai_prog_elm_ket_ev]" 
                type="radio" 
                value="1"
                {if $projectInfo->hazai_prog_elm_ket_ev === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoHazaiProg1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='hazai_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Közvetítői adatbázisba kíván-e kerülni ?</label>
        <label>
            <input 
                id="ProjectInfoKozAdatbKerult0" 
                name="projectInfo[koz_adatb_kerul]" 
                type="radio" 
                value="0"
                {if $projectInfo->koz_adatb_kerul === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoKozAdatbKerult0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoKozAdatbKerult1" 
                name="projectInfo[koz_adatb_kerul]" 
                type="radio" 
                value="1"
                {if $projectInfo->koz_adatb_kerul === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoKozAdatbKerult1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='koz_adatb_kerul' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Hozzájárult-e munkaközvetítéshez ?</label>
        <label>
            <input 
                id="ProjectInfoHozjarulMunkakozv0" 
                name="projectInfo[hozjarul_munkakozv]" 
                type="radio" 
                value="0"
                {if $projectInfo->hozjarul_munkakozv === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoHozjarulMunkakozv0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoHozjarulMunkakozv1" 
                name="projectInfo[hozjarul_munkakozv]" 
                type="radio" 
                value="1"
                {if $projectInfo->hozjarul_munkakozv === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoHozjarulMunkakozv1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='hozjarul_munkakozv' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Mobilitást vállal-e ?</label>
        <label>
            <input 
                id="ProjectInfoMobilitasVallal0" 
                name="projectInfo[mobilitast_vallal]" 
                type="radio" 
                value="0"
                {if $projectInfo->mobilitast_vallal === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoMobilitasVallal0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoMobilitasVallal1" 
                name="projectInfo[mobilitast_vallal]" 
                type="radio" 
                value="1"
                {if $projectInfo->mobilitast_vallal === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoMobilitasVallal1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='mobilitast_vallal' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label for="ProjectInfoMunkarend">Milyen munkarendben kíván elhelyezkedni ?</label>
        <input 
            id="ProjectInfoMunkarend" 
            name="projectInfo[munkarend]" 
            type="text" 
            value="{$projectInfo->munkarend}" 
        /><!--/#ProjectInfoMunkarend-->
        {ar_error model=$projectInfo property='munkarend' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="ProjectInfoHonnanHallProg">Honnan hallott a programról ?</label>
        <input 
            id="ProjectInfoHonnanHallpProg" 
            name="projectInfo[honnan_hall_prog]" 
            type="text" 
            value="{$projectInfo->honnan_hall_prog}" 
        /><!--/#ProjectInfoHonnanHallProg-->
        {ar_error model=$projectInfo property='honnan_hall_prog' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label for="ProjectInfoHovaMireErkezett">Hova és mire érkezett be az ügyfél ?</label>
        <input 
            id="ProjectInfoHovaMireErkezett" 
            name="projectInfo[hova_mire_erkezett]" 
            type="text" 
            value="{$projectInfo->hova_mire_erkezett}" 
        /><!--/#ProjectInfoHovaMireErkezett-->
        {ar_error model=$projectInfo property='hova_mire_erkezett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>Kulcs. Képességfejl. Tréningen részt vett-e ?</label>
        <label>
            <input 
                id="ProjectInfoKkTreningResztvett0" 
                name="projectInfo[kk_trening_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->kk_trening_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoKkTreningResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoKkTreningResztvett1" 
                name="projectInfo[kk_trening_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->kk_trening_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoKkTreningResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='kk_trening_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Grafológiai elemzésen részt vett-e ?</label>
        <label>
            <input 
                id="ProjectInfoGrafElemzResztvett0" 
                name="projectInfo[graf_elemz_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->graf_elemz_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoGrafElemzResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoGrafElemzResztvett1" 
                name="projectInfo[graf_elemz_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->graf_elemz_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoGrafElemzResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='graf_elemz_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Jogi tanácsadáson részt vett-e?</label>
        <label>
            <input 
                id="ProjectInfoJogiTadasResztvett0" 
                name="projectInfo[jogi_tadas_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->jogi_tadas_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoJogiTadasResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoJogiTadasResztvett1" 
                name="projectInfo[jogi_tadas_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->jogi_tadas_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoJogiTadasResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='jogi_tadas_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Képzési tanácsadáson részt vett-e ?</label>
        <label>
            <input 
                id="ProjectInfoKepzTanadResztvett0" 
                name="projectInfo[kepz_tanad_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->kepz_tanad_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoKepzTanadResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoKepzTanadResztvett1" 
                name="projectInfo[kepz_tanad_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->kepz_tanad_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoKepzTanadResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='kepz_tanad_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Munkatanácsadáson részt vett-e ?</label>
        <label>
            <input 
                id="ProjectInfoMunkaTanadResztvett0" 
                name="projectInfo[munka_tanad_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->munka_tanad_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoMunkaTanadResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoMunkaTanadResztvett1" 
                name="projectInfo[munka_tanad_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->munka_tanad_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoMunkaTanadResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='munka_tanad_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Pszichológiai tanácsadáson részt vett-e ?</label>
        <label>
            <input 
                id="ProjectInfoPszichTanadResztvett0" 
                name="projectInfo[pszich_tanad_resztvett]" 
                type="radio" 
                value="0"
                {if $projectInfo->pszich_tanad_resztvett === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoPszichTanadResztvett0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoPszichTanadResztvett1" 
                name="projectInfo[pszich_tanad_resztvett]" 
                type="radio" 
                value="1"
                {if $projectInfo->pszich_tanad_resztvett === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoPszichTanadResztvett1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='pszich_tanad_resztvett' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Együttműködési megállapodást kötöttünk-e vele a programba ?</label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkProg0" 
                name="projectInfo[egy_megall_ktttnk_prog]" 
                type="radio" 
                value="0"
                {if $projectInfo->egy_megall_ktttnk_prog === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkProg0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkProg1" 
                name="projectInfo[egy_megall_ktttnk_prog]" 
                type="radio" 
                value="1"
                {if $projectInfo->egy_megall_ktttnk_prog === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkProg1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='egy_megall_ktttnk_prog' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>Együttműködési megállapodást kötöttünk-e vele a képzésbe ?</label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkKepz0" 
                name="projectInfo[egy_megall_ktttnk_kepz]" 
                type="radio" 
                value="0"
                {if $projectInfo->egy_megall_ktttnk_kepz === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkKepz0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkKepz1" 
                name="projectInfo[egy_megall_ktttnk_kepz]" 
                type="radio" 
                value="1"
                {if $projectInfo->egy_megall_ktttnk_kepz === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkKepz1-->
            Igen
        </label>
        {ar_error model=$projectInfo property='egy_megall_ktttnk_kepz' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
</div><!--/.field-->