
@extends('user-page.layouts.user_main')

@section('content-pages')
<?php 
// dd($auth_user->date_of_birth);
$date_of_birth = $auth_user->date_of_birth ? date('d, M Y', strtotime($auth_user->date_of_birth)) : '-- / -- / ----';
?>
<hr>
<div class="p-3 rounded-2 shadow">
    <div class="row justify-content-center">
        <h3 class="text-center mb-4"><b> {{ $auth_user->fullname }} </b></h3>
        <div class="col-lg-3">
            @if(!$auth_user->image)
                <img src="{{ asset('img/userDefault.png') }}" class="shadow mb-2" style="width : 282px;" alt="User Image">
            @else
                <img src="{{ asset('/storage').'/'.$auth_user->image }}" class="shadow mb-2" style="width : 282px;" alt="User Image">
            @endif
            <span class="text-left"><small class="pt-2">Bergabung sejak, {{ date('d, M Y', strtotime($auth_user->created_at)) }}</small></span>
        </div>
        <div class="col-lg-9">
            
            <table class="table table-info">
                <tr>
                    <th style="width: 30%;">Nomor Peserta</th>
                    <td><b> : &nbsp; {{ $auth_user->code }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Username</th>
                    <td><b> : &nbsp; {{ $auth_user->username }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Jenis Kelamin</th>
                    <td><b> : &nbsp; {{ $auth_user->gender == "M" ? "Laki-laki" : "Perempuan" }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">No. Telp</th>
                    <td><b> : &nbsp; {{ $auth_user->phone }}</b></td>
                </tr>
                
                <tr>
                    <th style="width: 30%;">Tempat Tanggal Lahir</th>
                    <td>
                        <b> : &nbsp; 
                        {{ $auth_user->place_of_birth.', '. $date_of_birth }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <th style="width: 30%;">Email</th>
                    <td><b> : &nbsp; {{ $auth_user->email }}</b></td>
                </tr>
            </table>
            <div class="mx-0">
                <button type="button" class="btn btn-outline-primary py-1" id="see-more">Tampilkan alamat untuk pengiriman <i class="fas fa-chevron-down ms-2"></i></button>
                <button type="button" class="btn btn-outline-secondary py-1" id="see-less">Tutup<i class="fas fa-chevron-up ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="p-3 rounded-2 shadow mt-0" id="additional-data">
    <div class="row">
        <div class="col">
            {{-- <label class="my-3 py-1 alert alert-danger" ><b>Data lainnya</b></label> --}}
            <hr class="p-0 m-0">
            <table class="table">
                <tr>
                    <th style="width: 30%;">Kota</th>
                    <td><b> : &nbsp; {{ $auth_user->city }} </b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Alamat Lengkap</th>
                    <td><b> : &nbsp; {{ $auth_user->address }} </b></td>
                </tr>
            </table>
        </div>
    </div>

    <span>Untuk dapat melakukan pembelian silahkan lengkapi data terlebih dahulu. <a href="/update-profile" class="text-decoration-none"><b>Lengkapi data disini</b></a></span>
</div>

@endsection
