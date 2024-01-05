$(function () {
    console.log("ready");

    var invalid = document.getElementById("invalid").value;
    var valid = document.getElementById("valid").value;
    if (valid) {
        $("#notif-success").toast("show");
    } else if (invalid) {
        $("#notif-failed").toast("show");
    }
});

function delete_data(number, name) {
    //
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/delete-admin/" + number);
    $("#content-delete").html("");

    var html =
        `<div class="col mb-2">
                <input type="hidden" name="number" id="number" value="` +
        number +
        `">
                <span style="margin-left: 10px;">Hapus Data <b>` +
        name +
        `</b> ?<span>
                </div>`;

    $("#content-delete").append(html);
}
