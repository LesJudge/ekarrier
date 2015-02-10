<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('hova_erkezett_id')}</label>
        {html_options 
            id="project-information-hova-erkezett-id"
            name="models[project_information][hova_erkezett_id]" 
            options=$cameToOptions 
            selected=$ProjectInformation->hova_erkezett_id}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('eu_prog_elm_ket_ev')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-eu-prog-elm-ket-ev-1" 
                    name="models[project_information][eu_prog_elm_ket_ev]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->eu_prog_elm_ket_ev === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-eu-prog-elm-ket-ev-0" 
                    name="models[project_information][eu_prog_elm_ket_ev]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->eu_prog_elm_ket_ev === 0} checked="checked"{/if} 
                />
                Nem
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='eu_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('hazai_prog_elm_ket_ev')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-hazai-prog-elm-ket-ev-1" 
                    name="models[project_information][hazai_prog_elm_ket_ev]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->hazai_prog_elm_ket_ev === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-hazai-prog-elm-ket-ev-0" 
                    name="models[project_information][hazai_prog_elm_ket_ev]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->hazai_prog_elm_ket_ev === 0} checked="checked"{/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='hazai_prog_elm_ket_ev' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <p>A CSAT Egyesület többek között munkaerő közvetítői tevékenységet is folytat a hatékonyabb álláskeresés támogatása érdekében.</p>
    </div>
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('koz_adatb_kerul')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-koz-adatb-kerul-1" 
                    name="models[project_information][koz_adatb_kerul]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->koz_adatb_kerul === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-koz-adatb-kerul-0" 
                    name="models[project_information][koz_adatb_kerul]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->koz_adatb_kerul === 0} checked="checked"{/if} 
                />
                Nem
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='koz_adatb_kerul' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('mobilitast_vallal')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-mobilitast-vallal-1" 
                    name="models[project_information][mobilitast_vallal]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->mobilitast_vallal === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-mobilitast-vallal-0" 
                    name="models[project_information][mobilitast_vallal]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->mobilitast_vallal === 0} checked="checked"{/if} 
                />
                Nem
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='mobilitast_vallal' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label 
            for="project-information-mobilitast-vallal-megjegyzes"
        >{$ProjectInformation->getAttributeLabel('mobilitast_vallal_megjegyzes')}</label>
        <input 
            id="project-information-mobilitast-vallal-megjegyzes" 
            name="models[project_information][mobilitast_vallal_megjegyzes]" 
            type="text" 
            value="{$ProjectInformation->mobilitast_vallal_megjegyzes}"
        />
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Honnan hallott a programról ?</label>
        {foreach from=$programInformations item=programInformation key=key}
        <div 
            class="uw-ugyfelkezelo-form-client-info-chkbox 
            {if $programInformation->has_field}uw-ugyfelkezelo-form-client-info-chkbox-with-text{/if}"
        >
            {assign var="isChecked" value=array_key_exists($programInformation->program_informacio_id, $selectedPis)}
            <label>
                <input 
                    id="project-information-program-information-{$programInformation->program_informacio_id}" 
                    name="models[client_program_information][{$key}][program_informacio_id]" 
                    value="{$programInformation->program_informacio_id}"
                    type="checkbox"
                    {if $isChecked}checked{/if}
                />
                {$programInformation->program_informacio_nev}
            </label>
            {if $programInformation->has_field}
            <input 
                id="project-information-program-information-{$programInformation->program_informacio_id}-text" 
                name="models[client_program_information][{$key}][egyeb]" 
                type="text"
                {if not $isChecked}disabled{/if}
                {if $isChecked}value="{$selectedPis[$programInformation->program_informacio_id]}"{/if}
            />
            <div class="clear"></div>
            {/if}
        </div>
        {/foreach}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('hozjarul_munkakozv')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-hozjarul-munkakozv-1" 
                    name="models[project_information][hozjarul_munkakozv]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->hozjarul_munkakozv === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-hozjarul-munkakozv-0" 
                    name="models[project_information][hozjarul_munkakozv]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->hozjarul_munkakozv === 0} checked="checked"{/if} 
                />
                Nem
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='hozjarul_munkakozv' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('egy_megall_ktttnk_prog')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-egy_megall-ktttnk-prog-1" 
                    name="models[project_information][egy_megall_ktttnk_prog]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->egy_megall_ktttnk_prog === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-egy_megall-ktttnk-prog-0" 
                    name="models[project_information][egy_megall_ktttnk_prog]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->egy_megall_ktttnk_prog === 0} checked="checked"{/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='egy_megall_ktttnk_prog' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$ProjectInformation->getAttributeLabel('egy_megall_ktttnk_kepz')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-egy-megall-ktttnk-kepz-1" 
                    name="models[project_information][egy_megall_ktttnk_kepz]" 
                    type="radio" 
                    value="1"
                    {if $ProjectInformation->egy_megall_ktttnk_kepz === 1} checked="checked"{/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="project-information-egy-megall-ktttnk-kepz-0" 
                    name="models[project_information][egy_megall_ktttnk_kepz]" 
                    type="radio" 
                    value="0"
                    {if $ProjectInformation->egy_megall_ktttnk_kepz === 0} checked="checked"{/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$ProjectInformation property='egy_megall_ktttnk_kepz' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_project_information][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentProjectInformation}{$CommentProjectInformation->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentProjectInformation property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->