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
            <div class="card mx-1 elevation-1 p-3 w-75">
                
                <div class="row my-4 mx-3">
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="order_code">Nomor Transaksi</label>
                        <input type="text" class="form-control" name="order_code" id="order_code" readonly value="{{ $resultData->code }}">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="text">Nama Pelanggan</label>
                        <input type="text" name="text" id="text" class="form-control" value="{{ $resultData->customers->fullname }}" readonly>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="date">Dari Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d', strtotime($resultData->start_date)) }}" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="date">Sampai Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d', strtotime($resultData->end_date)) }}" readonly>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="category">Kategori</label>
                        <input type="text" name="category" id="category" class="form-control" value="{{ $resultData->category_id == 1 ? 'Kucing :  Rp. 35.000' : 'Anjing :  Rp.40.000' }}" readonly>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                        <label for="qty">Antar Jemput</label>
                        <input type="text" name="qty" id="qty" class="form-control" value="{{ $resultData->pick_up == 'Y' ? "Ya : Rp.35.000" : 'Tidak : Rp. 5.0000' }}" readonly>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8 mt-3 ml-1">
                        <h6><b>Perincian  :</b> </h6>
                        <?php 
                            $gromming = explode(',', $resultData->grooming_code);
                            
                            $tgl1 = new DateTime($resultData->start_date);
                            $tgl2 = new DateTime($resultData->end_date);
                            $jarak = $tgl2->diff($tgl1);
                            $durasi = $jarak->days;

                            $penitipan = $resultData->category_id == 1 ? 35000 : 40000;
                            // dd($penitipan);
                        ?>
                        
                        @if ($resultData->custody == 'Y') 
                            <div class="mb-2">
                                Penitipan  : {{ $durasi }} / Hari <sub>x</sub> {{ $resultData->category_id == 1 ? 'Rp. 35.000' : "40.0000" }} =
                                {{ number_format($durasi*$penitipan,2) }}
                            </div>
                        @endif

                        <h6>Grooming / Perawatan Hewan</h6>

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
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                        <table class="table">
                            <tr>
                                <th>Total Harga</th>
                                <th>{{ number_format($resultData->price,2) }}</th>
                            </tr>
                        </table>
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-8 mt-2">
                        <label for="description">Catatan :</label>
                        <textarea rows="5" name="description" id="description" readonly class="form-control">{{ $resultData->description }}</textarea>
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        {{-- <label for="img">Gambar</label> --}}
                        <img src="{{ asset('/storage').'/'.$resultData->image }}" class="shadow p-2 mt-4 img-fluid w-100" alt="img-request">
                    </div>
                    <button type="button" id="detailPayment" class="btn btn-primary btn-sm mb-2 float-left"> Status Pembayaran </button>
                </div>
    
                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/service-order" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Kembali</a>
                            {{-- <button type="button" id="save" class="btn btn-success">Simpan</button> --}}
                        </section>
                    </section>
                </div>
                
            </div>
        </div>
    </div>

</section> 


<div class="modal fade" id="modal-proses" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ml-2 font-weight-bold">Persetujuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" id="clickDelete">Ya</button>
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
                            <div>Rp. {{ number_format($resultData->nett,2) }},-</div>
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
                                    <form action="/service-orders/{{$resultData->code}}" method="POST">
                                        @csrf
                                        @method("POST")
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