<form id="ugyfel-edit-form" name="ugyfel-edit-form" class="form form_editor" method="post" action="{$formUrl}" enctype="multipart/form-data">
    <div class="grid_24">
        {if $flash->hasFlash('error')}<div id="flash-error" class="notice error"><p>{$flash->getFlash('error')}</p></div>{/if}
        {if $formError}<div id="flash-error" class="notice error"><p>{$formError}</p></div>{/if}
        {if $flash->hasFlash('success')}<div id="flash-success" class="notice success"><p>{$flash->getFlash('success')}</p></div>{/if}
        {if $flash->hasFlash('info')}<div id="flash-info" class="notice info"><p>{$flash->getFlash('info')}</p></div>{/if}
        <div class="box_top" style="overflow: hidden;">
            <h2 class="icon time">Ügyfél - [{$mode}]</h2>
            <ul class="form-actions">
                <li>
                    <button class="submit tip" id="clientSave" value="save" title="Ügyfél mentése.">
                        <img src="../images/admin/icons/save.png" alt="save" />
                    </button>
                </li>
                {if not $client->is_new_record()}
                <li>
                    <a href="{$DOMAIN_ADMIN}ugyfel/{$client->ugyfel_id}/pdf" target="_blank">
                        <img class="tip" title="Ügyfél adatok exportálása .pdf-be." src="../images/admin/icons/pdf-icon.png" />
                    </a>
                </li>
                {/if}
                <li>
                    <a href="{$DOMAIN_ADMIN}ugyfel" id="clientClose">
                        <img class="tip" title="Vissza az ügyfél listára." src="../images/admin/icons/cancel.png"/>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box_content padding">
            <div class="field">
                <div id="uw-ugyfelkezelo-loader" style="display: none;"><p id="uw-ugyfelkezelo-loader-text">Betöltés, kérem várjon...</p></div>
                <div id="ugyfel-edit-tabs" style="display: block;">
                    <ul>
                        <li><a href="#tab-ugyfel-informacio">Ügyfél információ</a></li>
                        <li><a href="#tab-szemelyes-adatok">Személyes adatok</a></li>
                        <li><a href="#tab-munkaeropiaci-helyzete">Munkaerőpiaci helyzete</a></li>
                        <li><a href="#tab-projektinformaciok">Projektinformációk</a></li>
                        <li><a href="#tab-munkakorokmunkarend">Munkakörök/munkarend</a></li>
                        <li><a href="#tab-nytszgp">Végzettségek/Nyelvtudás/Tanulmányok/Számítógépes ismeretek</a></li>
                        <li><a href="#tab-szolgaltatas">Szolgáltatás</a></li>
                        {if not $client->is_new_record()}
                        <li><a href="#tab-project">Projekt</a></li>
                        <li><a href="#tab-contact">Esetnapló</a></li>
                        <li><a href="#tab-documents">Dokumentumok</a></li>
                        {/if}
                        <!--<li><a href="#tab-login">Belépés adatok</a></li>-->
                    </ul>
                    <div id="tab-ugyfel-informacio">{include file="modul/ugyfel/view/Admin/Edit/Partial/ClientInformation.tpl"}</div>
                    <div id="tab-szemelyes-adatok">{include file="modul/ugyfel/view/Admin/Edit/Partial/PersonalData.tpl"}</div>
                    <div id="tab-munkaeropiaci-helyzete">{include file="modul/ugyfel/view/Admin/Edit/Partial/LaborMarket.tpl"}</div>
                    <div id="tab-projektinformaciok">{include file="modul/ugyfel/view/Admin/Edit/Partial/ProjectInformation.tpl"}</div>
                    <div id="tab-munkakorokmunkarend">{include file="modul/ugyfel/view/Admin/Edit/Partial/WorkSchedule.tpl"}</div>
                    <div id="tab-nytszgp">{include file="modul/ugyfel/view/Admin/Edit/Partial/Education.tpl"}</div>
                    <div id="tab-szolgaltatas">{include file="modul/ugyfel/view/Admin/Edit/Partial/Service.tpl"}</div>
                    {if not $client->is_new_record()}
                    <div id="tab-project">{include file="modul/ugyfel/view/Admin/Edit/Partial/Project.tpl"}</div>
                    <div id="tab-contact">{include file="modul/ugyfel/view/Admin/Edit/Partial/Contact.tpl"}</div>
                    <div id="tab-documents">{include file="modul/ugyfel/view/Admin/Edit/Partial/Document.tpl"}</div>
                    {/if}
                    <!--<div id="tab-login"></div>-->
                </div>
            </div>
        </div>
    </div>
    <input name="_METHOD" type="hidden" value="{$requestMethod}" />
