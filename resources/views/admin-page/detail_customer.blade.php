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
<?php 
$date_of_birth = $detailCustomer->date_of_birth ? date('d, M Y', strtotime($detailCustomer->date_of_birth)) : '-- / -- / ----';
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          
            <div class="col-lg-7">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Nomor Peserta</th>
                        <td>{{ $detailCustomer->code }} </td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $detailCustomer->fullname }} </td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $detailCustomer->gender == 'M' ? 'Laki-laki' : 'Perempuan' }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">No. Telp</th>
                        <td> {{ $detailCustomer->phone }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">No. Whatsapp</th>
                        <td> {{ $detailCustomer->phone }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Tempat Tanggal Lahir</th>
                        <td> {{ $detailCustomer->place_of_birth.', '. $date_of_birth }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Alamat</th>
                        <td> {{ $detailCustomer->address }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Email</th>
                        <td> {{ $detailCustomer->email }} </td>
                    </tr>

                    {{-- lainnya --}}
                    
                    <tr>
                        <th style="width: 30%;">Alamat</th>
                        <td> {{ $detailCustomer->address }} </td>
                    </tr>
                    {{-- dokument --}}
                     
                </table>
            </div>

            <div class="col-lg-5">
                <table class="table table-bordered table-sm">
                    <tr>
                        @if($detailCustomer->image == '')
                            <img src="{{ asset('img/userDefault.png') }}" class="shadow mb-2" style="width : 100%;" alt="User Image">
                        @else
                            <img src="{{ asset('/storage').'/'.$detailCustomer->image }}" class="shadow mb-2" style="width : 100%;" alt="User Image">
                        @endif
                        <div class="text-left"><small class="pt-2">Bergabung sejak, {{ date('d, M Y', strtotime($detailCustomer->created_at)) }}</small></div>
                    </tr> 
                </table>
            </div>

        </div>
    </div>
</section> 

<div class="modal fade" id="modal-detail" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3 font-weight-bold">Detail Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3">
        <div class="row">
          <div class="col-lg-3 px-1" style="max-width: 28%;">
            <img src="" class="imgProfile" alt="imgProfile" style="height: 210px;">
            <div id="since" class="text-center text-sm w-100"></div>
          </div>
          <div class="col-lg-8">
            <table class="table table-striped" id="tb-detail"></table>
          </div> 
        </div>
      </div> 
    </div>
  </div>
</div>

@endsection