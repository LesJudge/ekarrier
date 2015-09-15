<div class="uw-ugyfelkezelo-form">
    <div id="client-contact" class="uw-ugyfelkezelo-client-contact">
        <div id="client-contact-error" class="notice error"><p></p></div>
        <div id="client-contact-success" class="notice success"><p></p></div>
        <div id="client-contact-fatal-error">Sajnáljuk, de végzetes hiba történt!</div>
        
        <div id="client-contact-loading" class="notice info">
            <p>Esetnapló betöltése...</p>
        </div>
        
        <table id="client-contact-table">
            <thead>
                <tr>
                    <th>Típus</th>
                    <th>Megnevezés</th>
                    <th>Dátum</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        
        <button id="client-contact-add-btn" type="button">Új bejegyzés</button>
        
        <div id="client-contact-dialog-create" title="Új esetnapló bejegyzés">
            <ul id="contact-dialog-dialog-create-error" class="ui-state-error" style="display: none;">
                <li>dummy-message</li>
            </ul>
            <div class="row-contact-dialog">
                <label>Típus</label>
                <select id="contact-type-select" name="contact[tipus]">
                    <option value="">-- Kérem, válasszon típust! --</option>
                    <option value="1">Esetnapló</option>
                    <option value="2">Közvetítés</option>
                    <option value="3">Egyéb</option>
                </select>
                <div class="clearfix"></div>
            </div>
            <div id="contact-form-container"></div>
        </div>
    </div>
</div>