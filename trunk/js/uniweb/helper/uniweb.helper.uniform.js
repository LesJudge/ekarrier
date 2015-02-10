/**
 * Select change event Uniform pluginnal rendelkező elemekhez.
 */
function uniformSelectChange() {
    var $selected = $(this).find("option:selected");
    $(this).prev().html($selected.html());
}
/**
 * Megsemmisíti a kiválasztott elemeken a Uniform plugint.
 * @param {String} selector
 */
function uniformRestore(selector) {
    if ($.uniform && $.uniform.restore && $.isFunction($.uniform.restore)) {
        $.uniform.restore(selector);
    }
}