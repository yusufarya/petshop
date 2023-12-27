function add_data() {
    $("#modal-add").modal("show");
    $(".modal-title").text("Tambah Data");
    $("#content-add").html("");

    var html = `<div class="row mt-2 px-3">
                <div class="col-md-4 mb-2">
                    <label for="name">Jenis Pengiriman<label>
                </div>
                <div class="col-md-8 mb-2">
                    <input type="text" autocomplete="off" name="name" id="name" class="form-control" style="margin-left: 0px;" value="" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="description">Keterangan<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <textarea autocomplete="off" name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="col-md-4 mb-2">
                        <label for="charge">biaya<label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input autocomplete="off" name="charge" id="charge" class="form-control" value="0" onkeyup="formatRupiah(this, this.value);">
                </div>
            </div>`;

    $("#content-add").append(html);
}

function edit_data(id, type, description, charge) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Ubah Data");
    $("#modal-edit form").attr("action", "/delivery-types/" + id);
    $("#content-edit").html("");

    var html =
        `<div class="row mt-2 px-3">
            <div class="col-md-4 mb-2">
                <label for="name">Jenis Pengiriman<label>
            </div>
            <div class="col-md-8 mb-2">
                <input type="text" autocomplete="off" name="name" id="name" class="form-control" style="margin-left: 0px;" value="` +
        type +
        `">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="description">Keterangan<label>
                </div>
                <div class="col-md-8 mb-2">
                    <textarea autocomplete="off" name="description" id="description" class="form-control">` +
        description +
        `
                    </textarea>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="charge">biaya<label>
                </div>
                <div class="col-md-8 mb-2">
                    <input autocomplete="off" name="charge" id="charge" class="form-control" value="` +
        replaceRupiah(charge) +
        `" onkeyup="formatRupiah(this, this.value);">
            </div>
        </div>`;

    $("#content-edit").append(html);
}

function delete_data(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/delivery-types/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Jenis Pengiriman <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}

setTimeout(() => {
    $("input#name").focus();
}, 1500);