</form>
<div id="dialog-loading" title="Betöltés"></div>
<script type="text/javascript">
//<![CDATA[
var domain = "{$DOMAIN}", 
    clientId = {$clientId};
var educations = {$educations},
    knowledges = {$knowledges},
    computerKnowledges = {$computerKnowledges},
    addresses = {$addresses},
    jobs = {$jobs};
//]]>
</script>
<script type="text/javascript" src="{$DOMAIN}js/jquery.sheepItPlugin.js"></script>
<script type="text/javascript" src="{$DOMAIN}js_min/admin_ugyfelkezelo_edit.js"></script>
<script type="text/javascript" src="{$DOMAIN}js/uniweb/jquery.uniweb.dropzoneDocumentManager.js"></script>
<script type="text/javascript">
$(function() {
    // Ügyfél dokumentumok.
    $("#client-document").dropzoneDocumentManager({
        readUrl: DOMAIN_ADMIN + "ugyfel/" + clientId + "/documents",
        downloadUrl: DOMAIN_ADMIN + "ugyfel/document/-filename-/download",
        uploadUrl: DOMAIN_ADMIN + "ugyfel/" + clientId + "/document",
        deleteUrl: DOMAIN_ADMIN + "ugyfel/document/-filename-",
        dialogDelete: {
            autoOpen: false,
            height: 200,
            modal: true,
            width: 450
        },
        selectors: {
            btnUpload: "#client-document-btn-upload",
            dialogDelete: "#client-document-dialog-delete",
            dropzone: "#client-document-dropzone",
            fatalError: "#client-document-fatal-error",
            feedbackError: "#client-document-feedback-error",
            feedbackInfo: "#client-document-feedback-info",
            feedbackSuccess: "#client-document-feedback-success",
            table: "#client-document-table"
        }
    });
    $("#client-document").trigger("refresh");
    
    $("#birthdata-birthplace-edit-btn").button({
        create: function(event, ui) {
            var $self = $(event.target);
            $self.click(function() {
                $self.hide();
                $("#birthdata-birthplace-info").hide();
                $("#birthdata-birthplace-edit").show();
                var $country = $("#birthdata-birthplace-country"),
                    $city = $("#birthdata-birthplace-city");
                $country.attr("disabled", false).parent().removeClass("disabled");
                $city.attr("disabled", false).parent().removeClass("disabled");
                $country.change(function() {
                    loadingAddress.call(null);
                    findAndSetCitiesByCountryId.call($city, +this.value);
                });
                loadingAddress.call(null);
                if (clientId === 0) {
                    loadingAddress.call(null);
                    $.ajax({
                        dataType: "json",
                        type: "GET",
                        url: domain + "modul/cim/api/find/countries/",
                        success: function(data) {
                            createOptions.call($country, 'country_id', 'country_name', data);
                            setUniformSelectValue.call($country, null);
                        },
                        error: function(xhr) {
                            alert("Hiba lépett fel a művelet során!");
                        }
                    });
                    findAndSetCitiesByCountryId.call($city, 124);
                } else {
                    $.ajax({
                        dataType: "json",
                        type: "GET",
                        url: DOMAIN_ADMIN + "ugyfel/" + clientId + "/birthplace",
                        success: function(data) {
                            createOptions.call($country, 'country_id', 'country_name', data.countries);
                            createOptions.call($city, 'city_id', 'city_name', data.cities);
                            setUniformSelectValue.call($country, data.country_id);
                            setUniformSelectValue.call($city, data.city_id);
                        },
                        error: function(xhr) {
                            alert("Hiba lépett fel a művelet során!");
                        },
                        complete: function() {
                            $("#dialog-loading").dialog("close");
                        }
                    });
                }
            });
        },
        icons: {
            primary: "ui-icon-pencil"
        }
    });
});
</script>