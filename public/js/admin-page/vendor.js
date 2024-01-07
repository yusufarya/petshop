function add_vendor() {
    $("#modal-add").modal("show");
    $(".modal-title").text("Tambah Data");
    $("#content-add").html("");

    var html = `<div class="row mt-2 px-3">
                    <div class="col-md-4 mb-2">
                        <label for="name">Nama Vendor<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control" style="margin-left: 0px;">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="phone">No. Telp<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="phone" id="phone" onkeyup="onlyNumbers(this)" class="form-control" style="margin-left: 0px;">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="address">Alamat<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="address" id="address" class="form-control" style="margin-left: 0px;">
                    </div>
                </div>`;

    $("#content-add").append(html);
}

function edit_vendor(id, name, phone, address) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Ubah Data");
    $("#modal-edit form").attr("action", "/vendors/" + id);
    $("#content-edit").html("");

    var html =
        `<div class="row mt-2 px-3">
                    <div class="col-md-4 mb-2">
                        <label for="name">Nama Vendor<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control" style="margin-left: 0px;" value="` +
        name +
        `">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="phone">No. Telp<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="phone" id="phone" onkeyup="onlyNumbers(this)" class="form-control" style="margin-left: 0px;" value="` +
        phone +
        `">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="address">Alamat<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" autocomplete="off" name="address" id="address" class="form-control" style="margin-left: 0px;" value="` +
        address +
        `">
                    </div>
                </div>`;

    $("#content-edit").append(html);
}

function delete_vendor(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/vendors/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Hapus Vendor <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}

setTimeout(() => {
    $("input#name").focus();
}, 1500);
