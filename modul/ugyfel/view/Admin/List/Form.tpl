<script type="text/javascript">
//<![CDATA[
var domainAdmin = "{$DOMAIN_ADMIN}";
    activeFilters = {if $filterOptions}{$filterOptions}{else}{literal}{}{/literal}{/if};
//]]>
</script>
<!-- #clientFilterDeleteForm --> 
<form id="clientFilterDeleteForm" method="post" action="{$DOMAIN_ADMIN}ugyfel/filter">
    <input name="_METHOD" type="hidden" value="DELETE" />
</form>
<!-- /#clientFilterDeleteForm -->
<div id="clientStatisticDialog" title="Statisztika"></div>
{include file="modul/ugyfel/view/Admin/List/Partial/Filters.tpl"}
{include file="modul/ugyfel/view/Admin/List/Partial/FilterLabels.tpl"}
{include file="modul/ugyfel/view/Admin/List/Partial/ClientDelete.tpl"}
{include file="modul/ugyfel/view/Admin/List/Partial/ProjectCreation.tpl"}
{include file="modul/ugyfel/view/Admin/List/Partial/XlsExport.tpl"}
{include file="modul/ugyfel/view/Admin/List/Partial/Flash.tpl"}
<form action="{$DOMAIN_ADMIN}ugyfel/filter" method="POST" name="{$FormName}" id="ugyfel-list-form" class="form form_list" enctype="multipart/form-data">
    <div class="box_top">
        <h2 class="icon pages">Ügyfelek</h2>
        <ul class="sorting">
            <div class="form_muvelet">
                <a href="{$DOMAIN_ADMIN}ugyfel/create">
                    <span class="ui-button-text">
                        <img class="tip" title="Új ügyfél felvétele" src="../images/admin/icons/add_data.png">
                    </span>
                </a>
                {if $filterSet}
                <button id="clientProjectCreateBtn" type="button">
                    <img class="tip" title="Új projekt létrehozása" src="../images/admin/icons/note_add.png" />
                </button>
                <button id="clientExportBtn" type="button">
                    <img class="tip" title="Keresési eredmények exportálása" src="../images/admin/icons/file_export.png" />
                </button>
                {/if}
                <button id="clientStatisticBtn" type="button">
                    <img class="tip" title="Statisztika" src="../images/admin/icons/bullet_info.png" />
                </button>
            </div>
        </ul>
    </div>
    <div class="box_content">
        <div id="dynamicFilters" class="uw-df-filters" style="padding: 20px;">
            <div id="dynamicFiltersContainer" class="uw-df-filters-container"></div>
            <div class="clear"></div>
            <div class="uw-df-filters-btns">
                <button id="clientDynamicFilterAddBtn" class="uw-df-filters-btn-dialog-open" type="button">Szűrő hozzáadása</button>
                <button id="clientFilterCreateBtn" type="submit" value="1">Keresés</button>
                {if $filterSet}<button id="clientFilterDeleteBtn" type="button" value="1">Alaphelyzet</button>{/if}
            </div>
        </div>
        {include file="modul/ugyfel/view/Admin/List/Partial/ClientsTable.tpl"}
        <div class="dataTables_wrapper">
            <div class="count">
                <label>Tételek</label>
                <select>{foreach from=$pageLimit item=limit}<option value="{$limit}">{$limit}</option>{/foreach}</select>                
            </div>
            <div class="dataTables_paginate">{$paginator}</div>
        </div>
    </div>
</form>
<script type="text/javascript" src="{$DOMAIN}js_min/admin_ugyfelkezelo_list.js"></script>
<style type="text/css">
.dataTables_paginate a {
    background: #fff;
    border-radius: 5px;
    color: #267DA6;
    font-size: 14px;
    font-weight: bold;
    margin: 4px;
    padding: 5px 10px;
}
.dataTables_paginate span {
    background: #E9E9E9;
    border-radius: 5px;
    color: #B3B3B3;
    font-size: 14px;
    margin: 4px;
    padding: 5px 10px;
}
.clientDeleteBtn {
    height: 32px;
}

#dialog-export .single-attrs {
    float: left;
    width: 33.33%;
}
#project-creator-form-name {
    width: 94%;
}

#clientDeleteDialog {
    font-size: 16px;
    padding-top: 36px;
    text-align: center;
}
</style>

<style type="text/css">
.client-xls-export-dialog-item {
    float: left;
    width: 50%;
}
</style>