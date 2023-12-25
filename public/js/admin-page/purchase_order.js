function delete_data(id, name) {
    $.ajax({
        type: "GET",
        url: "/purchase-order_detail/checkData", // Use the route function to generate the URL
        data: {
            purchase_order_id: id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            $("#modal-delete").modal("show");
            $("#content-delete").html("");
            if (response.data.length <= 0) {
                $(".modal-title").text("Hapus Data");
                $("#modal-delete form").attr(
                    "action",
                    "/delete-purchase-order/" + id
                );

                var html =
                    `<div class="col mb-2">
                                <input type="hidden" name="id" id="id" value="` +
                    id +
                    `">
                                <span style="margin-left: 10px;">Hapus Pembelian <b>` +
                    name +
                    `</b> ?<span>
                                </div>`;

                $("#modal-delete .modal-footer #n").text("Tidak");
                $("#modal-delete .modal-footer #y").show();
                $("#content-delete").append(html);
            } else {
                $(".modal-title").text("Hapus Data Detail Terlebih Dahulu");
                $("#modal-delete .modal-footer #n").text("Ok.");
                $("#modal-delete .modal-footer #y").hide();
            }
        },
        error: function (error) {
            console.log("Ajax request failed");
        },
    });
    //
}
