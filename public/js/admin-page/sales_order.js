function process(code, delivery_status) {
    $("#modal-proses").modal("show");

    $("#delivery").val(delivery_status).change();
    $("#code").val(code);
}
