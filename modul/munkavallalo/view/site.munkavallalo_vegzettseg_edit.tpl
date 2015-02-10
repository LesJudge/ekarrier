<script type="text/javascript">
/*<![CDATA[*/
$(function() { {$FormScript}
        //
});
/*]]>*/
</script>

<div class="content clearfix">
        <form action="" method="post" name="{$FormName}" id="{$FormName}" class="form form_editor regisztracio" enctype="multipart/form-data">
                {include file='page/all/view/page.message.tpl'}
                                
                {if !$FormError}
                <div class="form-row">
                        <label for="{$SelVegzettseg.name}">Végzettség <span class="require">*</span></label>
                        {html_options name=$SelVegzettseg.name id=$SelVegzettseg.name options=$SelVegzettseg.values selected=$SelVegzettseg.activ} 
                        {if isset($SelVegzettseg.error)}<div class="ui-state-error">{$SelVegzettseg.error}</div>{/if}
                </div><div class="clear"></div>
                
                <div class="form-row">
                        <label for="{$TxtIskola.name}">Iskola <span class="require">*</span></label>
                        <input id="{$TxtIskola.name}" name="{$TxtIskola.name}" type="text" value="{$TxtIskola.activ}" />
                        {if isset($TxtIskola.error)}<div class="ui-state-error">{$TxtIskola.error}</div>{/if}
                </div><div class="clear"></div>
                        
                <div class="">
                        <label for="{$TxtSzak.name}">Szak</label>
                        <input id="{$TxtSzak.name}" name="{$TxtSzak.name}" type="text" value="{$TxtSzak.activ}" />
                        {if isset($TxtSzak.error)}<div class="ui-state-error">{$TxtSzak.error}</div>{/if}
                </div><div class="clear"></div>
                
                <div class="form-row">
                        <label for="{$YearKezdet.name}">Kezdet <span class="require">*</span></label>
                        <input id="{$YearKezdet.name}" name="{$YearKezdet.name}" type="text" value="{$YearKezdet.activ}"/>
                        {if isset($YearKezdet.error)}<div class="ui-state-error">{$YearKezdet.error}</div>{/if} 
                </div><div class="clear"></div>
                
                <div class="form-row">
                        <label for="{$YearVeg.name}">Vég <span class="require">*</span></label>
                        <input id="{$YearVeg.name}" name="{$YearVeg.name}" type="text" value="{$YearVeg.activ}" />
                        {if isset($YearVeg.error)}<div class="ui-state-error">{$YearVeg.error}</div>{/if}
                </div><div class="clear"></div>
                
                <div class="form_row">
                      <label>Publikus</label>
                      {html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
                      {if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if} 
                </div><div class="clear"></div>
                
                <div class="form-row">
                        <button class="submit btn" name="{$BtnSave}" id="{$BtnSave}" value="submit" type="submit">Mentés</button>
                </div><div class="clear"></div>
                {/if}
                
                <ul class="uw-nav-list uw-nav-list-block">
                    <li>
                        <a title="Vissza a végzettségeimhez!" href="{$DOMAIN}{$routes.vegzettseg}">Vissza a végzettségeimhez!</a>
                    </li>
                    <li>
                        <a title="Vissza az Én oldalra!" href="{$DOMAIN}{$routes.en}">Vissza a profilomra!</a>
                    </li>
                </ul>
        </form>
</div>