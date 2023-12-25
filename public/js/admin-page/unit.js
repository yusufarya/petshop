function add_m_unit() {
    $("#modal-add").modal("show");
    $(".modal-title").text("Tambah Data");
    $("#content-add").html("");

    var html = `<div class="row mb-2 px-2 mx-1">
                    <div class="col-md-5">
                        <label for="initial" style="margin: ;">initial<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="initial" id="initial" maxlength="3" class="form-control w-100" placeholder="pcs">
                    </div>
                    <div class="col-md-5">
                        <label for="name" style="margin: ;">Nama Satuan<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control w-100" placeholder="Pieces">
                    </div>
                </div>`;

    $("#content-add").append(html);
}

function edit_m_unit(id, initial, name) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Ubah Data");
    $("#modal-edit form").attr("action", "/units/" + id);
    $("#content-edit").html("");

    var html =
        `<div class="row mb-2 px-2 mx-1">
                    <div class="col-md-5">
                        <label for="initial" style="margin: ;">initial<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="initial" id="initial" maxlength="3" class="form-control w-100" value="` +
        initial +
        `">
                    </div>
                    <div class="col-md-5">
                        <label for="name" style="margin: ;">Nama Satuan<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control w-100" value="` +
        name +
        `">
                    </div>
                </div>`;

    $("#content-edit").append(html);
}

function delete_m_unit(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/units/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Hapus Satuan <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}

setTimeout(() => {
    $("input#name").focus();
}, 1500);
