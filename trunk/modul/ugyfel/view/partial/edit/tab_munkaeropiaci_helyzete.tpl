<div class="uw-ugyfelkezelo-form">
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$LaborMarket->getAttributeLabel('palyakezdo')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-palyakezdo-1" 
                    name="models[labor_market][palyakezdo]" 
                    type="radio" 
                    value="1" 
                    {if $LaborMarket->palyakezdo === 1} checked="checked" {/if} 
                />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-palyakezdo-0" 
                    name="models[labor_market][palyakezdo]" 
                    type="radio" 
                    value="0" 
                    {if $LaborMarket->palyakezdo === 0} checked="checked" {/if}
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$LaborMarket property='palyakezdo' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$LaborMarket->getAttributeLabel('regisztralt_munkanelkuli')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-regisztralt-munkanelkuli-1" 
                    name="models[labor_market][regisztralt_munkanelkuli]" 
                    type="radio" 
                    value="1"
                    {if $LaborMarket->regisztralt_munkanelkuli === 1} checked="checked" {/if} />
                Igen
            </label>
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-regisztralt-munkanelkuli-0" 
                    name="models[labor_market][regisztralt_munkanelkuli]" 
                    type="radio" 
                    value="0"
                    {if $LaborMarket->regisztralt_munkanelkuli === 0} checked="checked" {/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$LaborMarket property='regisztralt_munkanelkuli' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-mikor-regisztralt" class="item-pull-left">{$LaborMarket->getAttributeLabel('mikor_regisztralt')}</label>
        <div class="uw-datepicker-container">
            <input 
                id="labor-market-mikor-regisztralt" 
                name="models[labor_market][mikor_regisztralt]" 
                type="text" 
                value="{$LaborMarket->mikor_regisztralt}" 
            />
        </div>
        {ar_error model=$LaborMarket property='mikor_regisztralt' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$LaborMarket->getAttributeLabel('gyes_gyed_visszatero')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-gyes-gyed-visszatero-1" 
                    name="models[labor_market][gyes_gyed_visszatero]" 
                    type="radio" value="1"
                    {if $LaborMarket->gyes_gyed_visszatero === 1} checked="checked" {/if} 
                />
                Igen
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-gyes-gyed-visszatero-0" 
                    name="models[labor_market][gyes_gyed_visszatero]" 
                    type="radio" value="0"
                    {if $LaborMarket->gyes_gyed_visszatero === 0} checked="checked" {/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$LaborMarket property='gyes_gyed_visszatero' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label 
            for="labor-market-gyes-gyed-lejar-datum"
            class="item-pull-left"
        >{$LaborMarket->getAttributeLabel('gyes_gyed_lejar_datum')}</label>
        <div class="uw-datepicker-container">
            <input 
                id="labor-market-gyes-gyed-lejar-datum" 
                name="models[labor_market][gyes_gyed_lejar_datum]" 
                type="text" 
                value="{$LaborMarket->gyes_gyed_lejar_datum}" 
            />
        </div>
        {ar_error model=$LaborMarket property='gyes_gyed_lejar_datum' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$LaborMarket->getAttributeLabel('megvaltozott_mkepessegu')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-megvaltozott-mkepessegu-1" 
                    name="models[labor_market][megvaltozott_mkepessegu]" 
                    type="radio" 
                    value="1"
                    {if $LaborMarket->megvaltozott_mkepessegu === 1} checked="checked" {/if} 
                />
                Igen
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-megvaltozott-mkepessegu-0" 
                    name="models[labor_market][megvaltozott_mkepessegu]" 
                    type="radio" 
                    value="0"
                    {if $LaborMarket->megvaltozott_mkepessegu === 0} checked="checked" {/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$LaborMarket property='megvaltozott_mkepessegu' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-mvegzes-keok" class="item-pull-left">{$LaborMarket->getAttributeLabel('mvegzes_keok')}</label>
        <textarea 
            id="labor-market-mvegzes-keok" 
            name="models[labor_market][mvegzes_keok]" 
            cols="50" 
            rows="5"
        >{$LaborMarket->mvegzes_keok}</textarea>
        {ar_error model=$LaborMarket property='mvegzes_keok' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label for="labor-market-kov-felulv-date" class="item-pull-left">{$LaborMarket->getAttributeLabel('kov_felulv_date')}</label>
        <div class="uw-datepicker-container">
            <input 
                id="labor-market-kov-felulv-date" 
                name="models[labor_market][kov_felulv_date]" 
                type="text" 
                value="{$LaborMarket->kov_felulv_date}" 
            />
            {ar_error model=$LaborMarket property='kov_felulv_date' view='admin_ar_error.tpl'}
        </div>
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div class="uw-ugyfelkezelo-form-row">
        <label class="item-pull-left">{$LaborMarket->getAttributeLabel('dolgozik')}</label>
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-dolgozik-1" 
                    name="models[labor_market][dolgozik]" 
                    type="radio" 
                    value="1"
                    {if $LaborMarket->dolgozik === 1} checked="checked" {/if} 
                />
                Igen
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        <div class="uw-ugyfelkezelo-form-yes-no">
            <label>
                <input 
                    id="labor-market-dolgozik-0" 
                    name="models[labor_market][dolgozik]" 
                    type="radio" 
                    value="0"
                    {if $LaborMarket->dolgozik === 0} checked="checked" {/if} 
                />
                Nem
            </label>            
        </div><!--/.uw-ugyfelkezelo-form-yes-no-->
        {ar_error model=$LaborMarket property='dolgozik' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
    <div id="tab-labor-market-workplace-data">
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-nev" class="item-pull-left">{$LaborMarket->getAttributeLabel('dolgozik_nev')}</label>
            <input 
                id="labor-market-dolgozik-nev" 
                name="models[labor_market][dolgozik_nev]" 
                type="text" 
                value="{$LaborMarket->dolgozik_nev}" 
            />
            {ar_error model=$LaborMarket property='dolgozik_nev' view='admin_ar_error.tpl'}
        </div><!--/.uw-ugyfelkezelo-form-row-->
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-cim" class="item-pull-left">{$LaborMarket->getAttributeLabel('dolgozik_cim')}</label>
            <input 
                id="labor-market-dolgozik-cim" 
                name="models[labor_market][dolgozik_cim]" 
                type="text" 
                value="{$LaborMarket->dolgozik_cim}" 
            />
            {ar_error model=$LaborMarket property='dolgozik_cim' view='admin_ar_error.tpl'}
        </div><!--/.uw-ugyfelkezelo-form-row-->
        <div class="uw-ugyfelkezelo-form-row">
            <label for="labor-market-dolgozik-munkakor" class="item-pull-left">{$LaborMarket->getAttributeLabel('dolgozik_munkakor')}</label>
            <input 
                id="labor-market-dolgozik-munkakor" 
                name="models[labor_market][dolgozik_munkakor]" 
                type="text" 
                value="{$LaborMarket->dolgozik_munkakor}" 
            />
            {ar_error model=$LaborMarket property='dolgozik_munkakor' view='admin_ar_error.tpl'}
        </div><!--/.uw-ugyfelkezelo-form-row-->
    </div><!--/#tab-labor-market-workplace-data-->
    <div class="uw-ugyfelkezelo-form-row">
        <label>Megjegyzés</label>
        <textarea 
            name="models[comment_labor_market][megjegyzes]" 
            class="uw-ugyfelkezelo-input-textarea-megjegyzes"
        >{if $CommentLaborMarket}{$CommentLaborMarket->megjegyzes}{/if}</textarea>
        {ar_error model=$CommentLaborMarket property='megjegyzes' view='admin_ar_error.tpl'}
    </div><!--/.uw-ugyfelkezelo-form-row-->
</div><!--/.uw-ugyfelkezelo-form-->