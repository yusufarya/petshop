$(function () {
    const imgInp = document.getElementById("image");
    let blah = document.getElementById("blah");
    imgInp.onchange = (evt) => {
        const [file] = imgInp.files;
        console.log(file);
        if (file) {
            blah.src = URL.createObjectURL(file);
        }
    };
    var Difference_In_Days = 1;
    var total_gm = 0;
    var biaya_penitipan = 0;
    var type_penitipan = 0;
    var pickUp = 0;
    var grooming1 = 0;
    var grooming2 = 0;
    var grooming3 = 0;
    var grooming4 = 0;
    var dataGrooming = [];

    let date1 = formatDate($("#start_date").val());
    let date2 = formatDate($("#end_date").val());
    calculateDays(date1, date2);

    let pick_up_ = $("#pick_up").val();

    if (pick_up_ == "Y") {
        pickUp = 35000;
    } else if (pick_up_ == "N") {
        pickUp = 5000;
    }
    calculate();

    $("#pick_up").change(function () {
        let pick_up_ = $("#pick_up").val();

        if (pick_up_ == "Y") {
            pickUp = 35000;
        } else if (pick_up_ == "N") {
            pickUp = 5000;
        }
        calculate();
    });

    $("#category_id").change(function () {
        let thisVal = $(this).val();
        console.log(thisVal);

        if (thisVal == 1) {
            type_penitipan = 35000;
            var hewan = "Kucing : ";
        } else if (thisVal == 2) {
            type_penitipan = 40000;
            var hewan = "Anjing : ";
        }
        const text =
            "Penitipan Hewan Per-hari -  " +
            hewan +
            " RP. " +
            replaceRupiah(type_penitipan);
        $("#labelPenitipan").text(text);
        calculate();

        let fromDate = formatDate($("#start_date").val());
        let toVal = formatDate($("#end_date").val());
        calculateDays(fromDate, toVal);
    });

    $("#start_date").change(function () {
        let thisVal = formatDate($(this).val());
        let toVal = formatDate($("#end_date").val());
        calculateDays(thisVal, toVal);
    });

    $("#end_date").change(function () {
        let thisVal = formatDate($("#start_date").val());
        let toVal = formatDate($(this).val());
        calculateDays(thisVal, toVal);
    });

    function calculateDays(fromDate, toDate) {
        let date1 = new Date(fromDate);
        let date2 = new Date(toDate);

        // To calculate the time difference of two dates
        let Difference_In_Time = date2.getTime() - date1.getTime();
        // console.log(Difference_In_Time);
        // To calculate the no. of days between two dates
        var Difference_In_Days = Math.round(
            Difference_In_Time / (1000 * 3600 * 24)
        );
        let penitipan = $("input#penitipan").is(":checked");
        if (penitipan) {
            var hargaPenitipan = type_penitipan;
        } else {
            var hargaPenitipan = 0;
        }
        $("#jumlah-hari").text(
            "Jumlah hari : " +
                Difference_In_Days +
                " X " +
                replaceRupiah(hargaPenitipan) +
                " = " +
                replaceRupiah(Difference_In_Days * hargaPenitipan)
        );
        biaya_penitipan = Difference_In_Days * hargaPenitipan;

        calculate();
        return Difference_In_Days;
    }

    $("#penitipan").change(function () {
        if ($("input#penitipan").is(":checked")) {
            $("#jumlah-hari").show();
        } else {
            $("#jumlah-hari").hide();
        }
        calculate();
    });

    $("#grooming1").change(function () {
        let thisVal = $(this).val();

        grooming1 = 40000;
        if ($("input#grooming1").is(":checked")) {
            dataGrooming.push(thisVal);
        } else {
            remove(dataGrooming, thisVal);
        }
        var gm1 = $("input#grooming1").is(":checked");
        if (gm1) {
            total_gm += grooming1;
        } else {
            total_gm -= grooming1;
        }
        calculate();
    });

    $("#grooming2").change(function () {
        let thisVal = $(this).val();

        grooming2 = 65000;
        if ($("input#grooming2").is(":checked")) {
            dataGrooming.push(thisVal);
        } else {
            remove(dataGrooming, thisVal);
        }
        var gm2 = $("input#grooming2").is(":checked");
        if (gm2) {
            total_gm += grooming2;
        } else {
            total_gm -= grooming2;
        }
        calculate();
    });

    $("#grooming3").change(function () {
        let thisVal = $(this).val();

        grooming3 = 65000;
        if ($("input#grooming3").is(":checked")) {
            dataGrooming.push(thisVal);
        } else {
            remove(dataGrooming, thisVal);
        }
        var gm3 = $("input#grooming3").is(":checked");
        if (gm3) {
            total_gm += grooming3;
        } else {
            total_gm -= grooming3;
        }
        calculate();
    });

    $("#grooming4").change(function () {
        let thisVal = $(this).val();

        grooming4 = 80000;
        if ($("input#grooming4").is(":checked")) {
            dataGrooming.push(thisVal);
        } else {
            remove(dataGrooming, thisVal);
        }
        var gm4 = $("input#grooming4").is(":checked");
        if (gm4) {
            total_gm += grooming4;
        } else {
            total_gm -= grooming4;
        }
        calculate();
    });

    function calculate() {
        $("#dataGrooming").val(dataGrooming);
        const penitipan = $("input#penitipan").is(":checked");
        if (penitipan) {
            var harga_titip = biaya_penitipan;
        } else {
            var harga_titip = 0;
        }
        console.log("total_gm = " + total_gm);
        const total = harga_titip + pickUp + total_gm;
        $("#total_price").val(replaceRupiah(total));
        $("#price").val(total);
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

    $("#submitButton").on("click", function () {
        var pick_up = $("#pick_up").val();
        let date1 = formatDate($("#start_date").val());
        let date2 = formatDate($("#end_date").val());
        const total_hari = calculateDays(date1, date2);
        const penitipan = $("input#penitipan").is(":checked");

        if (!pick_up) {
            alert("Antar jemput belum di pilih");
        }
        if (total_hari <= 0 && penitipan) {
            alert("Durasi hari penitipan tidak valid");
        } else {
            $("#submitForm").submit();
        }
    });
});
