$(function() {
    $(".client-xls-export-dialog-item input:checkbox").uniform();
    // Ügyfél törlés gombok inicializálása.
    $(".clientDeleteBtn").button({
        icons: {
            primary: "ui-icon-trash"
        },
        text: false
    });
    // Ne jelölje ki a táblázat sorát kattintásra.
    $("td").click(function(e) {
        e.stopPropagation();
    });
    // Ügyfél törlése dialog.
    var clientToDelete = null;
    $("#clientDeleteDialog").dialog({
        autoOpen: false,
        buttons: {
            "Igen": function() {
                var $clientDeleteForm = $("#clientDeleteForm");
                $clientDeleteForm.attr("action", domainAdmin + "ugyfel/" + clientToDelete);
                clientToDelete = null;
                $("#clientDeleteForm").submit();
            },
            "Mégsem": function() {
                $(this).dialog("close");
            }
        },
        draggable: false,
        height: 200,
        modal: true,
        resizable: false,
        width: 500
    });
    // Ügyfél törlése.
    $(".clientDeleteBtn").click(function() {
        clientToDelete = this.value;
        var $dialog = $("#clientDeleteDialog");
        $dialog.dialog("open");
    });
    // Ügyfél szűrő törlése.
    $("#clientFilterDeleteBtn").click(function() {
        $("#clientFilterDeleteForm").submit();
    });
    // Projekt létrehozás dialógus ablak.
    $("#clientProjectCreateDialog").dialog({
        autoOpen: false,
        buttons: {
            "Létrehozás": function() {
                var $form = $("#clientProjectCreateForm");
                $form.find("input").val($("#clientProjectCreateProjectName").val());
                $form.submit();
            },
            "Mégsem": function() {
                $(this).dialog("close");
            }
        },
        draggable: false,
        height: 400,
        modal: true,
        resizable: false,
        width: 500
    });
    // Projekt létrehozása gomb.
    $("#clientProjectCreateBtn").click(function() {
        $("#clientProjectCreateDialog").dialog("open");
    });
    // Szűrő dialógus ablak létrehozása.
    $("#clientDynamicFilterDialog").dialog({
        autoOpen: false,
        buttons: {
            "Bezárás": function() {
                $(this).dialog("close");
            }
        },
        draggable: false,
        height: 400,
        modal: true,
        resizable: false,
        width: 600
    });
    // Szűrő dialógus ablak megnyitása, ha a szűrő hozzáadás gombra kattint.
    $("#clientDynamicFilterAddBtn").click(function() {
        $("#clientDynamicFilterDialog").dialog("open");
    });
    
    $("#clientDynamicFilterAddBtn").button({
        icons: {
            primary: "ui-icon-plus"
        }
    });
    
    $("#clientFilterCreateBtn").button({
        icons: {
            primary: "ui-icon-search"
        }
    });
    
    $("#clientFilterDeleteBtn").button({
        icons: {
            primary: "ui-icon-trash"
        }
    });
    
    $("#clientStatisticDialog").dialog({
        autoOpen: false,
        draggable: false,
        height: 400,
        modal: true,
        resizable: false,
        width: 700
    });
    
    $("#clientStatisticBtn").click(function() {
        $.ajax({
            dataType: "html",
            url: domainAdmin + "ugyfel/statistics",
            beforeSend: function() {
                $("#clientStatisticDialog").html("Betöltés, kérem várjon!").dialog("open");
            },
            success: function(data) {
                $("#clientStatisticDialog").html(data).dialog("open");
            },
            error: function() {
                $("#clientStatisticDialog").html("Önnek nincs joga a statisztika megtekintéséhez!");
            },
            type: "GET"
        });
    });
    
    $("#clientExportDialog").dialog({
        autoOpen: false,
        buttons: {
            "Exportálás": function() {
                var $form = $("#clientExportForm"),
                    $this = $(this);
                $this.find("input:checkbox:checked").appendTo($form);
                $this.dialog("close");
                $form.submit();
            },
            "Bezárás": function() {
                $(this).dialog("close");
            }
        },
        draggable: false,
        height: 400,
        modal: true,
        resizable: false,
        width: 700
    });
    
    $("#clientExportBtn").click(function() {
        $("#clientExportDialog").dialog("open");
    });
});