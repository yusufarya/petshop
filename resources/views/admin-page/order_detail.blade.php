@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-2">{{ $title}}</h3>
      </div><!-- /.col --> 
    </div><!-- /.row -->
    <hr style="margin-bottom: 0">
  </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
            <div class="card mx-1 elevation-1 p-3 w-100">
                
                <div class="row my-4 mx-3">
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="vendor_code">Nomor Transaksi</label>
                        <input type="text" class="form-control" name="purchase_order_code" id="purchase_order_code" readonly value="{{ $dataHeader->code }}">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="text">Nama Pelanggan</label>
                        <input type="text" name="text" id="text" class="form-control" value="{{ $dataHeader->customers->fullname }}" readonly>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d', strtotime($dataHeader->date)) }}" readonly>
                    </div>

                    {{-- TABLE PURCHASE ORDER DETAIL --}}
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2" id="detail-list">
                        <button type="button" id="detailPayment" class="btn btn-primary btn-sm mb-2 float-left"> Status Pembayaran </button>
                        <table class="table" id="container-table">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No.</th>
                                    <th colspan="2">Rincian Produk</th>
                                    <th style="text-align: right; width: 100px;">Qty</th>
                                    <th style="text-align: right; width: 120px;">Harga</th>
                                    <th style="text-align: right; width: 100px;">Ongkir</th>
                                    <th style="text-align: right; width: 130px;">Total Harga</th>
                                    <th style="text-align: center; width: 120px;">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                ?>
                                @foreach ($dataDetail as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->products->name }}</td>
                                        <td style="width: 100px;">Ukuran : &nbsp; {{ $item->products->sizes->initial }}</td>
                                        <td style="text-align: right;">{{ number_format($item->qty,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($item->price,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($item->charge,2) }}</td>
                                        <td style="text-align: right;">{{ number_format(($item->qty*$item->price)+$item->charge,2) }}</td>
                                        <td style="text-align: center">
                                            <a href="#" class="text-success shadow px-2 py-1" onclick="detail(`{{ $item->sequence }}`, `{{ $item->products->name }}`)"><i class="fas fa-info-circle"></i> Produk</a>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
    
                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/orders" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Kembali</a>
                        </section>
                    </section>
                </div>
                
            </div>
        </div>
    </div>

</section> 


<div class="modal fade" id="modal-product-detail" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ml-2 font-weight-bold">Persetujuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row" id="content-detail">
                <div class="col-md-5 col-lg-5">
                    <img src="" alt="img-product" class="img-fluid" id="img-product">
                </div>
                <div class="col">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>:&nbsp;</td>
                            <td id="name"></td>
                        </tr> 
                        <tr>
                            <th>Kategori</th>
                            <td>:&nbsp;</td>
                            <td id="category"></td>
                        </tr>
                        <tr>
                            <th>Ukuran</th>
                            <td>:&nbsp;</td>
                            <td id="size"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            {{-- <button type="button" class="btn btn-primary" id="clickDelete">Ya</button> --}}
        </div> 
      </div>
    </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ml-2 font-weight-bold">Detail Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            @if ($orderPayment && $orderPayment->payment_methods)
                
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-5">
                        <img src="{{ asset('/storage').'/'.$orderPayment->image }}" class="img-fluid" alt="imgpayment" style="height: 300px; width: auto;">
                    </div>
                    <div class="col">
                        <div class="mt-3">
                            <label for="payment_methods">Metode Pembayaran</label>
                            <div>{{ $orderPayment->payment_methods->bank_name }} - {{ $orderPayment->payment_methods->account_number }}</div>
                        </div>
                        <div class="mt-3">
                            <label for="payment_methods">Nominal Pembayaran</label>
                            <div>Rp. {{ number_format($dataHeader->nett,2) }},-</div>
                        </div>
                        <div class="mt-3">
                            <label for="payment_methods">Status Pesanan</label>
                            <div class="w-50 text-center">
                                @switch($orderPayment->status)
                                    @case("Approve")
                                        <div class="alert alert-success"> Disetujui </div>
                                        @break
                                    @case("Reject")
                                            <div class="alert alert-danger"> Ditolak </div>
                                        @break
                                    @default
                                    <div class="alert alert-warning"> Menunggu Persetujuan </div>
                                    <form action="/orders/{{$dataHeader->code}}/detail" method="GET">
                                        @csrf
                                        <input type="hidden" name="status" value="Y">
                                        <button type="submit" class="btn btn-success"> Terima Pesanan </button>
                                    </form>
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>

            @else
                
            <div class="row justify-content-center"> 
                <br><br>
                <div class="mt-3">
                    <span class="alert alert-danger">Pelanggan belum melakukan pembayaran</span>
                </div>
                <br><br>
            </div>
            @endif
        </div>
        
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div> 
      </div>
    </div>
</div>

@endsection