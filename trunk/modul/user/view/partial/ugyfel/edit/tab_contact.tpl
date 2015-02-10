<div class="uw-ugyfelkezelo-form">
    <div id="client-contact" class="uw-ugyfelkezelo-client-contact">
        <div id="client-contact-error" class="notice error">
            <p></p>
        </div><!--/#client-contact-error-->
        <div id="client-contact-success" class="notice success">
            <p>Message</p>
        </div><!--/#client-contact-success-->
        <div id="client-contact-fatal-error">
            Sajnáljuk, de végzetes hiba történt!
        </div><!--/#client-contact-fatal-error-->
        <table id="client-contact-table" class="uw-ugyfelkezelo-client-contact-table">
            <thead>
                <tr>
                    <th class="uw-ugyfelkezelo-client-contact-table-megjegyzes">Megjegyzés</th>
                    <th>Kapcs. felvétel ideje</th>
                    <th>Típus</th>
                    <th>Létrehozva</th>
                    <th>Létrehozta</th>
                    <th>Törlés</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <button id="client-contact-add-btn" type="button">Új elem</button>
                    </td>
                </tr>
            </tfoot>
        </table><!--/#client-contact-table-->
        <div id="client-contact-dialog-create" title="Új esetnapló bejegyzés">
            <ul id="contact-dialog-dialog-create-error" class="ui-state-error" style="display: none;">
                <li>dummy-message</li>
            </ul>
            <form id="contact-form-new">
                <!-- Prevent modal dialog input autofocus -->
                <span class="ui-helper-hidden-accessible">
                    <input type="text" />
                </span>
                <div>
                    <label>Típus</label>
                    <select id="cc-create-esetnaplo-tipus-id" name="ClientContact[esetnaplo_tipus_id]">
                        {foreach from=$contactTypeOptions key=id item=name}
                        <option value="{$id}">{$name}</option>
                        {/foreach}
                    </select>
                    <div class="clear"></div>
                </div>
                <div>
                    <label for="cc-create-felvetel-ideje">Dátum</label>
                    <input id="cc-create-felvetel-ideje" name="ClientContact[felvetel_ideje]" type="text" />
                </div>
                <div>
                    <label for="cc-create-megjegyzes">Megjegyzés</label>
                    <textarea id="cc-create-megjegyzes" name="ClientContact[megjegyzes]"></textarea>
                </div>
                <input id="cc-create-user-id" name="ClientContact[ugyfel_id]" type="hidden" value="{$client->ugyfel_id}" />
            </form>
        </div>
        <div id="client-contact-dialog-delete" data-contact-id="0" title="Esetnapló elem törlése">Biztos törli a bejegyzést ?</div>
    </div><!--/#client-contact-->
</div>
<style type="text/css">
#client-contact-table tr td:first-child {
    width: 25%;
}
#client-contact-error,
#client-contact-success,
#client-contact-fatal-error {
    display: none;
    /*
    background: pink;
    border: 1px solid red;
    width: 90%;
    margin: 0 auto;
    min-height: 100px;
    line-height: 100px;
    */
}
</style>