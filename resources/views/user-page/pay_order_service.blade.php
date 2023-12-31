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
        <b>Nomor Transaksi </b> : {{ $resultData->code }}</b> &nbsp;
    </div>

    <div class="row px-5 py-3">
      <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
          <input type="hidden" name="order_code" id="order_code" value="{{ $resultData->code }}">
            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-control form-select">
                <option value="">Pilih Pembayaran</option>
                @foreach ($payment_method as $item)
                    <option value="{{ $item->id . ' - ' . $item->bank_name . ' - ' . $item->account_number }}" {{ $payment_id == $item->id ? 'selected' : '' }}>
                      {{ $item->bank_name . ' - ' . $item->account_number }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
            <label for="payment_method">&nbsp;</label>
            <button class="btn btn-success mt-4" id="OK"> Ok. </button>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-6 mb-12">
            <h2 id="account_number">
              {{-- load in js --}}
            </h2>

            <h4>Nominal Bayar : Rp. {{ number_format($resultData->nett,2) }}</h4>
            <p class="mt-5 ms-2"> <small>Lakukan pembayaran sebelum 1 X 24 jam</small></p>
        </div>
        <hr>
        <div class="col-md-6 col-lg-6 mt-4">
          <p class="ms-2">
            Telah melakukan pembayaran ? <a href="#" class="text-decoration-none" id="proof_of_payment">Kirim bukti klik disini.</a>
          </p>
        </div>
        <div class="col-md-6 col-lg-6"></div>
        <div class="row" id="upload_bukti" hidden>
          <div class="col-md-5 col-lg-5">
            <label for="img" class="ms-1">Upload Bukti Pembayaran</label>
            <input type="file" name="imagePay" id="imagePay" class="form-control">
          </div>
          <div class="col-md-3">
            <label for="btn">&nbsp;</label>
            <button class="btn btn-success mt-4" id="btnSend" disabled>Kirim</button>
          </div>
        </div>

        <br><br><hr>
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