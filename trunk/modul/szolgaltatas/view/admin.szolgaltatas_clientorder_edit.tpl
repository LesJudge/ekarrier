<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() {
    {$FormScript}
});
/*]]>*/
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
        <div class="box_top">
            <h2 class="icon time">Szolgáltatás - [{$edit_mode}]</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
        </div>
        <div class="box_content padding">
            {include file='page/admin/view/admin.message.tpl'}
            <div class="form_muvelet">
                <a><button class="submit tip" name="{$BtnSave}" id="{$BtnSave}" value="{$LANG["Mentés"]}" title="{$LANG["Mentés"]}"><img src="../images/admin/icons/save.png" alt="{$LANG["Mentés"]}" /></button></a>
                <a href="{$DOMAIN_ADMIN}szolgaltatas/clientorderlist/" id="{$FormName}_close"><img class="tip" title="{$LANG["Mégsem"]}" src="../images/admin/icons/cancel.png" alt="{$LANG["Mégsem"]}"/></a>
        </div>
           
            <div class="form_row" style="display:none">
                  <label>Cég:&nbsp;<span class="require">*</span></label>
                  {html_options name=$SelUgyfel.name options=$SelUgyfel.values selected=$SelUgyfel.activ} 
                  {if isset($SelUgyfel.error)}
                  <p class="error small">{$SelUgyfel.error}</p>
                  {/if} 
                  
             </div>
             <div class="form_row">
                  <label for="ugyfelnev">Ügyfél:&nbsp;<span class="require">*</span></label>
                  <input type="text" id="" name="" value="{$ugyfelnev}" readonly="readonly"/>
            </div>
             
             <div class="clear"></div>
             <div class="form_row">
                  <label>Szolgáltatás:&nbsp;<span class="require">*</span></label>
                  {html_options name=$SelSzolgaltatas.name options=$SelSzolgaltatas.values selected=$SelSzolgaltatas.activ} 
                  {if isset($SelSzolgaltatas.error)}
                  <p class="error small">{$SelSzolgaltatas.error}</p>
                  {/if} 
            </div>
            <div class="clear"></div>
            <div class="form_row">
                  <label>Státusz:&nbsp;<span class="require">*</span></label>
                  {html_options name=$SelOrderStatusz.name options=$SelOrderStatusz.values selected=$SelOrderStatusz.activ} 
                  {if isset($SelOrderStatusz.error)}
                  <p class="error small">{$SelOrderStatusz.error}</p>
                  {/if} 
            </div>
            <div class="clear"></div>
            
            {foreach from=$clients.ugyfelek_mappakbol item=client}
            {$client}<br/>
            
            {/foreach}
            {foreach from=$clients.ugyfelek_jelentkezettek item=client}
            {$client}<br/>
            
            {/foreach}
            
            
            <div class="field">
                <div class="form_row">
                    <label>Publikus <span class="require">*</span></label>
                    {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                    {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    {if isset($recordStatus) and $recordStatus eq true}
    {include file="page/admin/view/admin.record_status.tpl"}
    {/if}
</form>