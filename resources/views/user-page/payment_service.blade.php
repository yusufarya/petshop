@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4">
    <div class="heading text-center ">
        <div class="pt-3">
        <h3 style="font-size: 26px; font-weight: 600"> {{ $title }} </h3>
        </div>
    </div>

    <div class="row mt-3 bg-secondary-color mx-3">

        <div class="alert alert-danger">
            <b>Alamat Pengiriman</b> : {{ $auth_user->address }}</b> &nbsp;
            <b>No. Telp</b> : {{ $auth_user->phone }}</b>
        </div>

        <?php 
            $charge = getCharge()->charge;
            $total_price = 0;
        ?>
    
        
        <div class="row bg">

            <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm p-2" style="width: 100%;">
                    @if ($resultData->image)
                        <img src="{{ asset('/storage').'/'.$resultData->image }}" class="card-img-top" alt="img-product">
                    @else
                        <img src="{{ asset('/img/logo.png') }}" class="card-img-top p-3" alt="img-product">
                    @endif
                </div>
            </div>
        
            <div class="col mx-3">
                <h4 style="font-size: 28px; font-weight: 700; text-transform: uppercase;"> sdsadsada  </h4>
                
                <p>
                    <small class="card-text"> 
                        {{-- Ukuran : {{ $resultData->sizes->initial }} --}}
                    </small><br>
                </p>
                {{-- <p class="text-black " style="font-size: 16.5px; line-height: 1.6; text-align: justify"><?= $resultData->description ?></p> --}}
                <div class="row">
                    <div class="col-md-2">Quantity</div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <input type="number" onchange="changeQty()" onkeyup="onlyNumbers(this)" name="qty_dt" id="qty_dt" class="form-control" value="{{ $resultData->qty ? $resultData->qty : '1' }}" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">Harga</div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <input type="text" name="price_dt" id="price_dt" class="form-control bg-transparent" readonly value="{{ number_format($resultData->price,2) }}">
                        <input type="hidden" name="price" id="price" class="form-control bg-transparent" readonly value="{{ $resultData->price }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">Total Harga</div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <input type="text" name="vtotal_price" id="vtotal_price" class="form-control bg-transparent" readonly value="{{ $resultData->qty ? number_format($resultData->price*$resultData->qty,2) : number_format($resultData->price,2) }}">
                        <input type="hidden" name="total_price" id="total_price" class="form-control bg-transparent" readonly value="{{ $resultData->qty ? $resultData->price*$resultData->qty : $resultData->price }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">Jenis Pengiriman</div>
                    <div class="col-md-2"><span class="alert alert-success py-0">Local</span></div>
                    <div class="col-md-2">
                        <input type="text" name="charge_" id="charge_" class="form-control bg-transparent" readonly value="{{ number_format($charge,2) }}">
                        <input type="hidden" name="charge" id="charge" class="form-control bg-transparent" readonly value="{{$charge}}">
                    </div>
                </div>
            </div>
            <hr class="mx-3 mt-3">
            
        </div>
        <?php 
            if($resultData->qty) {
                $total_price += ($resultData->price*$resultData->qty)+$charge;
                // echo $total_price;
            }
        ?>
        

        <div class="row mt-3 px-4">
            <div class="col-md-4"><b>Total Pembayaran</b></div>
            <div class="col-md-2">
                <input type="text" name="vnetto" id="vnetto" class="form-control bg-transparent" style="font-weight: 600; border:none;" readonly value="{{ number_format($total_price,2) }}">
                <input type="hidden" name="netto" id="netto" class="form-control bg-transparent" style="font-weight: 600; border:none;" readonly value="{{ $total_price }}">
            </div>
        </div>

        <div class="row mt-3 px-4">
            <div class="col-md-4"><b>Nomor Transaksi</b></div>
            <div class="col-md-2">
                <span class="ps-2">{{ $resultData->code }}</span>
            </div>
        </div>

        <div class="bg-secondary-color py-4">
            <button type="button" style="float: right;" class="btn btn-danger" onclick="payOrder(`{{ $resultData->code }}`)">Pembayaran</button>
            <button type="button" style="float: right;" class="btn btn-secondary me-3" onclick="cancelOrder(`{{$resultData->code}}`)">
                Batalkan Pesanan
            </button>
        </div>

    </div>

</div>

@endsection

<div class="modal fade" id="cancelOrder" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b><i class="fas fa-exclamation-triangle text-warning"></i>&nbsp; Batalkan Pesanan</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin membatalkan pembayaran? <br> Pesanan ini akan dihapus.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="Y">Ya</button>
        </div>
      </div>
    </div>
</div>