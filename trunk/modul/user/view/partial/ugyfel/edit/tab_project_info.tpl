<div class="field">
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('eu_prog_elm_ket_ev')}</label>
        <label>
            <input 
                id="projectInfoEuProg0" 
                name="models[project_information][eu_prog_elm_ket_ev]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->eu_prog_elm_ket_ev === 0} checked="checked"{/if} 
            /><!--/#projectInfoEuProg0-->
            Nem
        </label>
        <label>
            <input 
                id="projectInfoEuProg1" 
                name="models[project_information][eu_prog_elm_ket_ev]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->eu_prog_elm_ket_ev === 1} checked="checked"{/if} 
            /><!--/#projectInfoEuProg1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='eu_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('hazai_prog_elm_ket_ev')}</label>
        <label>
            <input 
                id="ProjectInfoHazaiProg0" 
                name="models[project_information][hazai_prog_elm_ket_ev]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->hazai_prog_elm_ket_ev === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoHazaiProg0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoHazaiProg1" 
                name="models[project_information][hazai_prog_elm_ket_ev]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->hazai_prog_elm_ket_ev === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoHazaiProg1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='hazai_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('koz_adatb_kerul')}</label>
        <label>
            <input 
                id="ProjectInfoKozAdatbKerult0" 
                name="models[project_information][koz_adatb_kerul]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->koz_adatb_kerul === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoKozAdatbKerult0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoKozAdatbKerult1" 
                name="models[project_information][koz_adatb_kerul]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->koz_adatb_kerul === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoKozAdatbKerult1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='koz_adatb_kerul' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('hozjarul_munkakozv')}</label>
        <label>
            <input 
                id="ProjectInfoHozjarulMunkakozv0" 
                name="models[project_information][hozjarul_munkakozv]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->hozjarul_munkakozv === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoHozjarulMunkakozv0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoHozjarulMunkakozv1" 
                name="models[project_information][hozjarul_munkakozv]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->hozjarul_munkakozv === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoHozjarulMunkakozv1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='hozjarul_munkakozv' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('mobilitast_vallal')}</label>
        <label>
            <input 
                id="ProjectInfoMobilitasVallal0" 
                name="models[project_information][mobilitast_vallal]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->mobilitast_vallal === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoMobilitasVallal0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoMobilitasVallal1" 
                name="models[project_information][mobilitast_vallal]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->mobilitast_vallal === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoMobilitasVallal1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='mobilitast_vallal' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('mobilitast_vallal_megjegyzes')}</label>
        <input 
            id="ProjectInformationMobilitastVallalMegjegyzes" 
            name="models[project_information][mobilitast_vallal_megjegyzes]" 
            type="text" 
            value="{$ProjectInformation->mobilitast_vallal_megjegyzes}"
        />
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label class="uw-ugyfelkezelo-label uw-ugyfelkezelo-label-darkorange">{$ProjectInformation->getAttributeLabel('munkarend_id')}</label>
        {foreach from=$wsOptions item=ws key=key}
            <div>
                {assign var="isChecked" value=isset($selectedWss[$ws->munkarend_id])}
                <label>
                    <input 
                        id="ws{$ws->munkarend_id}" 
                        name="models[client_work_schedules][{$key}][munkarend_id]" 
                        value="{$ws->munkarend_id}"
                        type="checkbox"
                        {if $isChecked}checked{/if}
                    />
                    {$ws->munkarend_nev}
                </label>
                {if $ws->has_field}
                <input 
                    id="ws{$ws->munkarend_id}Text" 
                    name="models[client_work_schedules][{$key}][egyeb]" 
                    type="text"
                    {if not $isChecked}disabled{/if}
                    style="margin-left: 26px; margin-top: 10px;"
                    {if $isChecked}value="{$selectedPis[$ws->munkarend_id]}"{/if}
                />
                <div class="clear"></div>
                {/if}
            </div>
        {/foreach}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div id="honnanHallottRow" class="form_row">
        <label>Honnan hallott a programról ?</label>
        {foreach from=$programInformations item=programInformation key=key}
            <div>
                {assign var="isChecked" value=isset($selectedPis[$programInformation->program_informacio_id])}
                <label>
                    <input 
                        id="programInformation{$programInformation->program_informacio_id}" 
                        name="models[client_program_information][{$key}][program_informacio_id]" 
                        value="{$programInformation->program_informacio_id}"
                        type="checkbox"
                        {if $isChecked}checked{/if}
                    />
                    {$programInformation->program_informacio_nev}
                </label>
                {if $programInformation->has_field}
                <input 
                    id="programInformation{$programInformation->program_informacio_id}Text" 
                    name="models[client_program_information][{$key}][egyeb]" 
                    type="text"
                    {if not $isChecked}disabled{/if}
                    style="margin-left: 26px; margin-top: 10px;"
                    {if $isChecked}value="{$selectedPis[$programInformation->program_informacio_id]}"{/if}
                />
                <div class="clear"></div>
                {/if}
            </div>
        {/foreach}
    </div><!--/.form_row-->
    <div class="clear"></div><!--/.clear-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('hova_erkezett_id')}</label>
        {html_options name="models[project_information][hova_erkezett_id]" options=$cameToOptions selected=$ProjectInformation->hova_erkezett_id}
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('egy_megall_ktttnk_prog')}</label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkProg0" 
                name="models[project_information][egy_megall_ktttnk_prog]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->egy_megall_ktttnk_prog === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkProg0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkProg1" 
                name="models[project_information][egy_megall_ktttnk_prog]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->egy_megall_ktttnk_prog === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkProg1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='egy_megall_ktttnk_prog' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
    <div class="form_row">
        <label>{$ProjectInformation->getAttributeLabel('egy_megall_ktttnk_kepz')}</label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkKepz0" 
                name="models[project_information][egy_megall_ktttnk_kepz]" 
                type="radio" 
                value="0"
                {if $ProjectInformation->egy_megall_ktttnk_kepz === 0} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkKepz0-->
            Nem
        </label>
        <label>
            <input 
                id="ProjectInfoEgyMegallKtttnkKepz1" 
                name="models[project_information][egy_megall_ktttnk_kepz]" 
                type="radio" 
                value="1"
                {if $ProjectInformation->egy_megall_ktttnk_kepz === 1} checked="checked"{/if} 
            /><!--/#ProjectInfoEgyMegallKtttnkKepz1-->
            Igen
        </label>
        {ar_error model=$ProjectInformation property='egy_megall_ktttnk_kepz' view='admin_ar_error.tpl'}
    </div><!--/.form_row-->
</div><!--/.field-->