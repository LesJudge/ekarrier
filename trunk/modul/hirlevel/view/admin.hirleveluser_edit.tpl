<script type="text/javascript">
$(function() { {$FormScript}
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
    <div class="grid_18">
    	<div class="box_top">
            <h2 class="icon time">Hírlevél személy - [{$edit_mode}]</h2>
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
					<label for="{$TxtEmail.name}">E-mail cím <span class="require">*</span></label>
					<input type="text" id="{$TxtEmail.name}" name="{$TxtEmail.name}" value="{$TxtEmail.activ}"/>
					{if isset($TxtEmail.error)}<p class="error small">{$TxtEmail.error}</p>{/if} 
                </div><div class="clear"></div>
                <div class="form_row">
                    <label for="{$SelKapcsolatNyelv.name}">Kapcsolat nyelve</label>
                    {html_options name=$SelKapcsolatNyelv.name options=$SelKapcsolatNyelv.values selected=$SelKapcsolatNyelv.activ}
                    {if isset($SelKapcsolatNyelv.error)}<p class="error small">{$SelKapcsolatNyelv.error}</p>{/if}
                </div>
                <div class="form_row">
                    <label for="{$SelCsoport.name}">Csoport</label>
                    {html_checkboxes name=$SelCsoport.name options=$SelCsoport.values selected=$SelCsoport.activ separator=''}
                    {if isset($SelCsoport.error)}<p class="error small">{$SelCsoport.error}</p>{/if}
				</div><div class="clear"></div>
            </div>
        </div>
    </div>
    {if isset($hirlevel_user_feliratkozas)}
    	<div class="grid_6"> 
        	<div class="box_top">
            	<h2 class="icon time">Információ</h2>
            </div>
            <div class="box_content padding">
                <div class="form_row"> <strong>Feliratkozás dátuma:</strong> {$hirlevel_user_feliratkozas} </div><div class="clear"></div>
				{if $hirlevel_user_leiratkozva}
					<div class="form_row"> <strong>Leiratkozás dátuma:</strong>{$hirlevel_user_leiratkozas}</div><div class="clear"></div>
				{/if}
                {if $user_id}
                    <div class="form_row"> <a href="{$DOMAIN_ADMIN}/user/edit/{$user_id}" target="_blank">Felhasználó megtekintése</a></div><div class="clear"></div>
                {/if}
            </div>
      	</div>
    {/if}
</form>