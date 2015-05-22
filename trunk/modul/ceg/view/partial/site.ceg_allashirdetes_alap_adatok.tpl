<h3>Belépéshez szükséges adatok</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="col-data-3">
			
			<div class="form-row">
				<input id="{$TxtNev.name}" name="{$TxtNev.name}" type="text" value="{$TxtNev.activ}" placeholder="Megnevezés *"/>
				{if isset($TxtNev.error)}<p class="error small">{$TxtNev.error}</p>{/if} 
			</div>
			<div class="clear"></div>
			
			<!--
			<div class="form-row">
				<label for="{$SelMunkarend.name}">
					Munkarend
					<span class="require">*</span>
				</label>
				{html_options name=$SelMunkarend.name id=$SelMunkarend.name options=$SelMunkarend.values selected=$SelMunkarend.activ style="width: 100px !important;"} 
				{if isset($SelMunkarend.error)}<p class="error small">{$SelMunkarend.error}</p>{/if}
			</div>
			<div class="clear"></div>
			-->
			
			<div class="form-row">
				<!--
				<label for="{$SelSzektor.name}">
					Szektor
					<span class="require">*</span>
				</label>
				-->
				{html_options name=$SelSzektor.name id=$SelSzektor.name options=$SelSzektor.values selected=$SelSzektor.activ class='select-type-1'} 
				{if isset($SelSzektor.error)}<p class="error small">{$SelSzektor.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				<!--
				<label for="{$SelPozicio.name}">
					Pozíció
					<span class="require">*</span>
				</label>    
				-->
				{html_options name=$SelPozicio.name id=$SelPozicio.name options=$SelPozicio.values selected=$SelPozicio.activ class='select-type-1'}    
				{if isset($SelPozicio.error)}<p class="error small">{$SelPozicio.error}</p>{/if}
				
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				<input id="{$TxtMunkavegzesJellege.name}" name="{$TxtMunkavegzesJellege.name}" type="text" value="{$TxtMunkavegzesJellege.activ}" placeholder="Munkavégzés jellege" />
				{if isset($TxtMunkavegzesJellege.error)}<p class="error small">{$TxtMunkavegzesJellege.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				<input id="{$TxtMunkaber.name}" name="{$TxtMunkaber.name}" type="text" value="{$TxtMunkaber.activ}" placeholder="Munkabér" />
				{if isset($TxtMunkaber.error)}<p class="error small">{$TxtMunkaber.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			
		</div>
	</div>
	<div class="col-lg-12">
		<div class="col-data-3">
			
			<!--
			<div class="form-row">
				<label for="{$SelErtesites.name}">
					Értesítés
					<span class="require">*</span>
				</label>
				{html_options name=$SelErtesites.name id=$SelErtesites.name options=$SelErtesites.values selected=$SelErtesites.activ} 
				{if isset($SelErtesites.error)}<p class="error small">{$SelErtesites.error}</p>{/if}
			</div>
			<div class="clear"></div>
			-->
			<div class="form-row">
				<input id="{$TxtProbaido.name}" name="{$TxtProbaido.name}" type="text" value="{$TxtProbaido.activ}" placeholder="Próbaidő" />
				{if isset($TxtProbaido.error)}<p class="error small">{$TxtProbaido.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				{if $DateMunkakezdesIdeje.activ == '0000-00-00'}    
					<input id="{$DateMunkakezdesIdeje.name}" name="{$DateMunkakezdesIdeje.name}" type="text" value="" placeholder="Munkakezdés ideje" />
				{else}
					<input id="{$DateMunkakezdesIdeje.name}" name="{$DateMunkakezdesIdeje.name}" type="text" value="{$DateMunkakezdesIdeje.activ}" placeholder="Munkakezdés ideje" />
				{/if}
				{if isset($DateMunkakezdesIdeje.error)}<p class="error small">{$DateMunkakezdesIdeje.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				{if $DateKezdes.activ == '0000-00-00'}    
					<input id="{$DateKezdes.name}" name="{$DateKezdes.name}" type="text" value="" placeholder="Kezdődátum" />
				{else}
					<input id="{$DateKezdes.name}" name="{$DateKezdes.name}" type="text" value="{$DateKezdes.activ}" placeholder="Kezdődátum" />
				{/if}
				{if isset($DateKezdes.error)}<p class="error small">{$DateKezdes.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				{if $DateLejar.activ == '0000-00-00'}    
					<input id="{$DateLejar.name}" name="{$DateLejar.name}" type="text" value="" placeholder="Lejárati dátum" />
				{else}
					<input id="{$DateLejar.name}" name="{$DateLejar.name}" type="text" value="{$DateLejar.activ}" placeholder="Lejárati dátum" />
				{/if}
				{if isset($DateLejar.error)}<p class="error small">{$DateLejar.error}</p>{/if}
			</div>
			<div class="clear"></div>
			
			<div class="form-row">
				<label>Publikus <span class="require">*</span></label>
				<div class="inputItem-group">
					{html_radios name=$ChkAktiv.name options=$ChkAktiv.values selected=$ChkAktiv.activ}
				</div>
				{if isset($ChkAktiv.error)}<p class="error small">{$ChkAktiv.error}</p>{/if}
			</div>
			<div class="clear"></div>
						
		</div>
	</div>	
	<div class="clear"></div>
</div>	
<div class="col-data-3">
	<div class="form-row">
		<label for="{$TxtEgyeb.name}">Egyéb</label>
		<textarea id="{$TxtEgyeb.name}" name="{$TxtEgyeb.name}">{$TxtEgyeb.activ}</textarea>
		{if isset($TxtEgyeb.error)}<p class="error small">{$TxtEgyeb.error}</p>{/if}
	</div>
	<div class="clear"></div>
</div>	





