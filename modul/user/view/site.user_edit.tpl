<script type="text/javascript" src="./js/ui/i18n/jquery.ui.datepicker-hu.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
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
                
				<div class="form-row">
                <button class="submit btn btn-primary" name="{$BtnSave}" id="{$BtnSave}" value="reg" type="submit">Módosít</button>
				</div>
        </form>
</div>