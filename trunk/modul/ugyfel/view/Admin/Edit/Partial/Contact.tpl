<div class="uw-ugyfelkezelo-form">
    <div id="client-contact" class="uw-ugyfelkezelo-client-contact">
        <div id="client-contact-error" class="notice error"><p></p></div>
        <div id="client-contact-success" class="notice success"><p>Message</p></div>
        <div id="client-contact-fatal-error">Sajnáljuk, de végzetes hiba történt!</div>
        <table id="client-contact-table" class="uw-ugyfelkezelo-client-contact-table">
            <thead>
                <tr>
                    <th class="uw-ugyfelkezelo-client-contact-table-megjegyzes">Megjegyzés</th>
                    <th>Dátum</th>
                    <th>Név</th>
                    <th>Hova</th>
                    <th>Megjelent</th>
                    <th>Mikor</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr><td colspan="6"><button id="client-contact-add-btn" type="button">Új elem</button></td></tr>
            </tfoot>
        </table>
        <div id="client-contact-dialog-create" title="Új esetnapló bejegyzés">
            <ul id="contact-dialog-dialog-create-error" class="ui-state-error" style="display: none;">
                <li>dummy-message</li>
            </ul>
            <div>
                <label>Típus</label>
                <select name="contact[is_mediation]">
                    <option value="1">Közvetítés</option>
                    <option value="0">Esetnapló</option>
                </select>
            </div>
            <div>
                <label>Hova</label>
                <input name="contact[mediation][hova]" />
            </div>
            <div>
                <label>Megjelent</label>
                <input name="contact[mediation][megjelent]" type="checkbox" />
            </div>
            <div>
                <label>Mikor</label>
                <input name="contact[mediation][mikor]" type="text" />
            </div>
            <div>
                <label>Név</label>
                <input name="contact[contact][nev]" />
            </div>
            <div>
                <label>Dátum</label>
                <input name="contact[contact][datum]" />
            </div>
            <div>
                <label>Megjegyzés</label>
                <textarea name="contact[contact][megjegyzes]"></textarea>
            </div>
        </div>
    </div>
</div>