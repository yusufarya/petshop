function get_ymd(date) {
    var objectDate = new Date(date);
    var d = objectDate.getDate();
    var m = objectDate.getMonth();
    // var year = objectDate.getFullYear();
    var y = objectDate.getYear();

    return y + "" + (m + 1) + "" + d + "-0";
}

function dateFormat(type, date) {
    var objectDate = new Date(date);
    var day = objectDate.getDate();
    var month = objectDate.getMonth();
    var year = objectDate.getFullYear();

    if (type == "-") {
        return day + "-" + (month + 1) + "-" + year;
    } else if (type == "/") {
        return day + "/" + (month + 1) + "/" + year;
    }
}

function replaceRupiah(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatRupiah(event, angka, prefix = "") {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;

    return (event.value =
        prefix == "" ? rupiah : rupiah ? "Rp. " + rupiah : "");
}

function onlyNumbers(input) {
    // Remove non-numeric characters using a regular expression
    input.value = input.value.replace(/[^0-9]/g, "");
}
