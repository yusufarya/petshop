$(function () {
    $("#status").on("change", () => {
        $("#submitForm").submit();
    });
    $("#delivery").on("change", () => {
        $("#submitForm").submit();
    });
});

function acc_order(code) {
    console.log(code);
    var acc = confirm("terima Pesanan");
    if (acc) {
        $.ajax({
            type: "POST",
            url: "acc-order",
            data: {
                code: code,
                delivery: 4,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Handle the response here
                // console.log(response);
                if (response.status == "success") {
                    setTimeout(() => {
                        $("#delivery").val(4);
                        $("#submitForm").submit();
                        // location.href.reload();
                    }, 100);
                } else {
                    alert("Proses gagal, Hubungi Administrator.");
                }
            },
            error: function (error) {
                console.log("Ajax request failed");
            },
        });
    }
}
