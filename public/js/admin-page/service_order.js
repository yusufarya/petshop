function process(code, delivery_status, pick_up) {
    $("#modal-proses").modal("show");

    $("#code").val(code);

    $("#delivery").html("");

    if (pick_up == "Y") {
        var option = `<option value="0">Persiapan</option>
        <option value="1">Penjemputan</option>
        <option value="2">Tiba Ditoko</option>
        <option value="3">Dalam Perawatan</option>
        <option value="4">Antar Kepemilik</option>`;
    } else {
        var option = `<option value="0">Menunggu</option>
        <option value="1">Peliharaan diterima</option>
        <option value="2">Proses  Pelayanan Berlangsung</option>
        <option value="3">Antar Kepemilik</option>
        <option value="4">Selesai</option>`;
    }
    $("#delivery").append(option);
    $("#delivery").val(delivery_status).change();
}
