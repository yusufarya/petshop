const arrQty = [];
var total_price = 0;
$(function () {
    // $("#selectAll").on("click", function () {
    //     const isSelectAll = $("input#selectAll").is(":checked");
    //     if (isSelectAll) {
    //         var ele = document.getElementById("items");
    //         console.log(ele);
    //         ele.checked = true;
    //         for (var i = 0; i < ele.length; i++) {
    //             if (ele[i].type == "checkbox") ele[i].checked = false;
    //         }
    //     } else {
    //     }
    // });

    $("#checkout").hide();
    $("#delete").hide();

    $("#checkout").on("click", function () {
        let id_cart = $("#id_cart").val();
        if (id_cart) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/submit-from-cart", // Use the route function to generate the URL
                data: {
                    id_cart: id_cart,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    // Handle the response here
                    if (response.status == "success") {
                        location.href =
                            "/payment/" + response.code + "/" + true;
                    }
                },
                error: function (error) {
                    console.log("Ajax request failed");
                },
            });
        } else {
            alert("Anda belum memilih produk.");
        }
    });
});

function selectItem(item, price) {
    if (arrQty.includes(item)) {
        total_price -= parseFloat(price);
        remove(arrQty, item);
    } else {
        total_price += parseFloat(price);
        arrQty.push(item);
    }
    if (arrQty) {
        $("#checkout").show();
        $("#delete").show();
    } else {
        $("#checkout").hide();
        $("#delete").hide();
    }
    $("#id_cart").val(arrQty);
    $("#vtotal_price").val(replaceRupiah(total_price));
    $("#total_price").val(total_price);
}

function remove(arr) {
    var what,
        a = arguments,
        L = a.length,
        ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

$("#delete").on("click", function () {
    $("#deleteCart").modal("show");
    const arrCartId = $("#id_cart").val();

    $("#deleteCart #ya").click(function () {
        // console.log(id_cart);

        $.ajax({
            type: "DELETE",
            dataType: "json",
            url: "/submit-del-cart", // Use the route function to generate the URL
            // url: "/del-from-cart", // Use the route function to generate the URL
            data: {
                arrCartId: arrCartId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Handle the response here
                location.href = "/shopping-cart";
            },
            error: function (error) {
                console.log("Ajax request failed");
            },
        });
    });
});
