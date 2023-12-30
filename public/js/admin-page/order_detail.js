$(function () {
    $("#detailPayment").click(function () {
        $("#modal-detail").modal("show");
    });
});

function detail(sequence, name) {
    let order_code = $("#purchase_order_code").val();
    $.ajax({
        type: "GET",
        url: "/product_order_details/" + sequence, // Use the route function to generate the URL
        data: {
            order_code: order_code,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            $("#modal-product-detail").modal("show");
            // $("#content-detail").html("");
            if (response.status == "success") {
                const item = response.result;
                $("#img-product").attr(
                    "src",
                    "/storage/" + item.products.image
                );
                $("#name").text(item.products.name);
                $("#category").text(item.products.categories.name);
                $("#size").text(item.products.sizes.name);
                $("#price").text(replaceRupiah(item.products.selling_price));
            } else {
            }
        },
        error: function (error) {
            console.log("Ajax request failed");
        },
    });
}
