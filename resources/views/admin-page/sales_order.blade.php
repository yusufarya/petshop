@extends('admin-page.layouts.main_layout')

<?php 
// dd($resultData[0]->code);
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
            {{-- <a href="/purchase-order/create" class="btn float-right btn-add "><i class="fas fa-plus-square"></i> &nbsp; Data</a> --}}
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 7%">Nomor</th>
                      <th style="width: 20%">Pelanggan</th>
                      <th style="width: 12%">Tanggal</th>
                      <th style="width: 8%; text-align: right;">Quantity</th> 
                      <th style="width: 12%; text-align: right;">Harga Total</th> 
                      {{-- <th style="width: 12%; text-align: center;">Status Pembayaran</th>  --}}
                      <th style="width: 12%; text-align: center;">Status Pengiriman</th> 
                      <th style="width: 8%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultData as $row)
                <?php 
                switch ($row->delivery) {
                  case 1:
                    $delivery_status = '<span class="alert py-1 alert-info">Siap dikirim</span>';
                    break;
                  case 2:
                    $delivery_status = '<span class="alert py-1 alert-primary">Pengiriman</span>';
                    break;
                  case 3:
                    $delivery_status = '<span class="alert py-1 alert-warning">Selesai</span>';
                    break;
                  case 4:
                    $delivery_status = '<span class="alert py-1 alert-success">Diterima</span>';
                    break;
                  default:
                    $delivery_status = '<span class="alert py-1 alert-secondary">Pengemasan</span>';
                    break;
                }
                
                ?>
                  <tr>
                      <td><?= $row->code ?></td>
                      <td>{{ $row->customers->fullname }}</td>
                      <td>{{ date('d - m - Y', strtotime($row->date)) }}</td>
                      <td style=" text-align: right;">{{ number_format($row->qty,2) }}</td> 
                      <td style=" text-align: right;">{{ number_format($row->total_price,2) }}</td> 
                      {{-- <td style=" text-align: center;">{{ $row->status_payment }}</td> --}}
                      <td style=" text-align: center;"><?= $delivery_status ?> </td>
                      <td style=" text-align: center;">
                        @if ($row->delivery == 4)
                          <a href="#" class="text-info shadow px-2 py-1"> ✅ </a>
                        @else
                          <a href="#" onclick="process(`{{ $row->code }}`, `{{ $row->delivery }}`)" class="text-info shadow px-2 py-1"> Proses</a>
                        @endif
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>

</section> 

<div class="modal fade" id="modal-proses" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-2 font-weight-bold">Update Status Pengiriman</h5>
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <form action="/update-status-delivery" method="POST">
        @csrf
        <div class="modal-body p-3">
          <div class="row mx-1" id="content">
            <input type="hidden" name="code" id="code">

            <div class="col">
              <label for="delivery">Status Pengiriman</label>
              <select name="delivery" id="delivery" class="form-control form-select">
                <option value="0">Pengemasan</option>
                <option value="1">Siap dikirim</option>
                <option value="2">Pengiriman</option>
                <option value="3">Selesai</option>
              </select>
            </div>
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