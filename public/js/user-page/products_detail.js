function popUpAddCart(productId) {
    $("#modal-add-cart").modal("show");

    var qty = parseFloat($("#qty").val());

    $("#min").click(function () {
        qty -= 1;
        if (qty <= 1) {
            qty = 1;
        }
        countQty(qty);
    });
    $("#plus").click(function () {
        qty += 1;
        countQty(qty);
    });
}

function countQty(val) {
    $("#qty").val(val);
}
