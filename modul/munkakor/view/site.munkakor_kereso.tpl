{include file="page/all/view/partial/jobTooltips.tpl"}
<h1 class="pageName">Munkakörök</h1>
<div class="jobDataForm-cont">
    <div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
    {foreach from=$categories item=category}
    <div class="jobDataForm-block">
        
        <a href="{$DOMAIN}munkakor-kereso/{$category.kategoria_link}">{$category.menu_nev}</a>
        
    </div>
    {/foreach}
    <div class="clear"></div>
    
</div>