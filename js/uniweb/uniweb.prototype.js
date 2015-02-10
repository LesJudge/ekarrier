/**
 * "Kipárnázza" a számot a megadott paraméterek szerint.
 * @param {Number} width Milyen hosszú stringet adjon vissza.
 * @param {String|Number} z A szám vagy string, ami az érték előtt szerepel. (Alapértelmezetten 0).
 * @returns {String}
 */
Number.prototype.uwPadNumber = function(width, z) {
    z = z || "0";
    var n = this + "";
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
};
/**
 * Olvasható formátumúvá alakítja a dátumot.
 * @param {String} sep Elválasztó (Alapértelmezetten "-").
 * @returns {String}
 */
Date.prototype.uwGetFormattedDate = function(sep) {
    sep = sep || "-";
    return this.getUTCFullYear() + sep + 
            (this.getUTCMonth() + 1).uwPadNumber(2) + sep + 
            this.getUTCDate().uwPadNumber(2);
};
/**
 * Olvasható formátumúvá alakítja az időpontot.
 * @param {String} sep Elválasztó (Alapértelmezetten ":").
 * @returns {String}
 */
Date.prototype.uwGetFormattedTime = function(sep) {
    sep = sep || ":";
    return this.getHours().uwPadNumber(2) + sep + 
            this.getUTCMinutes().uwPadNumber(2) + sep + 
            this.getUTCSeconds().uwPadNumber(2);
};