$(function() {
    Dropzone.autoDiscover = false;
    var tabsSeen = [];
    $("#ugyfel-edit-tabs").tabs({
        select: function ( event, ui ) {
            var hash = ui.tab.hash,
                isSeen = function(tab) {return tabsSeen[tab] === true; },
                markAsSeen = function(tab) { tabsSeen[tab] = true; };
            switch (hash) {
                case '#tab-contact':
 
                    break;
                    /*
                case "#tab-documents":
                    
                    if (!isSeen("documents")) {
                        // Dokumentumkezelő inicializálása.
                        $("#client-document").dropzoneDocumentManager({
                            readUrl: domain + "ugyfel/" + clientId + "/documents",
                            dataDocumentId: "document-name",
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
                        // Ez azért kell ide, hogy hiba nélkül lefusson a kliens oldali validáció. A validate plugin nem szereti, ha
                        // <form>-ban <form> van, ami ugye nem is helyes, de jelen esetben nem igazán volt más járható út.
                        //$("#client-document-dropzone").validate({
                        //    rules: {
                        //        "method": {
                        //            "required": false
                        //        }
                        //    }
                        //});
                        $("#client-document").trigger("refresh");
                        markAsSeen("documents");
                    }
                    break;
                    */
                default:
                    break;
            }
        }
    });
});