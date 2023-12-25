@extends('admin-page.layouts.main_layout')

<?php 
  $no = 1;
?>

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
            <a href="/purchase-order/create" class="btn float-right btn-add "><i class="fas fa-plus-square"></i> &nbsp; Data</a>
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 7%">Nomor</th>
                      <th style="width: 20%">Vendor</th>
                      <th style="width: 12%">Tanggal</th>
                      <th style="width: 8%; text-align: right;">Quantity</th> 
                      <th style="width: 12%; text-align: right;">Harga Total</th> 
                      <th style="width: 8%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultData as $row)
                  <tr>
                      <td>{{ date('ymd', strtotime($row->date)).'-0'. $row->id }}</td>
                      <td>{{ $row->vendor->name }}</td>
                      <td>{{ date('d - m - Y', strtotime($row->date)) }}</td>
                      <td style=" text-align: right;">{{ number_format($row->qty,2) }}</td> 
                      <td style=" text-align: right;">{{ number_format($row->total_price,2) }}</td> 
                      <td style=" text-align: center;">
                        <a href="/purchase-order/{{$row->id}}/edit" class="text-warning"><i class="fas fa-edit"></i></a>
                        &nbsp;
                        <a href="#" onclick="delete_data(`{{$row->id}}`, `{{$row->name}}`)" class="text-danger"><i class="fas fa-trash-alt"></i></i></a> 
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>

</section> 

<div class="modal fade" id="modal-delete" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-2 font-weight-bold">Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body p-3">
          <div class="row" id="content-delete">
            
          </div>
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="n">Tidak</button>
          <button type="submit" class="btn btn-primary" id="y">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection