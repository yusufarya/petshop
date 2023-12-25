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
          <div class="row justify-content-end mb-2 w-100">
            {{-- <a href="/add-data-admin" class="btn float-right btn-add "><i class="fas fa-plus-square"></i> &nbsp; Data</a> --}}
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 11%"></th>
                      <th>Nama Lengkap</th>
                      <th style="width: 11%">Jenis Kelamin</th>
                      <th>Email</th>
                      <th style="width: 10%; text-align: center;">Status</th>
                      <th style="width: 10%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($dataCustomers as $row)
                  <tr>
                      <td>{{ $row->code }}</td>
                      <td>{{ $row->fullname }}</td>
                      <td>{{ $row->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                      <td>{{ $row->email }}</td>
                      <td style=" text-align: center;">
                        <?= $row->is_active == 'Y' ? ' <i class="fas fa-check-square text-success"></i>' : ' <i class="fas fa-window-close text-danger"></i>' ?>
                      </td>
                      <td style=" text-align: center;">
                        <a href="/detail-customer/{{ $row->code }}" class="text-info">Detail <i class="fas fa-info-circle"></i></a>
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>
</section> 

@endsection