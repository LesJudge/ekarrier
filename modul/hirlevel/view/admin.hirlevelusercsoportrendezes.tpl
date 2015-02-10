<link type="text/css" rel="stylesheet" media="screen" href="../css/jquery.multiselect2.css" />
<script type="text/javascript">
$(function() { {$FormScript}
    $('select[name="{$SelUser.name}[]"]').multiselect_two();
     $('select[name="{$SelCsoport.name}"]').change(function() { $('#{$BtnReload}').click(); });
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">  
    <div class="grid_24">
    	<div class="box_top">
            <h2 class="icon time">Hírlevél csoport rendezés - {$hirlevel_csoport_nev} ( {$nyelv_nev} )</h2>
        </div>
        <div class="box_content padding">
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'}				  
            <div class="field">
                <div class="form_row">
                    {html_options name=$SelCsoport.name options=$SelCsoport.values selected=$SelCsoport.activ}<br />
                    <label for="{$SelUser.name}">&nbsp;</label>
                    {html_options multiple name=$SelUser.name options=$SelUser.values selected=$SelUser.activ}
                    {if isset($SelUser.error)}<p class="error small">{$SelUser.error}</p>{/if} 
                </div><div class="clear"></div>
            </div>
        </div>
    </div>
    <p style="display:none;"><input class="submit" name="{$BtnReload}" id="{$BtnReload}" value="reload" title="reload" type="submit"/></p>
</form>