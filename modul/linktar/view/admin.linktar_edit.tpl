<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
    $('select[name="{$SelKategoria.name}[]"]').multiselect().multiselectfilter();
});
/*]]>*/
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
    <div class="box_top">
        <h2 class="icon time">Linktár - [{$edit_mode}]</h2>
        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
    </div>
        
    <div class="box_content padding">
        {include file='page/admin/view/admin.message.tpl'}
        {include file='page/admin/view/admin.edit_events.tpl'} 
        <div class="field">

            <div class="form_row">
                <label for="{$TxtNev.name}">Név <span class="require">*</span></label>
                <input type="text" id="{$TxtNev.name}" name="{$TxtNev.name}" value="{$TxtNev.activ}"/>
                {if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if}
            </div><div class="clear"></div>

            <div class="form_row">
                <label for="{$TxtLink.name}">Link <span class="require">*</span></label>
                <input type="text" id="{$TxtLink.name}" name="{$TxtLink.name}" value="{$TxtLink.activ}" />
                {if isset($TxtLink.error)}<p class="error small">{$TxtLink.error}</p>{/if}
            </div><div class="clear"></div>
            
            <div class="form_row">
                <label for="{$SelKategoria.name}">Kategória <span class="require">*</span></label>
                {html_options multiple name=$SelKategoria.name options=$SelKategoria.values selected=$SelKategoria.activ}  
                {if isset($SelKategoria.error)}<p class="error small">{$SelKategoria.error}</p>{/if}
            </div><div class="clear"></div>
            
            <div class="form_row">
                <label>Publikus <span class="require">*</span></label>
                {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
            </div><div class="clear"></div>
            
        </div>
    </div>
    </div>
</form>