function delete_product(id, name) {
    $("#modal-delete").modal("show");
    $(".modal-title").text("Hapus Data");
    $("#modal-delete form").attr("action", "/products/" + id);
    $("#content-delete").html("");

    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "/checkTransactionProduct",
        data: { product_id: id },
        success: function (result) {
            console.log(result);
            if (result.status == "success") {
                var html =
                    `<div class="col mb-2">
                                    <input type="hidden" name="id" id="id" value="` +
                    id +
                    `">
                                    <span style="margin-left: 10px;">Hapus Product <b>` +
                    name +
                    `</b> ?<span>
                                    </div>`;

                $("#y").show();
                $("#n").text("Tidak");
                $("#content-delete").append(html);
            } else {
                var html =
                    `<div class="mx-3">
                    <p class="text-danger">
                            ` +
                    result.message +
                    `
                    </p>
                    <div>`;
                $("#y").hide();
                $("#n").text("Ok");
                $("#content-delete").append(html);
            }
        },
    });
}
