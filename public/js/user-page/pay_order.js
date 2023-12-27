$(function () {
    const payment_method = $("#payment_method").val();
    if (payment_method) {
        var val = payment_method ? payment_method.split("-") : "";
        var html =
            `<span class="alert alert-danger py-1">` + val[2] + `</span>`;
        $("#account_number").append(html);
        $("#OK").hide();
        $("#payment_method").prop("disabled", true);
    }

    $("#OK").on("click", function () {
        var thisVal = $("#payment_method").val();

        var val = thisVal ? thisVal.split("-") : "";
        if (val) {
            updatePaymentMethod(val[0]);
            var html =
                `<span class="alert alert-danger py-1">` + val[2] + `</span>`;
            $("#account_number").append(html);
        }
    });

    $("#proof_of_payment").on("click", function () {
        $("#upload_bukti").attr("hidden", false);

        $("#imagePay").on("change", function () {
            $("#btnSend").attr("disabled", false);
        });

        $("#btnSend").on("click", function (event) {
            event.preventDefault();
            let order_code = $("#order_code").val();
            let dataPost = new FormData();
            let images = $("#imagePay")[0];

            dataPost.append("images", images.files[0]);
            dataPost.append("order_code", order_code);

            $.ajax({
                type: "POST",
                url: "/uploadImgPayment", // Use the route function to generate the URL
                // url: "{{ route('/uploadImgPayment') }}", // Use the route function to generate the URL
                data: dataPost,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    // console.log(response);
                    if (response.status == "success") {
                        alert("Upload bukti pembayaran berhasil.");
                        location.href = "/";
                    }
                },
                error: function (error) {
                    console.log("Ajax request failed");
                },
            });
        });
    });
});

function updatePaymentMethod(pay_method) {
    var order_code = $("#order_code").val();
    $.ajax({
        type: "POST",
        url: "/updatePaymentMethod", // Use the route function to generate the URL
        data: {
            order_code: order_code,
            payment_method: pay_method,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            // console.log(response);
            if (response) {
                $("#payment_method").prop("disabled", true);
                $("#OK").hide();
            }
        },
        error: function (error) {
            console.log("Ajax request failed");
        },
    });
}
