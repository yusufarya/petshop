function add_data() {
    $("#modal-add").modal("show");
    $(".modal-title").text("Tambah Data");
    $("#content-add").html("");

    var html = `<div class="row mt-2 px-3">
                    <div class="col-md-4 mb-2">
                        <label for="bank_name">Nama Bank<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="bank_name" id="bank_name" class="form-control" style="margin-left: 0px;">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="address">Nomor Rekening<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="account_number" id="account_number" onkeyup="onlyNumbers(this)" class="form-control" style="margin-left: 0px;">
                    </div>
                </div>`;

    $("#content-add").append(html);
}

function edit_data(id, name, account_number) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Ubah Data");
    $("#modal-edit form").attr("action", "/payment-method/" + id);
    $("#content-edit").html("");

    var html =
        `<div class="row mt-2 px-3">
                    <div class="col-md-4 mb-2">
                        <label for="bank_name">Nama Bank<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="bank_name" id="bank_name" class="form-control" style="margin-left: 0px;" value="` +
        name +
        `">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="address">Nomor Rekening<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="account_number" id="account_number" onkeyup="onlyNumbers(this)" class="form-control" style="margin-left: 0px;" value="` +
        account_number +
        `">
                    </div>
                </div>`;

    $("#content-edit").append(html);
}

function delete_data(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/payment-method/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Hapus Bank <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}

setTimeout(() => {
    $("input#name").focus();
}, 1500);
