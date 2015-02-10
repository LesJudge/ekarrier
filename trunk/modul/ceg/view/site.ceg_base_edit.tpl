<div class="content clearfix">
    <form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor regisztracio" enctype="multipart/form-data">
        {include file='page/all/view/page.message.tpl'}
        <h3>Belépéshez szükséges adatok</h3>
        <div class="separator"></div><!--/.separator-->
        <div class="form_row">
            <label for="{$TxtCegnev.name}">
                Cég neve
                <span class="require">*</span><!--/.require-->
            </label>
            <input id="{$TxtCegnev.name}" name="{$TxtCegnev.name}" type="text" value="{$TxtCegnev.activ}" />
            {if isset($TxtCegnev.error)}<div class="ui-state-error">{$TxtCegnev.error}</div>{/if}
        </div><!--/.form_row-->
        {block name="formLoginBlock"}{/block}
        <div class="form_row">
            <label for="{$TxtJelszo.name}">Jelszó&nbsp;<span class="require">*</span></label>
            <input type="password" id="{$TxtJelszo.name}" name="{$TxtJelszo.name}" value="{$TxtJelszo.activ}"/>
            {if isset($TxtJelszo.error)}<div class="ui-state-error">{$TxtJelszo.error}</div>{/if} 
        </div><!--/.form_row-->
        <div class="form_row">
            <label for="{$TxtJelszoUjra.name}">Jelszó újra&nbsp;<span class="require">*</span></label>
            <input type="password" id="{$TxtJelszoUjra.name}" name="{$TxtJelszoUjra.name}" value="{$TxtJelszoUjra.activ}"/>
            {if isset($TxtJelszoUjra.error)}<div class="ui-state-error">{$TxtJelszoUjra.error}</div>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        {block name="formMiddleBlock"}{/block}
        <h3>Kapcsolattartó adatai</h3>
        <div class="separator"></div><!--/.separator-->
        <div class="form_row">
            <label for="{$TxtKtoNev.name}">
                Név
                <span class="require">*</span><!--/.require-->
            </label>
            <input id="{$TxtKtoNev.name}" name="{$TxtKtoNev.name}" type="text" value="{$TxtKtoNev.activ}" />
            {if isset($TxtKtoNev.error)}<div class="ui-state-error">{$TxtKtoNev.error}</div>{/if}
        </div><!--/.form_row-->
        <div class="form_row">
            <label for="{$TxtKtoEmail.name}">
                E-mail
                <span class="require">*</span><!--/.require-->
            </label>
            <input id="{$TxtKtoEmail.name}" name="{$TxtKtoEmail.name}" type="text" value="{$TxtKtoEmail.activ}" />
            {if isset($TxtKtoEmail.error)}<div class="ui-state-error">{$TxtKtoEmail.error}</div>{/if}
        </div><!--/.form_row-->
        <div class="form_row">
            <label for="{$TxtKtoTel.name}">
                Telefon
                <span class="require">*</span><!--/.require-->
            </label>
            <input id="{$TxtKtoTel.name}" name="{$TxtKtoTel.name}" type="text" value="{$TxtKtoTel.activ}" />
            {if isset($TxtKtoTel.error)}<div class="ui-state-error">{$TxtKtoTel.error}</div>{/if}
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        {block name="formBottomBlock"}{/block}
        <button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="reg" type="submit">{$btnSaveLabel}</button>
    </form>
</div><!--/.content.clearfix-->
{block name="includesBlock"}{/block}
{block name=jsBlock}{/block}