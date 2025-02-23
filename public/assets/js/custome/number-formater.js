function numberFormat(number, decimals, dec_point, thousands_sep) {
    number = number.toFixed(decimals);
    var nstr = number.toString();
    nstr += "";
    var x = nstr.split(".");
    var x1 = x[0];
    var x2 = x.length > 1 ? dec_point + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + thousands_sep + "$2");
    }
    return x1 + x2;
}
