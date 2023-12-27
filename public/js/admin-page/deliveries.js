function process(code, delivery_status) {
    $("#modal-proses").modal("show");

    $("#delivery").val(delivery_status).change();
    $("#code").val(code);
}

$(function () {
    $("#type_order").on("change", function () {
        const type_order = $(this).val();

        if (type_order == 1) {
            $("#product").attr("hidden", false);
            $("#service").attr("hidden", true);
        } else {
            $("#product").attr("hidden", true);
            $("#service").attr("hidden", false);
        }
    });
});
