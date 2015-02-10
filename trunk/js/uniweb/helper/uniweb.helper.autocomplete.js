function uiAutoCompleteChange( event, ui ) {
    var label = null,
        value = null,
        $plugin = $(this).data("autocomplete");
    if (ui.item) {
        label = ui.item.label;
        value = ui.item.value;
    }
    if ($plugin && $plugin.options && $plugin.options.setValue && $.isFunction($plugin.options.setValue)) {
        $plugin.options.setValue.call(this, value, event, ui);
    } else {
        $(this).next("input").val(value);
    }
    this.value = label;
};
function uiAutoCompleteFocus( event, ui ) {
    event.preventDefault();
}
function uiAutoCompleteSelect( event, ui ) {
    event.preventDefault();
    this.value = ui.item.label;
}