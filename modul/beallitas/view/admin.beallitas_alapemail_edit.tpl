<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
});
/*]]>*/
</script>

<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Alapértelmezett email - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'} 
                        <div class="field">
                                <div class="form_row">
                                        <label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
                                        <input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
                                        {if isset($TxtEmail.error)}<p class="error small">{$TxtEmail.error}</p>{/if}
                                </div><div class="clear"></div>
                                
                                <div class="form_row">
                                        <label>Publikus <span class="require">*</span></label>
                                        {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                                        {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                                </div><div class="clear"></div>
                        </div>
                </div>
        </div>
        {if isset($beallitas_email_modositas_datum)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$beallitas_email_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$beallitas_email_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$email_allapot} </div><div class="clear"></div>
                </div>
        </div>
        {/if}
</form>