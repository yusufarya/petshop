$("#submitRpt").on("click", function () {
    var vendor = $("#vendor").val();
    var date = $("#date").val();
    var date1 = $("#date1").val();

    $.ajax({
        type: "GET",
        url: "/purchase-rpt",
        dataType: "JSON",
        data: {
            vendor: vendor,
            date: date,
            date1: date1,
        },
        success: function (data) {
            openRpt();
        },
    });
});

function openRpt() {
    window.popup = window.open(
        "/open-purchase-rpt",
        "rpt",
        "width=1550, height=600, top=10, left=10, toolbar=1"
    );
}
