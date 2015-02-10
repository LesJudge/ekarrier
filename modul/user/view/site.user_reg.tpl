<link type="text/css" rel="stylesheet" media="screen" href="./css/QapTcha.css" />
<script type="text/javascript" src="./js/captcha/jquery.ui.touch.js"></script>
<script type="text/javascript" src="./js/captcha/QapTcha.jquery.js"></script>
<script type="text/javascript" src="./js/ui/i18n/jquery.ui.datepicker-hu.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {*$FormScript*}
    $('#QapTcha').QapTcha({
        disabledSubmit: true,
        autoRevert: true,
        submitID:'{$BtnSave}'
    });
    var date = new Date(),
        year = date.getFullYear() - 18;

    $("#{$DateSzulIdo.name}").datepicker({
        yearRange: '1950:' + year
    });
});
/*]]>*/
</script>
<style type="text/css">
.select-cont {
    width: 260px;
}
</style>

<div class="content clearfix">
    <form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor regisztracio" enctype="multipart/form-data">
        <div>{$regcontent[0].tartalom_tartalom}</div>
        {include file='page/all/view/page.message.tpl'} 
        {include file='modul/user/view/partial/site.user_edit_form_fields.tpl'}
        <div class="feltetelek form-row">
        {$altalanos_szerzodesi_feltetelek}
        </div>
        <div class="clear"></div>
        <div class="form-row">
            <label for="{$ChkElfogad.name}" style="width:250px;">Felhasználási feltételeket elfogadom</label>
            <input type="checkbox" name="{$ChkElfogad.name}" id="{$ChkElfogad.name}" style="height:auto;" value="1" {if $ChkElfogad.activ}checked="checked"{/if}/>
            {if isset($ChkElfogad.error)}<div class="ui-state-error">{$ChkElfogad.error}</div>{/if} 
        </div>
        <div class="clear"></div>
        <div class="form-row">
            <label  style="width:250px;">Kérjük a csúszkát húzza el.</label>
            <div id="QapTcha"></div>
        </div>
        <div class="clear"></div>
        <button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="reg" type="submit">Regisztrál</button>
    </form>
</div>