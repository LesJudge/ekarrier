<div class="field">
        <div class="form_row">
                <label>
                        Uniós finanszírozású programban részt vett-e az elmúlt 2 évben?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[eu_prog_elm_ket_ev]" type="radio" value="0"{if $projectInfo->eu_prog_elm_ket_ev eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[eu_prog_elm_ket_ev]" type="radio" value="1"{if $projectInfo->eu_prog_elm_ket_ev eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Hazai finanszírozású programban részt vett-e az elmúlt 2 évben?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[hazai_prog_elm_ket_ev]" type="radio" value="0"{if $projectInfo->hazai_prog_elm_ket_ev eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[hazai_prog_elm_ket_ev]" type="radio" value="1"{if $projectInfo->hazai_prog_elm_ket_ev eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Közvetítői adatbázisba kíván e kerülni?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[koz_adatb_kerul]" type="radio" value="0"{if $projectInfo->koz_adatb_kerul eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[koz_adatb_kerul]" type="radio" value="1"{if $projectInfo->koz_adatb_kerul eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Hozzájárult-e munkaközvetítéshez?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[hozjarul_munkakozv]" type="radio" value="0"{if $projectInfo->hozjarul_munkakozv eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[hozjarul_munkakozv]" type="radio" value="1"{if $projectInfo->hozjarul_munkakozv eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Mobilitást vállal e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[mobilitast_vallal]" type="radio" value="0"{if $projectInfo->mobilitast_vallal eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[mobilitast_vallal]" type="radio" value="1"{if $projectInfo->mobilitast_vallal eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label for="lmMikorRegisztralt">
                        Milyen munkarendben kíván elhelyezkedni?
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="" name="projectInfo[munkarend]" type="text" value="{$projectInfo->munkarend}" /><!--/#lmMikorRegisztralt-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmMikorRegisztralt">
                        Honnan hallott a programról?
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="" name="projectInfo[honnan_hall_prog]" type="text" value="{$projectInfo->honnan_hall_prog}" /><!--/#lmMikorRegisztralt-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label for="lmMikorRegisztralt">
                        Hova és mire érkezett be az ügyfél?
                        <span class="require">*</span><!--/.require-->
                </label>
                <input id="" name="projectInfo[hova_mire_erkezett]" type="text" value="{$projectInfo->hova_mire_erkezett}" /><!--/#lmMikorRegisztralt-->
        </div><!--/.form_row-->
        <div class="clear"></div><!--/.clear-->
        <div class="form_row">
                <label>
                        Kulcs. Képességfejl. Tréningen részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[kk_trening_resztvett]" type="radio" value="0"{if $projectInfo->kk_trening_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[kk_trening_resztvett]" type="radio" value="1"{if $projectInfo->kk_trening_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Grafológiai elemzésen részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[graf_elemz_resztvett]" type="radio" value="0"{if $projectInfo->graf_elemz_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[graf_elemz_resztvett]" type="radio" value="1"{if $projectInfo->graf_elemz_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Jogi tanácsadáson részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[jogi_tadas_resztvett]" type="radio" value="0"{if $projectInfo->jogi_tadas_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[jogi_tadas_resztvett]" type="radio" value="1"{if $projectInfo->jogi_tadas_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Képzési tanácsadáson részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[kepz_tanad_resztvett]" type="radio" value="0"{if $projectInfo->kepz_tanad_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[kepz_tanad_resztvett]" type="radio" value="1"{if $projectInfo->kepz_tanad_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Munkatanácsadáson részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[munka_tanad_resztvett]" type="radio" value="0"{if $projectInfo->munka_tanad_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[munka_tanad_resztvett]" type="radio" value="1"{if $projectInfo->munka_tanad_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Pszichológiai tanácsadáson részt vett-e?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[pszich_tanad_resztvett]" type="radio" value="0"{if $projectInfo->pszich_tanad_resztvett eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[pszich_tanad_resztvett]" type="radio" value="1"{if $projectInfo->pszich_tanad_resztvett eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Együttműködési megállapodást kötöttünk-e vele a programba?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[egy_megall_ktttnk_prog]" type="radio" value="0"{if $projectInfo->egy_megall_ktttnk_prog eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[egy_megall_ktttnk_prog]" type="radio" value="1"{if $projectInfo->egy_megall_ktttnk_prog eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
        <div class="form_row">
                <label>
                        Együttműködési megállapodást kötöttünk-e vele a képzésbe?
                        <span class="require">*</span><!--/.require-->
                </label>
                <label>
                        <input id="" name="projectInfo[egy_megall_ktttnk_kepz]" type="radio" value="0"{if $projectInfo->egy_megall_ktttnk_kepz eq 0} checked="checked"{/if} /><!--/#-->
                        Nem
                </label>
                <label>
                        <input id="" name="projectInfo[egy_megall_ktttnk_kepz]" type="radio" value="1"{if $projectInfo->egy_megall_ktttnk_kepz eq 1} checked="checked"{/if} /><!--/#-->
                        Igen
                </label>
        </div><!--/.form_row-->
</div>