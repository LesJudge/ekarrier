<script type="text/javascript" src="../js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript">
$(function() { {$FormScript}
    var sheepItForm = $('#sheepItForm').sheepIt({
            separator: '', 
            allowRemoveLast: true, 
            allowRemoveCurrent: true, 
            allowAdd: true, 
            minFormsCount: 0, 
            iniFormsCount: 1,
            removeCurrentConfirmation: true,
            removeCurrentConfirmationMsg: 'Biztosan törlöd a kiválasztott mezőt ?',
            afterAdd: function(source, newForm) {
                changeSelect();
            }, 
    });
    $('div.tabs').tabs();
    // Hosszúság ellenőrzése.
    $('input[id^="Length"]').live('blur', function(){
        var val = parseInt($(this).val())
        if(!isFinite(val) || val < 0)
        {
            val = '';
        }
        $(this).val(val);
    });
    // Checkboxok beállítása.
    $('input[type="checkbox"]').live('click', function(){
        var value = $(this).attr('checked') ? 1 : 0;
        $(this).val(value);
    });
    // "Aktív" checkboxok kiválasztása.
    var checkedCheckboxes = $('input[type="checkbox"][value="1"]');
    // Checked osztályt ad a szülő <span>-nak, valamint átállítja a checkbox checked attribútumát.
    $(checkedCheckboxes).parent().addClass('checked');
    $(checkedCheckboxes).attr('checked', 'checked');
    
    function changeSelect()
    {
        $('select').change(function(){
            $(this).parent().find('span').html($(this).find('option:selected').text());
        });    
    }
    
    $('select').each(function(){
        $(this).parent().find('span').html($(this).find('option:selected').text());
    });
}) 
</script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
	<div class="grid_24">
    	<div class="box_top">
            <h2 class="icon time">Modulgeneráló V2</h2>
            {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
		</div>
        <div class="box_content padding">
			{include file='page/admin/view/admin.message.tpl'}
			{include file='page/admin/view/admin.edit_events.tpl'} 
            <div class="tabs">
                <ul class="tabs ">
                    <li><a href="#tabs-1">Alap adatok</a></li>
                    <li><a href="#tabs-2">Mezők</a></li>
                    <li><a href="#tabs-3">Egyéb adatok</a></li>
		</ul>
                {if $info}<strong>{$info}</strong>{/if}
            <div id="tabs-1" class="field">
                
                <div class="form_row">
                    <label for="{$TxtModulNev.name}">Generálandó modul neve <span class="require">*</span></label>
                    <input type="text" id="{$TxtModulNev.name}" name="{$TxtModulNev.name}" value="{$TxtModulNev.activ}"/>
                    {if isset($TxtModulNev.error)}<p class="error small">{$TxtModulNev.error}</p>{/if}
		</div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$TxtTablaNev.name}">Modulhoz tartozó tábla neve <span class="require">*</span></label>
                    <input type="text" id="{$TxtTablaNev.name}" name="{$TxtTablaNev.name}" value="{$TxtTablaNev.activ}"/>
                    {if isset($TxtTablaNev.error)}<p class="error small">{$TxtTablaNev.error}</p>{/if}
                </div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$TxtPublikusNev.name}">Modul publikus neve <span class="require">*</span></label>
                    <input type="text" id="{$TxtPublikusNev.name}" name="{$TxtPublikusNev.name}" value="{$TxtPublikusNev.activ}"/>
                    {if isset($TxtPublikusNev.error)}<p class="error small">{$TxtPublikusNev.error}</p>{/if}
                </div><div class="clear"></div>
                
            </div>
                                    
            <div id="tabs-2" class="field">
                <div class="form_row">
                    <label>Mezők</label>
                    <table>
                        <tr>
                            <th>Mező neve (táblában)</th>
                            <th>Mező típusa (táblában)</th>
                            <th>Érték hossza</th>
                            <th>NOT NULL</th>
                            <th>Alapértelmezett érték</th>
                            <th>Mező neve (formban)</th>
                            <th>Mező neve (label)</th>
                            <th>Mező típusa (formban)</th>
                            <th>Kötelező ?</th>
                            <th>addForm</th>
                            <th>Listázza</th>
                            <th>Törlés</th>
                        </tr>
                    </table>
                    <div id="sheepItForm">
                        <div id="sheepItForm_template">
                            <table>
                                <tr>
                                    <td><input id="Name_#index#" name="Fields[#index#][Name]" type="text" style="width:170px;" /></td>
                                    <td>{html_options name="Fields[#index#][Type]" options=$TypeSel.values}</td>
                                    <td><input id="Length_#index#" name="Fields[#index#][Length]" type="text" style="width:40px;" /></td>
                                    <td>{html_options name="Fields[#index#][NotNull]" options=$TrueOrFalseSel.values}</td>
                                    <td><input id="Default_#index#" name="Fields[#index#][Default]" type="text" style="width:100px;" /></td>
                                    <td><input id="Fieldname_#index#" name="Fields[#index#][Fieldname]" type="text" style="width:170px;" /></td>
                                    <td><input id="Fieldlabel_#index#" name="Fields[#index#][Fieldlabel]" type="text" style="width:170px;" /></td>
                                    <td>{html_options name="Fields[#index#][Fieldtype]" options=$FieldtypeSel.values}</td>
                                    <td>{html_options name="Fields[#index#][Fieldrequired]" options=$TrueOrFalseSel.values}</td>
                                    <td>{html_options name="Fields[#index#][addForm]" options=$TrueOrFalseSel.values}</td>
                                    <td>{html_options name="Fields[#index#][listField]" options=$TrueOrFalseSel.values}</td>
                                    <td>
                                        <a id="sheepItForm_remove_current">
                                            <img class="delete" src="../images/admin/icons/cancel.png" width="16" height="16" border="0"/>
                                        </a>
                                    </td>
                                </tr>
                            </table>					      	
                        </div>		                  		
                        <div id="sheepItForm_noforms_template">
                            <p style="padding:5px;margin-bottom:-5px;"><strong>Klikk ide! ;)</strong></p>
                        </div>
                        <div class="clear"></div>
                        <div id="sheepItForm_controls">
                            <div id="sheepItForm_add"><a><img class="add" src="../images/admin/icons/add_data.png" width="25" height="25" border="0"/></a></div>
                        </div>
                    </div>
                </div>
            </div>
                                    
            <div id="tabs-3" class="field">
                <div class="form_row">
                    <label for="{$ChkNyelvesitett.name}">Nyelvesítés <span class="require">*</span></label>
                    <input id="{$ChkNyelvesitett.name}" name="{$ChkNyelvesitett.name}" type="checkbox" value="{$ChkNyelvesitett.activ}" />
                    {if isset($ChkNyelvesitett.error)}<p class="error small">{$ChkNyelvesitett.error}</p>{/if}
		</div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$ChkValidacio.name}">Automatikus validáció <span class="require">*</span></label>
                    <input id="{$ChkValidacio.name}" name="{$ChkValidacio.name}" type="checkbox" value="{$ChkValidacio.activ}" />
                    {if isset($ChkValidacio.error)}<p class="error small">{$ChkValidacio.error}</p>{/if}
		</div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$ChkSheepit.name}">Használjon sheepIt-et ? <span class="require">*</span></label>
                    <input id="{$ChkSheepit.name}" name="{$ChkSheepit.name}" type="checkbox" value="{$ChkSheepit.activ}" />
                    {if isset($ChkSheepit.error)}<p class="error small">{$ChkSheepit.error}</p>{/if}
		</div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$ChkTinyMCE.name}">Használjon TinyMCE-t ? <span class="require">*</span></label>
                    <input id="{$ChkTinyMCE.name}" name="{$ChkTinyMCE.name}" type="checkbox" value="{$ChkTinyMCE.activ}" />
                    {if isset($ChkTinyMCE.error)}<p class="error small">{$ChkTinyMCE.error}</p>{/if}
		</div><div class="clear"></div>
                
                <div class="form_row">
                    <label for="{$ChkprettyPhoto.name}">Használjon prettyPhoto-t ? <span class="require">*</span></label>
                    <input id="{$ChkprettyPhoto.name}" name="{$ChkprettyPhoto.name}" type="checkbox" value="{$ChkprettyPhoto.activ}" />
                    {if isset($ChkprettyPhoto.error)}<p class="error small">{$ChkprettyPhoto.error}</p>{/if}
		</div><div class="clear"></div>
            </div>
                                    
            </div>
      </div>
	</div>

</form>