$(async function () {
    $("#detail-list").hide();

    async function getAllProduct() {
        const headers = new Headers({
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        });

        const dataFechh = await fetch("/getProducts", {
            method: "GET",
            headers: headers,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((response) => {
                return response.data;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });

        return dataFechh;
    }

    const allProducts = await getAllProduct();

    $("#addDetail").on("click", () => {
        let vendor_code = $("#vendor_code").val();
        let date = $("#date").val();

        if (!vendor_code) {
            alert("Vendor masih kosong");
        }

        if (vendor_code) {
            $.ajax({
                type: "POST",
                url: "/purchase-order/addDetail", // Use the route function to generate the URL
                data: {
                    vendor_code: vendor_code,
                    date: date,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    $("#addDetail").hide(100);
                    const no_trans = get_ymd(date);
                    // console.log(no_trans + response.dataId);
                    $("#vendor_code").prop("disabled", true);
                    $("#codeTrans").val(no_trans + response.dataId);
                    $("#purchase_order_id").val(response.dataId);
                    $("#detail-list").show(100);
                    // Handle the response here
                },
                error: function (error) {
                    console.log("Ajax request failed");
                },
            });
        }
    });

    var no = 1;
    $("#add-new").click(() => {
        //
        console.log("add new click");
        $("#add-new").prop("disabled", true);
        const otpAllProducts = allProducts.map((item, index) => {
            console.log(item);
            var options =
                `<option value="` +
                item.id +
                `">
                    » &nbsp; ` +
                item.name +
                ` / ` +
                item.categories.name +
                ` / ` +
                item.sizes.initial +
                `
                </option>`;

            return options;
        });

        var sequence = no++;

        var htmlrow =
            `<tr>
                <td><input type="text" name="no" id="no" class="border-0" value="` +
            sequence +
            `"></td>
                <td>
                    <select class="form-control" name="product_id" id="product_id">
                    <option value="">Pilih Produk</option> ` +
            otpAllProducts +
            `
                    </select>
                </td>
                <td><input type="text" name="qty_dt" id="qty_dt" class="form-control" placeholder="0" onkeyup="onlyNumbers(this);" style="text-align: right;"></td>
                <td><input type="text" name="price_dt" id="price_dt" class="form-control" placeholder="0" onkeyup="formatRupiah(this, this.value);" style="text-align: right;"></td>
                <td style="text-align: center">
                    <button type="button" id="add" class="btn btn-add pt-1"> <i class="fas fa-plus-square"></i> </button> |
                    <button type="button" id="cancel" class="btn text-danger p-0"> <i class="fas fa-times-circle"></i> </button>
                </td>
            </tr>`;

        $("#container-table tbody").append(htmlrow);

        $("#add").on("click", () => {
            // alert("p");
            let sequence = $("#no").val();
            let product_id = $("#product_id").val();
            let date = $("#date").val();
            let qty_dt = $("#qty_dt").val();
            let price_dt = $("#price_dt").val();
            let purchase_order_id = $("#purchase_order_id").val();

            if (!product_id) {
                alert("Produk masih kosong");
            }

            if (product_id) {
                $.ajax({
                    type: "POST",
                    url: "/purchase-order_detail/add", // Use the route function to generate the URL
                    data: {
                        product_id: product_id,
                        sequence: sequence,
                        date: date,
                        qty_dt: qty_dt,
                        price_dt: price_dt,
                        purchase_order_id: purchase_order_id,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        // Handle the response here
                        $("#add-new").prop("disabled", false);
                        load_data_detail(purchase_order_id);
                    },
                    error: function (error) {
                        console.log("Ajax request failed");
                    },
                });
            }
        });
    });

    $(document).on("click", "#edit", function () {
        $("#container-table tr").find("td:eq(4)").hide();
        $(this).closest("tr").find("td:eq(4)").show();
        $("#add-new").prop("disabled", true);
        var no = $(this).closest("tr").find("td:eq(0)").text();
        var qty = $(this).closest("tr").find("td:eq(2)").text();
        var price = $(this).closest("tr").find("td:eq(3)").text();
        var product = $(this).closest("tr").find("td:eq(1)").text();
        var product_name = product.split("/");

        $(this)
            .closest("tr")
            .find("td:eq(2)")
            .html(
                `<input type="text" name="qty_dt" id="qty_dt" class="form-control" placeholder="0" onkeyup="onlyNumbers(this);" style="text-align: right;" value="` +
                    qty +
                    `">`
            );
        $(this)
            .closest("tr")
            .find("td:eq(3)")
            .html(
                `<input type="text" name="price_dt" id="price_dt" class="form-control" placeholder="0" onkeyup="formatRupiah(this, this.value);" style="text-align: right;" value="` +
                    price +
                    `">`
            );
        $(this)
            .closest("tr")
            .find("td:eq(4)")
            .html(
                `<button type="button" onclick="updateDetail(` +
                    no +
                    `, '` +
                    product_name[0] +
                    `')" class="btn btn-add pt-1"> <i class="fas fa-plus-square"></i> </button>`
            );
    });

    $(document).on("click", "#cancel", function () {
        // console.log("cancel click");
        $("#add-new").prop("disabled", false);
        no = no - 1;
        $(this).closest("tr").remove();
    });

    $(document).on("click", "#delete", function () {
        $("#add-new").prop("disabled", false);
        let purchase_order_id = $("#purchase_order_id").val();
        var no = $(this).closest("tr").find("td:eq(0)").text();
        var product = $(this).closest("tr").find("td:eq(1)").text();
        var product_name = product.split("/");
        $("#modal-delete").modal("show");
        $("#modal-delete .modal-title").text("Hapus data nomor " + no);

        $("#clickDelete").click(() => {
            $.ajax({
                type: "DELETE",
                url: "/purchase-order_detail/delete", // Use the route function to generate the URL
                data: {
                    product_name: product_name[0],
                    purchase_order_id: purchase_order_id,
                    sequence: no,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    $("#add-new").prop("disabled", false);
                    $("#modal-delete").modal("hide");
                    load_data_detail(purchase_order_id);
                },
                error: function (error) {
                    console.log("Ajax request failed");
                },
            });
        });
    });

    $("#saveButton").on("click", () => {
        let purchase_order_id = $("#purchase_order_id").val();
        $.ajax({
            type: "POST",
            url: "/submit-purchase_order", // Use the route function to generate the URL
            data: {
                purchase_order_id: purchase_order_id,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // console.log(response);
                $("#add-new").prop("disabled", false);
                load_data_detail(purchase_order_id);
                // Handle the response here
                location.href = "/purchase-order";
            },
            error: function (error) {
                console.log("Ajax request failed");
            },
        });
    });
});

function updateDetail(no, product_name) {
    let qty_dt = $("#qty_dt").val();
    let price_dt = $("#price_dt").val();
    let purchase_order_id = $("#purchase_order_id").val();
    $.ajax({
        type: "POST",
        url: "/purchase-order_detail/edit", // Use the route function to generate the URL
        data: {
            product_name: product_name,
            sequence: no,
            qty_dt: qty_dt,
            price_dt: price_dt,
            purchase_order_id: purchase_order_id,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            // console.log("add update click");
            // console.log(response);
            // Handle the response here
            $("#add-new").prop("disabled", false);
            load_data_detail(purchase_order_id);
        },
        error: function (error) {
            console.log("Ajax request failed");
        },
    });
}

async function load_data_detail(purchase_order_id) {
    $("#container-table tbody").html("");
    const headers = new Headers({
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    });

    const dataFechhDetail = await fetch(
        "/getPurchase_order_detail/" + purchase_order_id,
        {
            method: "GET",
            headers: headers,
        }
    )
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });

    // console.log("dataFechhDetail => ");
    // console.log(dataFechhDetail);

    var html_load_row = "";
    dataFechhDetail.map((item, index) => {
        // table detail //
        html_load_row +=
            `<tr>
                <td>` +
            item.sequence +
            `   </td>
                <td>` +
            item.products.name +
            ` / ` +
            item.products.categories.name +
            ` / ` +
            item.products.sizes.initial +
            `   </td>
                <td style="text-align: right;">` +
            item.qty +
            `   </td>
                <td style="text-align: right;">` +
            item.price +
            `   </td>
                <td style="text-align: center">
                    <button type="button" id="edit" class="btn text-warning p-0"> <i class="fas fa-edit"></i> </button>|
                    <button type="button" id="delete" class="btn text-danger p-0"> <i class="fas fa-trash-alt"></i> </button>
                </td>
            </tr>`;
    });
    $("#container-table tbody").append(html_load_row);
}
