/**
 * Űrlapon szereplő cím adatok beállítása.
 * @param {String} idPrefix Id mezők prefixe.
 * @param {String} namePrefix Név mezők prefixe.
 * @param {Object} locationData Cím adatait tartalmazó PlainObject
 */
function setLocationValues(idPrefix, namePrefix, locationData) {
    $("#" + idPrefix + "VarosId").val(locationData.city_id);
    $("#" + idPrefix + "MegyeId").val(locationData.county_id);
    $("#" + idPrefix + "IranyitoszamId").val(locationData.zip_code_id);
    $("#" + namePrefix + "-varos-nev").val(locationData.city_name);
    $("#" + namePrefix + "-megye-nev").val(locationData.county_name);
    $("#" + namePrefix + "-iranyitoszam").val(locationData.zip_code);
}