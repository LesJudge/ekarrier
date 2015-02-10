<div class="uw-ugyfelkezelo-form">
    <div id="client-document-feedback-error" class="notice error">
        <p></p>
    </div>
    <div id="client-document-feedback-success" class="notice success">
        <p></p>
    </div>
    <div id="client-document-feedback-info" class="notice info">
        <p></p>
    </div>
    <div id="client-document">
        <table id="client-document-table">
            <thead>
                <tr>
                    <th>Megnevezés</th>
                    <th>Feltölve</th>
                    <th>Feltöltő</th>
                    <th>Letöltés</th>
                    <th>Törlés</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <form id="client-document-dropzone" class="dropzone" method="post" enctype="multipart/form-data"></form>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <button id="client-document-btn-upload" type="button">Feltöltés</button>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div id="client-document-dialog-delete" data-document-id="0" title="Dokumentum törlése">Biztos törölni akarja a dokumentumot ?</div>
    </div>
    <div id="client-document-fatal-error">Végzetes hiba történt!</div>
</div>
<style type="text/css">
#client-document-feedback-error,
#client-document-feedback-info,
#client-document-feedback-success,
#client-document-fatal-error {
    display: none;
}
#client-document-table tfoot tr:first-child td {
    padding: 0px;
}
#client-document-table tfoot tr:last-child td {
    text-align: center;
}
#client-document-btn-upload {
    border: 1px solid #A8A8A8;
}
</style>