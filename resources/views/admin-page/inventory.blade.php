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
            {{-- <a href="/export-inventory" class="btn float-right btn-success "><i class="fas fa-file-excel"></i> &nbsp; export</a> --}}
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 3%">#</th>
                      <th>Nama Produk</th>
                      <th style="width: 12%">Kategori</th>
                      <th style="width: 6%">Satuan</th>
                      <th style="width: 6%">Ukuran</th> 
                      <th style="width: 8%; text-align: right;">Quantity</th> 
                      <th style="width: 10%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultData as $row)
                  <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->products->name }}</td>
                      <td>{{ $row->products->categories->name }}</td>
                      <td>{{ $row->products->units->initial }}</td>
                      <td>{{ $row->products->sizes->initial }}</td> 
                      <td style=" text-align: right;">{{ number_format($row->stock,2) }}</td> 
                      <td style=" text-align: center;">
                        <a href="#" onclick="popupImg(`{{$row->products->image}}`)" class="text-info"><i class="fas fa-info-circle"></i> Lihat gambar</a>
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>

</section> 

<div class="modal fade" id="modal-detail" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-2 font-weight-bold">Gambar Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3">
        <div class="row" id="content">
          <img src="" alt="img" id="img_produk" style="width: 300px; height: auto; padding: 5px;">
        </div>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
  function popupImg(img) {
    $('#modal-detail').modal('show')

    $('#img_produk').attr('src', '/storage/'+img)
  }
</script>