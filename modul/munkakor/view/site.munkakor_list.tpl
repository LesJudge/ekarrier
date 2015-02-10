{include file="page/all/view/partial/jobTooltips.tpl"}
<style type="text/css">
.ek-job-main {
    clear: both;
    font-size: 16px;
    font-weight: bold;
    display: block;
    margin-bottom: 15px;
    margin-top: 10px;
}
.ek-job-sub {
    
}
</style>
<h1 class="pageName">{$pageTitle}</h1>
<form action="" method="POST" name="{$FormName}" id="{$FormName}" enctype="multipart/form-data">
    <div class="jobDataForm-cont">
        <div class="jobDataForm-top"><i class='icomoon icomoon-search'>&nbsp;</i></div>
        
        {foreach from=$parents key=key item=value}
            <div onClick="$('.subCats'+{$key}).toggle()" class="ek-job-main">
                <span>
                    <i class="icomoon icomoon-plus">&nbsp;</i>
                </span>
                <span>{$value['cim']}</span>
            </div>
            <div class="ek-job-sub">
            {foreach from=$value['ids'] key=key2 item=value2}
                {foreach from=$FilterKategoriak.values item=category}
                    {if $value2==$category.munkakor_kategoria_id}
                    <div class="subCats{$key}" style='display:none'>
                    <div class="jobDataForm-block">
                        <!--
                        <input 
                            name="{$FilterKategoriak.name}[{$category.munkakor_kategoria_id}]" 
                            type="checkbox" 
                            value="{$category.munkakor_kategoria_id}" 
                            {if is_array($FilterKategoriak.activ) and in_array($category.munkakor_kategoria_id, $FilterKategoriak.activ)} checked{/if}
                        />
                        <label for="job{$category.munkakor_kategoria_id}">{$category.kategoria_cim}</label>
                        -->
                        <label for="job{$category.munkakor_kategoria_id}">
                            <input 
                                name="{$FilterKategoriak.name}[{$category.munkakor_kategoria_id}]" 
                                type="checkbox" 
                                style="margin: 5px !important;"
                                value="{$category.munkakor_kategoria_id}" 
                                {if is_array($FilterKategoriak.activ) and in_array($category.munkakor_kategoria_id, $FilterKategoriak.activ)} checked{/if}
                            />
                            {$category.kategoria_cim}
                        </label>
                    </div>
                    </div>
                    {/if}
               {/foreach}
            {/foreach}
            <div class="clear"></div>
            </div>
        {/foreach}
        
        
        <!--
        {foreach from=$FilterKategoriak.values item=category}
        <div class="jobDataForm-block">
            <input 
                name="{$FilterKategoriak.name}[{$category.munkakor_kategoria_id}]" 
                type="checkbox" 
                value="{$category.munkakor_kategoria_id}" 
                {if is_array($FilterKategoriak.activ) and in_array($category.munkakor_kategoria_id, $FilterKategoriak.activ)} checked{/if}
            />
            <label for="job{$category.munkakor_kategoria_id}">{$category.kategoria_cim}</label>
        </div>
        {/foreach}
        -->
        <div class="clear"></div>
        <input type="text" name="{$TxtSearchByName.name}" value="{$TxtSearchByName.activ}">
        <input class="submit" type="submit" id="{$BtnFilter}" name="{$BtnFilter}" value="Keresés">
        <input class="submit" type="submit" name="{$BtnFilterDEL}" value="Feltételek törlése">
        <div class="clear"></div>
    </div>
        
            
</form>
<div class="jobFindList-cont">
    <div class="jobFindList-top"><i class='icomoon icomoon-file3'>&nbsp;</i></div>
    <div class="jobFindList-title">Találati eredmények</div>
    {include file='page/all/view/page.message.tpl'}
    {if not empty($Lista)}
    {foreach from=$Lista item=munkakor}
    <div class="jobFindList-block">
        {$munkakor.munkakor_nev}
        <a href="{$DOMAIN}munkakorok/{$munkakor.munkakor_link}">Részletek</a>
        <div class="clear"></div>
    </div>
    {/foreach}
    {/if}
    <div class="clear"></div>
    {include file='page/all/view/page.paging.tpl'}
</div>
