@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4">
    <div class="heading text-center ">
        <div class="pt-3">
        <h3 style="font-size: 26px; font-weight: 600"> {{ $title . ' Pet-Shop' }} </h3>
        </div>
    </div>
    <a href="/my-req-orders" class="ms-3 btn btn-danger">Permintaan Saya</a> 
    <div class="pt-2 ms-3"> <p>Note : Jasa pengiriman luar Tangerang akan di alihkan ke jasa expedisi</p> </div>
    <form action="/send-custom-request" method="POST" enctype="multipart/form-data">
        <div class="row mt-3 bg-secondary-color mx-3 p-3">
            @csrf
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="code">Kode Order</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ getLasCodeTransaction('R') }}" readonly>
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="date">Tanggal Jemput</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    {{-- <div class="col-md-4 col-lg-4 mt-3">
                        <label for="date">Tanggal Antar</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}" readonly>
                    </div> --}}
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="size">Ukuran</label>
                        <select name="size_id" id="size_id" class="form-control form-select @error('size_id')is-invalid @enderror">
                            <option value="">Pilih Ukuran</option>
                            {{-- @foreach ($sizes as $item)
                                <option value="{{ $item->id }}">{{ $item->initial .' - '. $item->name  }}</option>
                            @endforeach --}}
                        </select>
                        {{-- @error('size_id')
                        <small class="invalid-feedback">
                            Ukuran {{ $message }}
                        </small>
                        @enderror --}}
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="qty">Quantity</label>
                        <input type="text" class="form-control @error('qty')is-invalid @enderror" name="qty" id="qty" value="0" style="text-align: right;" onkeyup="onlyNumbers(this)">
                        @error('qty')
                        <small class="invalid-feedback">
                            Quantity tidak boleh 0 (nol).
                        </small>
                        @enderror
                    </div>
                    {{-- <div class="col-md-4 col-lg-4 mt-3">
                        <label for="delivery">Jenis Pengiriman</label>
                        <input type="text" class="form-control" name="delivery" id="delivery" value="{{ $delivery->name }}" readonly>
                    </div> --}}
                    {{-- <div class="col-md-4 col-lg-4 mt-3">
                        <label for="vcharge">Ongkos Kirim</label>
                        <input type="text" class="form-control" name="vcharge" id="vcharge" value="{{ number_format($delivery->charge,2) }}" readonly style="text-align: right;">
                        <input type="hidden" class="form-control" name="charge" id="charge" value="{{ $delivery->charge }}" readonly style="text-align: right;">
                    </div> --}}
                    
                    {{-- <div class="col-md-12 col-lg-12 mt-3">
                        <label for="description">Catatan : </label>
                        <textarea type="text" class="form-control" rows="5" name="description" id="description" value="{{ number_format($delivery->charge,2) }}"></textarea>
                    </div> --}}
                    
                    <div class="col">
                        <button type="submit" class="btn button-submit secondary-color mt-2">Submit Pesanan</button>
                    </div>

                </div>
            </div>
            <div class="col ms-3">
                <img src="{{ asset('img/default.png')}}" class="img-fluid bg-white mt-4" id="blah" alt="defaul_user" style="height: 300px; padding: 0px;">
                <input type="file" class="form-control mt-2 @error('image')is-invalid @enderror" name="image" id="image" style="width: 75%;">
                @error('image')
                <small class="invalid-feedback">
                    File {{ $message }}
                </small>
                @enderror
            </div>
        </div>
    </form>

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