<div class="siteTab-inner">
	<div class="form_row">    
		<textarea class="tinymce" id="{$TxtJelMod.name}" name="{$TxtJelMod.name}" cols="30" rows="3">{$TxtJelMod.activ}</textarea>		
		{if isset($TxtJelMod.error)}<p class="error small">{$TxtJelMod.error}</p>{/if}
	</div>
	<div class="clear"></div>
        
        <div class="form_row">
            <label for="{$DateJelentkezesHatarideje.name}">
                Jelentkezés határideje
            </label>
            {if $DateJelentkezesHatarideje.activ == '0000-00-00'}    
                <input id="{$DateJelentkezesHatarideje.name}" name="{$DateJelentkezesHatarideje.name}" type="text" value="" />
            {else}
                <input id="{$DateJelentkezesHatarideje.name}" name="{$DateJelentkezesHatarideje.name}" type="text" value="{$DateJelentkezesHatarideje.activ}" />
            {/if}
            {if isset($DateJelentkezesHatarideje.error)}<p class="error small">{$DateJelentkezesHatarideje.error}</p>{/if}
        </div>
        <div class="clear"></div>
</div>	