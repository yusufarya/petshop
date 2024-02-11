@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4">
    <div class="heading text-center ">
        <div class="pt-3">
        <h3 style="font-size: 26px; font-weight: 600"> {{ $title . ' Pet-Shop' }} </h3>
        </div>
    </div>
    <a href="/my-req-orders" class="ms-3 text-danger text-decoration-none">Riwayan layanan saya</a> 
    <div class="pt-2 ms-3"> <p>Note : Jasa pengiriman luar Tangerang akan di alihkan ke jasa expedisi</p> </div>
    @if (session()->has('message'))
        <div class="alert alert-danger py-1 mx-2 text-center">
            {{-- <a href="/update-profile" class="text-decoration-none text-dark font-weight-bolder"> {{ session()->get('message') }}</a> --}}
            <a href="/update-profile" class="text-decoration-none text-dark font-weight-bolder"> <?php echo session()->get('message') ?></a>
        </div>
    @endif
    <form action="/send-custom-request" method="POST" enctype="multipart/form-data" id="submitForm">
        <div class="row mt-3 bg-secondary-color mx-3 p-3">
            @csrf
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="code">Kode Order</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ getLasCodeTransaction('R') }}" readonly>
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="pick_up">Antar Jemput ?</label>
                        <select name="pick_up" id="pick_up" class="form-control form-select @error('pick_up')is-invalid @enderror">
                            {{-- <option value="">Pilih</option> --}}
                            <option value="Y"> » Ya</option>
                            <option value="N"> » Tidak</option>
                        </select>
                        @error('pick_up')
                        <small class="invalid-feedback">
                            Antar Jemput {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="category_id">Kategori </label>
                        <select name="category_id" id="category_id" class="form-control form-select @error('category_id')is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            <option value="1">Kucing</option>
                            <option value="2">Anjing</option>
                            {{-- @foreach ($category as $item)
                                <option value="{{ $item->id }}"> » {{ $item->name }}</option>
                            @endforeach --}}
                        </select>
                        @error('category_id')
                        <small class="invalid-feedback">
                            Kategori {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="date">Dari Tanggal</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ date('Y-m-d') }}" >
                    </div> 
                    <div class="col-md-4 col-lg-4 mt-3">
                        <label for="date">Sampai Tanggal</label>
                        <?php 
                        $date = date('Y-m-d');
                        $date1 = str_replace('-', '/', $date);
                        $tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
                        ?>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $tomorrow }}" >
                    </div>

                    <section class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Y" name="custody" id="penitipan" checked >
                            <label class="form-check-label" for="penitipan" id="labelPenitipan">
                                Penitipan Hewan Per-hari
                            </label>
                        </div>
                        <label class="form-check-label" for="penitipan" id="jumlah-hari">
                            Jumlah hari
                        </label>
                    </section>
                    
                    <section class="ms-1 mt-3">
                        <h6>Grooming / Perawatan Hewan</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gm1" id="grooming1">
                            <label class="form-check-label" for="grooming1">
                                Mandi Biasa RP. 40.000
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gm2" id="grooming2">
                            <label class="form-check-label" for="grooming2">
                                Mandi Jamur RP. 65.000
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gm3" id="grooming3">
                            <label class="form-check-label" for="grooming3">
                                Mandi Kutu RP. 65.000
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="gm4" id="grooming4">
                            <label class="form-check-label" for="grooming4">
                                Mandi Komplit RP. 80.000
                            </label>
                        </div>

                        <table class="table mt-3">
                            <tr>
                                <th>Total Harga : </th>
                                <th><input type="text" name="total_price" id="total_price" class="form-control" value="0"></th>
                                <th><input type="hidden" name="price" id="price" class="form-control" value="0"></th>
                            </tr>
                        </table>
                    </section>

                    <div class="col-md-12 col-lg-12 mt-3">
                        <label for="description">Catatan : </label>
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Tambahkan text ..."></textarea>
                        <input type="hidden" name="grooming_code" id="dataGrooming">
                    </div>
                    
                    <div class="col">
                        <button type="button" id="submitButton" class="btn btn-success mt-2">Submit Pesanan</button>
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