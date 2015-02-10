<script type="text/javascript" src="./js/ui/i18n/jquery.ui.datepicker-hu.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    
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
                
                {include file='modul/ceg/view/partial/site.ceg_edit_form_fields.tpl'}
                
                <button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="reg" type="submit">Módosít</button>
        </form>
</div>