<style type="text/css">
.sheepit-item
{
        border:1px solid;
        border-radius:5px;
        margin-bottom:10px;
        padding:10px;
        width:50%;
}
.sheepit-item-head
{
        padding-bottom:10px;
}
.sheepit-item-head label
{
        margin:0px;
}
.sheepit-item-body .sheepit-item-body-row
{
        margin-bottom:5px;
}
.sheepit-item-body .sheepit-item-body-row:after
{
        content:"";
        clear:both;
        display:block;
}

.tevekenyseg-sheepit-item
{
        background:#ffffcc;
}
</style>

<div id="sheepItForm">
        <div id="sheepItForm_template">
                <div class="sheepit-item tevekenyseg-sheepit-item">
                        <div class="sheepit-item-head">
                                <label for="sheepItForm_#index#_tevekenyseg">Tevékenység <span id="sheepItForm_label"></span></label>
                        </div>
                        
                        <div class="sheepit-item-body">
                                <div class="sheepit-item-body-row">
                                        <input id="sheepItForm_#index#_activityName" name="activity[#index#][activityName]" class="tevekenyseg-input" type="text"/>
                                        <input id="sheepItForm_#index#_activityId" name="activity[#index#][activityId]" value="" type="hidden" readonly="readonly" />
                                </div>
                                
                                <div class="sheepit-item-body-row">
                                        <select id="sheepItForm_#index#_competenceId" name="activity[#index#][competenceId]">
                                                {foreach from=$competences key=id item=name}
                                                <option value="{$id}">{$name}</option>
                                                {/foreach}
                                        </select>
                                </div>
                                
                                <div class="sheepit-item-body-row">
                                        <input id="sheepItForm_#index#_isNewRecord" name="activity[#index#][isNewRecord]" type="hidden" readonly="readonly" value="0" />
                                </div>
                                
                                <div class="sheepit-item-body-row" style="height:30px;">
                                        <a id="sheepItForm_remove_current">
                                                <img class="delete" src="../images/admin/icons/cancel.png" width="20" height="20" border="0" alt="delete" />
                                                <div class="clear"></div>
                                        </a>
                                        
                                </div>
                        </div>
                        <div class="clear"></div>
                </div><div class="clear"></div>
        </div>
        <div id="sheepItForm_noforms_template">
                <div class="ui-state-error ui-corner-all" style="padding:5px 10px;">Ehhez a munkakörhöz jelenleg nem tartozik egy tevékenység sem!</div>
        </div>

        <div id="sheepItForm_controls">
                <div id="sheepItForm_add">
                        <a>
                                <img class="add tip" title="Elem hozzáadása" src="../images/admin/icons/add_data.png" width="25" height="25" border="0" alt="add"/>
                                <span>Elem hozzáadása</span>
                        </a>
                </div>
        </div>
</div>