
{if $tooltips}
<style type="text/css"> .site_body_container { margin-top:25px;} </style>
<div class="breadCrumb-cont">
	<div class="breadCrumb-mask"></div>
	<div class="breadCrumb">
        {foreach from=$tooltips item=tooltip}
        <div class="breadCrumb-item tip{if $activeTooltip|default:1 eq $tooltip.value} breadCrumb-active{/if}" title="{$tooltip.description}">
        	<div class="label"><span>{$tooltip.label}</span></div>
        </div>
        {/foreach}
		<div class="clear"></div>
	</div>	    
</div>
{/if}