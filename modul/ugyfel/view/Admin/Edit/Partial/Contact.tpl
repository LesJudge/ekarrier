<div class="uw-ugyfelkezelo-form">
    <div id="client-contact" class="uw-ugyfelkezelo-client-contact">
        <div id="client-contact-error" class="notice error"><p></p></div>
        <div id="client-contact-success" class="notice success"><p>Message</p></div>
        <div id="client-contact-fatal-error">Sajnáljuk, de végzetes hiba történt!</div>
        <table id="client-contact-table" class="uw-ugyfelkezelo-client-contact-table">
            <thead>
                <tr>
                    <th>Megjegyzés</th>
                    <th>Dátum</th>
                    <th>Név</th>
                    <th>Közvetítés</th>
                    <th>Hova</th>
                    <th>Megjelent</th>
                    <th>Mikor</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr><td colspan="7"><button id="client-contact-add-btn" type="button">Új elem</button></td></tr>
            </tfoot>
        </table>
        <div id="client-contact-dialog-create" title="Új esetnapló bejegyzés">
            <ul id="contact-dialog-dialog-create-error" class="ui-state-error" style="display: none;">
                <li>dummy-message</li>
            </ul>
            <div>
                <label>Típus</label>
                <select id="contact-is-mediation" name="contact[is_mediation]">
                    <option value="0">Esetnapló</option>
                    <option value="1">Közvetítés</option>
                </select>
            </div>
            <div class="clear"></div>
            <div id="contact-mediation-data" style="display: none;">
                <div>
                    <label>Hova</label>
                    <input id="contact-mediation-hova" name="contact[mediation][hova]" type="text" />
                </div>
                <div>
                    <label>Megjelent</label>
                    <select id="contact-mediation-megjelent" name="contact[mediation][megjelent]">
                        <option value="">--Kérem, válasszon!--</option>
                        <option value="1">Igen</option>
                        <option value="0">Nem</option>
                    </select>
                </div>
                <div>
                    <label>Mikor</label>
                    <input id="contact-mediation-mikor" name="contact[mediation][mikor]" type="text" />
                </div>
            </div>
            <div>
                <label>Név</label>
                <input id="contact-nev" name="contact[contact][nev]" type="text" />
            </div>
            <div>
                <label>Dátum</label>
                <input id="contact-datum" name="contact[contact][datum]" type="text" />
            </div>
            <div>
                <label>Megjegyzés</label>
                <textarea id="contact-megjegyzes" name="contact[contact][megjegyzes]"></textarea>
            </div>
        </div>
    </div>
</div>