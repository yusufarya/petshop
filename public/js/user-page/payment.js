$(function () {
    var qty = $("#qty_dt").val();
    let price = $("#price").val();
    let charge = $("#charge").val();

    var totals = qty * price;
    totals += parseFloat(charge);

    let pageCart = $("#pageCart").val();
    if (!pageCart) {
        $("#vnetto").val(replaceRupiah(totals + ".00"));
        $("#netto").val(totals);
    }
});

function changeQty() {
    var qty = $("#qty_dt").val();
    if (qty <= 1) {
        $("#qty_dt").val(1);
        var qty = $("#qty_dt").val();
    }

    let price = $("#price").val();
    let charge = $("#charge").val();

    var totals = qty * price;
    $("#total_price").val(totals);
    var total = replaceRupiah(totals) + ".00";

    $("#vtotal_price").val(total);
    totals += parseFloat(charge);
    console.log(totals);
    $("#vnetto").val(replaceRupiah(totals + ".00"));
    $("#netto").val(totals);
}

function payOrder(code, pageCart) {
    // console.log(code);
    var qty_dt = $("#qty_dt").val();
    var price = $("#price").val();
    var total_price = $("#total_price").val();
    var charge = $("#charge").val();
    var netto = $("#netto").val();

    var route = "/prosesPayOrder";

    $.ajax({
        type: "POST",
        url: route,
        data: {
            code: code,
            qty_dt: qty_dt,
            price: price,
            total_price: total_price,
            charge: charge,
            netto: netto,
            pageCart: pageCart ? true : false,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            if (response.status == "success") {
                const code = response.resultData.code;
                setTimeout(() => {
                    location.href = "/pay-order/" + code;
                }, 100);
            } else {
                alert("Proses gagal, Hubungi Administrator.");
            }
            // Handle the response here
        },
        error: function (error) {
            console.log("Ajax request failed");
        },
    });
}

function cancelOrder(code) {
    $("#cancelOrder").modal("show");

    $("#Y").click(function () {
        var route = "/cancel-order";

        $.ajax({
            type: "DELETE",
            url: route,
            data: {
                code: code,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Handle the response here
                setTimeout(() => {
                    location.href = "/";
                }, 100);
            },
            error: function (error) {
                console.log("Ajax request failed");
            },
        });
    });
}
