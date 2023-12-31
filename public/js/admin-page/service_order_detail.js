$(function () {
    $("#detailPayment").click(function () {
        $("#modal-detail").modal("show");
    });

    $("#vprice").on("change", function () {
        $("#price").val($(this).val());
    });

    $("#save").on("click", () => {
        let order_code = $("#order_code").val();
        let price = $("#price").val();
        $.ajax({
            type: "POST",
            url: "/update-price-req-order/" + order_code, // Use the route function to generate the URL
            data: {
                price: price,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // $("#modal-detail").modal("show");
                // $("#content-detail").html("");
                if (response.status == "success") {
                    location.href = "/request-order";
                } else {
                    alert("Proses gagal, Hubungi administrator.");
                }
            },
            error: function (error) {
                console.log("Ajax request failed");
            },
        });
    });
});
