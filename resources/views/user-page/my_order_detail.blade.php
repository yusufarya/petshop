
@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4">
  <hr>
    <div class="heading text-center">
        <div class="pt-3">
        <h3 style="font-size: 26px; font-weight: 600"> {{$title}} </h3>
        </div>
    </div>

    <div class="row justify-content-center bg-secondary-color rounded pb-3 px-3 mt-3 mx-auto w-75">
        
        @foreach ($my_order_detail as $header)
            <div class="row">
                <div class="col">
                    <h3 class="mt-3"> {{ $header->code }} </h3>
                    <span class="alert alert-danger py-2 mx-1">Tanggal Pesanan {{ date('d, m Y', strtotime($header->date)) }} </span>
                </div>
                <div class="col">
                    <div class="mt-3">
                        <a href="/my-orders" class="mt-3 text-decoration-none btn text-dark" style="float: right">« Kembali</a>
                    </div>
                </div>
            </div>

            @if (count($header->salesOrderMany) > 0)
                @foreach ($header->salesOrderMany as $item)
                <div class="row p-3">
                    <div class="col-md-7">
                        <table class="table table-group-divider table-sm rounded">
                            <tr>
                                <th style="width: 30%;">Nama Produk</th>
                                <td>{{ $item->products->name }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Kategori</th>
                                <td>{{ $item->products->categories->name }}</td>
                            </tr> 
                            <tr>
                                <th style="width: 30%;">Size</th>
                                <td>{{ $item->products->sizes->name }}</td>
                            </tr>
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Quantity</th>
                                <td style="text-align: right; padding-right:10px;">{{ $item->qty }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Harga</th>
                                <td style="text-align: right; padding-right:10px;"><sub> {{ $item->qty }} x </sub> {{ number_format($item->price,2) }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Total Harga </th>
                                <td style="text-align: right; padding-right:10px;"> {{ number_format($item->price*$item->qty,2) }} </td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Ongkir</th>
                                <td style="text-align: right; padding-right:10px;"> {{ number_format($item->charge,2) }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%;">Total Bayar</th>
                                <td style="text-align: right; padding-right:10px;"> {{ number_format(($item->price*$item->qty) + $item->charge,2) }} </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-5"> 
                        <img src="{{ asset('/storage').'/'.$item->products->image }}" alt="image-detail" class="img-fluid img-bordered rounded" style="max-height: 350px;">
                    </div>
                </div>
                @endforeach
            @endif

        @endforeach

    </div>

</div>

@endsection
 