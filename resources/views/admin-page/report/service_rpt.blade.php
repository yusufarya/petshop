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
                    <th style="text-align: left;">Pelanggan</th>
                    <th style="text-align: left;">Dari Tanggal</th>
                    <th style="text-align: left;">Sampai</th>
                    <th style="text-align: left;">Rincian Layanan</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: center; width:10%;">Status</th>
                </tr>
                <?php 
                    $temp_idOrder = ""; 
                    $sequence = 1;
                    $grand_total_price = 0;
                ?>
                @foreach ($data as $item)

                <?php 
                    $gromming = explode(',', $item->grooming_code);

                    $tgl1 = new DateTime($item->start_date);
                    $tgl2 = new DateTime($item->end_date);
                    $jarak = $tgl2->diff($tgl1);
                    $durasi = $jarak->days;

                    $penitipan = $item->category_id == 1 ? 35000 : 40000;
                ?>
                    {{-- @if ($temp_idOrder <> $item->code) --}}
                    <tr style="font-weight: 600;">
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->customer_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->end_date)) }}</td>
                        <td></td>
                        <td style="text-align: right;">{{ number_format($item->total_price,2) }}</td>
                        <td style="text-align: center">
                            @if ($item->status == 'Y')
                                <span style="background-color: rgb(81, 248, 117); padding: 2px 15px;">Telah Bayar</span>
                            @else
                                <span style="background-color: rgb(248, 81, 81); color: white; padding: 2px 15px;">Belum Bayar</span>
                            @endif
                        </td>
                    </tr>
                    <?php 
                    $sequence = 1;
                    $grand_total_price += $item->total_price;
                    ?> 
                    <tr style="font-size: 13px;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"></td>
                        <td>
                            
                            @if ($item->custody == 'Y') 
                                <div class="mb-2">
                                    Penitipan  : {{ $durasi }} / Hari <sub>x</sub> {{ $item->category_id == 1 ? 'Rp. 35.000' : "40.0000" }} =
                                    {{ number_format($durasi*$penitipan,2) }}
                                </div>
                            @endif

                            @foreach ($gromming as $item)
                            <ul class="ml-3">
                                @if ($item == 'gm1')
                                    <li class="form-check-label" for="grooming1">
                                        Mandi Biasa RP. 40.000
                                    </li>
                                @endif
                                @if ($item == 'gm2')
                                    <li class="form-check-label" for="grooming2">
                                        Mandi Jamur RP. 65.000
                                    </li>
                                @endif
                                @if ($item == 'gm3')
                                    <li class="form-check-label" for="grooming3">
                                        Mandi Kutu RP. 65.000
                                    </li>
                                @endif
                                @if ($item == 'gm4')
                                    <li class="form-check-label" for="grooming4">
                                        Mandi Komplit RP. 65.000
                                    </li>
                                @endif
                            </ul>
                            @endforeach 
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php 
                    // $temp_idOrder = (string)$item->code;
                    ?>
                @endforeach
                <tr style="font-size: 13px; font-weight: 600;">
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;"></td>
                    <td style="padding: 4px;">Grand Total</td>
                    <td style="text-align: right;">{{ number_format($grand_total_price,2) }}</td>
                    <td style="padding: 4px;"></td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>