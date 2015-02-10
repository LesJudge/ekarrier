<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        $("#{$TxtNev.name}").removeAccents({ target: $("#{$TxtLink.name}"), bind:"change" });
        $("#{$TxtLink.name}").removeAccents();
        $("#{$TxtKulcsszo.name}").autoSuggest("",{ neverSubmit: true, showResultList:false, asHtmlID:'{$TxtKulcsszo.name}', preFill: '{$TxtKulcsszo.activ}', selectionRemoved: function(elem){ elem.remove();if($("li.as-selection-item").length == 0){ $("input[type='hidden']").attr("value", ""); }; } });
        $(".as-selection-item").addClass("ui-widget-content");
        $(".as-selections").addClass("ui-widget-content");
        $('select[name="{$SelKapcsolodo.name}[]"]').multiselect().multiselectfilter();
        $('select[name="{$SelKategoria.name}[]"]').multiselect().multiselectfilter();
        $("#tabs").tabs();
        
        // Meglévő tevékenységek
        var availableTags={$tags};
        // sheepItForm
        var sheepItForm = $('#sheepItForm').sheepIt({
                separator: '',
                allowRemoveLast: true,
                allowRemoveCurrent: true,
                allowRemoveAll: true,
                allowAdd: true,
                allowAddN: true,
                maxFormsCount: 0,
                minFormsCount: 0,
                iniFormsCount: 0,
                continousIndex:false,
                afterAdd:function(source,newForm){
                        var position=newForm.getPosition()-1;
                        //console.log(position);
                        //console.log(newForm);
                        //console.log(this.formTemplateSelector);
                        //console.log($(newForm).attr("id"));
                        var data=this.data[position];
                        var competenceId=(data) ? data["sheepItForm_#index#_competenceId"] : false;
                        if(competenceId){
                                var $select=$(newForm).find("select"),
                                      $option=$select.find("option:nth-child("+competenceId+")");
                                $option.attr("selected","selected");
                                $select.prev().text($option.text());                        
                        }
                },
                data:{$relatedActivities}
        });
        // A már felvett tevékenység inputok inicializálása.
        $(".tevekenyseg-input").live("click",function(){
                $(this).autocomplete({
                        source: availableTags,
                        minLength:1,
                        select:function(event,ui){
                                //console.log("Select event fired!");
                                $(this).val(ui.item.label);
                                $(this).next("input").val(ui.item.value);
                                return false;
                        },
                        change:function(event,ui){
                                var parent=$(this).parents(".tevekenyseg-sheepit-item"),isNewRecord=0;
                                if(!ui.item || !ui.item.label || !ui.item.value){
                                        $(this).next("input").val(0);
                                        isNewRecord=1;
                                        //console.log("I'm not an Object!");
                                }
                                parent.find("input[id$=\"isNewRecord\"]").val(isNewRecord);
                                return false;
                        }
                });
        });
});
/*]]>*/
</script>
<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>
<form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor " enctype="multipart/form-data">
        <div class="grid_18">
                <div class="box_top">
                        <h2 class="icon time">Munkakör - [{$edit_mode}]</h2>
                        {include file='modul/nyelv/view/admin.nyelv_editor_select.tpl'} 
                </div>
                
                <div class="box_content padding">
                        {include file='page/admin/view/admin.message.tpl'}
                        {include file='page/admin/view/admin.edit_events.tpl'} 
                        <div id="tabs" style="width:90%;">
                                <ul>
                                        <li><a href="#tabs-1">Alap adatok</a></li>
                                        <li><a href="#tabs-2">Tartalom</a></li>
                                        <li><a href="#tabs-3">Elvárások</a></li>
                                        <li><a href="#tabs-4">Tevékenységek</a></li>
                                </ul>
                                
                                <div id="tabs-1">{include file="$partialViewsDir/tab1_alap_adatok.tpl"}</div>
                                <div id="tabs-2">{include file="$partialViewsDir/tab2_tartalom.tpl"}</div>
                                <div id="tabs-3">{include file="$partialViewsDir/tab3_elvarasok.tpl"}</div>
                                <div id="tabs-4">{include file="$partialViewsDir/tab4_tevekenyseg.tpl"}</div>
                        </div><!-- #tabs -->
                </div>
        </div>
        
        {if isset($munkakor_create_date)}
        <div class="grid_6"> 
                <div class="box_top">
                        <h2 class="icon time">Információ</h2>
                </div>
                
                <div class="box_content padding">
                        <div class="form_row">
                                <strong>Megtekintve:</strong> {$munkakor_megtekintve} 
                                <input class="submit" style="margin-left: 10px; padding: 1px;" type="submit" name="{$BtnDeleteMegtekintes}" value="Törlés"/>
                        </div><div class="clear"></div>
                        <div class="form_row"> <strong>Javítások száma:</strong> {$munkakor_javitas_szama} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozva:</strong> {$munkakor_create_date} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Létrehozó:</strong> {$munkakor_letrehozo} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utoljára módosítva:</strong> {$munkakor_modositas_datum} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Utolsó módosító:</strong> {$munkakor_modosito} </div><div class="clear"></div>
                        <div class="form_row"> <strong>Pillanatnyi állapot:</strong> {$munkakor_allapot} </div><div class="clear"></div>
                </div>
        </div><!-- .grid_6 -->
        {/if}
</form>