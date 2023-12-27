<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <style>
        @font-face {
            font-family: Nutino;
            src: url(../font/Nunito/Nunito-VariableFont_wght.ttf);
        }
        h1 {
            font-family: "Nutino";
        }
        table tr th {
            padding: 3.5px 5px !important;
            background-color: #af4425;
            color: aliceblue;
        }
        table, td, th {
            border: 1px solid black;
            padding: 2px 5px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13.5px;
        }

        .table {
            border-collapse: collapse;
        }

        h1 {
            padding: 0;
        }
        .wrapper {
            padding: 0 10px;
        }
        
    </style>
</head>

<body>

    <div class="wrapper">
        <div style="float: right;">
            <a href="/export_registrant">
                <img src="{{ asset('img/excel.png') }}" alt="excel" style="height: 40px;">
                <label for="print" style="display : block; font-size: 12px; margin-left: 4px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">export</label>
                <br>
            </a>
        </div>
        <h1> {{ $title }} </h1>
        <div style="display: flex; width: 100%;">
            <table class="table" style="width: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <tr>
                    <th style="text-align: left; width: 10%;">Nomor Transaksi</th>
                    <th style="text-align: left;">Vendor</th>
                    <th style="text-align: left;">Tanggal</th>
                    <th style="text-align: left;">Rincian Produk</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                </tr>
                <?php 
                    $temp_idOrder = ''; 
                    $sequence = 1;
                    $grand_total_qty = 0;
                    $grand_total_price = 0;
                ?>
                @foreach ($data as $item)
                    @if ($temp_idOrder <> $item->purchase_order_code)
                        <tr style="font-weight: 600;">
                            <td>{{ date('ymd', strtotime($item->date)).'-0'.$item->purchase_order_code }}</td>
                            <td>{{ $item->vendor_name }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($item->total_qty,2) }}</td>
                            <td style="text-align: right;">{{ number_format($item->total_price,2) }}</td>
                        </tr>
                        <?php 
                        $sequence = 1;
                        $grand_total_qty += $item->total_qty;
                        $grand_total_price += $item->total_price;
                        ?>
                    @endif
                    <tr style="font-size: 13px;">
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">{{ $sequence++ }}.</td>
                        <td>{{ $item->product_name }}</td>
                        <td style="text-align: right;">{{ number_format($item->qty,2) }}</td>
                        <td style="text-align: right;">{{ number_format($item->price,2) }}</td>
                    </tr>
                    <?php 
                    $temp_idOrder = $item->purchase_order_code;
                    ?>
                @endforeach
                <tr style="font-size: 13px; font-weight: 600;">
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;">Grand Total</td>
                    <td style="text-align: right;">{{ number_format($grand_total_qty,2) }}</td>
                    <td style="text-align: right;">{{ number_format($grand_total_price,2) }}</td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>