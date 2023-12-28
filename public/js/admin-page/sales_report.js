$("#submitRpt").on("click", function () {
    var customer = $("#customer").val();
    var date = $("#date").val();
    var date1 = $("#date1").val();

    $.ajax({
        type: "GET",
        url: "/sales-rpt",
        dataType: "JSON",
        data: {
            customer: customer,
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
        "/open-sales-rpt",
        "rpt",
        "width=1550, height=600, top=10, left=10, toolbar=1"
    );
}
