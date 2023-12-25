function add_m_brand() {
    $("#modal-add").modal("show");
    $(".modal-title").text("Tambah Data");
    $("#content-add").html("");

    var html = `<div class="row mb-2 px-2 mx-1"> 
                    <div class="col-md-5">
                        <label for="name" style="margin: ;">Nama Merek<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control w-100" placeholder="My Brand">
                    </div>
                </div>`;

    $("#content-add").append(html);
}

function edit_m_brand(id, name) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Ubah Data");
    $("#modal-edit form").attr("action", "/brands/" + id);
    $("#content-edit").html("");

    var html =
        `<div class="row mb-2 px-2 mx-1"> 
                    <div class="col-md-5">
                        <label for="name" style="margin: ;">Nama Merek<label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" autocomplete="off" name="name" id="name" class="form-control w-100" value="` +
        name +
        `">
                    </div>
                </div>`;

    $("#content-edit").append(html);
}

function delete_m_brand(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/brands/" + id);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="id" id="id" value="` +
        id +
        `">
                <span style="margin-left: 10px;">Hapus Merek <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}

setTimeout(() => {
    $("input#name").focus();
}, 1500);
