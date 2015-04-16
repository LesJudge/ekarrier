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
                    $("#client-contact").clientContacts({
                        createUrl: DOMAIN_ADMIN + "ugyfel/" + clientId + "/contacts", 
                        readUrl: DOMAIN_ADMIN + "ugyfel/" + clientId + "/contacts",
                        dialogCreate: {
                            autoOpen: false,
                            draggable: false,
                            height: 400,
                            modal: true,
                            resizable: false,
                            width: 600
                        },
                        selectors: {
                            createBtn: "#client-contact-add-btn",
                            dialogCreate: "#client-contact-dialog-create",
                            feedbackError: "#client-contact-error",
                            feedbackSuccess: "#client-contact-success",
                            table: "#client-contact-table"
                        }
                    });
                    $("#client-contact").trigger("refresh");
                    break;
                case "#tab-documents":
                    if (!isSeen("documents")) {
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
                        markAsSeen("documents");
                    }
                    break;
                default:
                    break;
            }
        }
    });
});