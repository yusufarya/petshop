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
            <b>Alamat Lengkap Anda</b> : {{ $auth_user->address }}</b> &nbsp;
            <b>No. Telp</b> : {{ $auth_user->phone }}</b>
        </div> 
    
        
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
                <h4 style="font-size: 28px; font-weight: 700; text-transform: uppercase;"> Rincian Layanan </h4>
                
                <p>
                    <strong class="card-text"> 
                        Kategori : {{ $resultData->category_id == 1 ? 'Kucing' : "Anjing " }}
                    </strong><br>
                    <?php 
                    
                        $tgl1 = new DateTime($resultData->start_date);
                        $tgl2 = new DateTime($resultData->end_date);
                        $jarak = $tgl2->diff($tgl1);
                        $durasi = $jarak->days;

                        $penitipan = $resultData->category_id == 1 ? 35000 : 40000;
                        // dd($penitipan);
                        
                    ?>
                    @if ($resultData->custody)
                        <strong class="card-text"> 
                            Penitipan  : {{ $durasi }} / Hari <sub>x</sub> {{ $resultData->category_id == 1 ? 'Rp. 35.000' : "40.0000" }} =
                            {{ number_format($durasi*$penitipan,2) }}
                        </strong><br>
                    @endif
                        
                    <strong class="card-text"> 
                        {{ $resultData->pick_up == 'Y' ? 'Antar Jemput Rp. 35.000' : "Bawa Sendiri 5.000" }}
                    </strong><br>
                </p>
                <p class="text-black " style="font-size: 16.5px; line-height: 1.6; text-align: justify"><?= $resultData->description ?></p>
                <?php 
                $gromming = explode(',', $resultData->grooming_code);
                ?>
                <h6>Grooming / Perawatan Hewan</h6>

                @foreach ($gromming as $item)
                <ul>
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
            <hr class="mx-3 mt-3">
            
        </div>

        <div class="row mt-3 px-4">
            <div class="col-md-4"><b>Total Pembayaran</b></div>
            <div class="col-md-2">
                <input type="text" name="vnetto" id="vnetto" class="form-control bg-transparent" style="font-weight: 600; border:none;" readonly value="{{ number_format($resultData->price,2) }}">
                <input type="hidden" name="netto" id="netto" class="form-control bg-transparent" style="font-weight: 600; border:none;" readonly value="{{ $resultData->price }}">
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