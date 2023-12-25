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
            <div class="card mx-1 elevation-1 p-3 w-100">
                
                <div class="row my-4 mx-3">
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="vendor_code">Nomor Transaksi</label>
                        <input type="text" class="form-control" name="codeTrans" id="codeTrans" placeholder="{{ date('ymd') }}-XX" readonly>
                        <input type="hidden" id="purchase_order_id">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="vendor_code">Vendor</label>
                        <select class="form-control" name="vendor_code" id="vendor_code">
                            <option value="">Pilih Vendor</option>
                            @foreach ($vendor as $val)
                                <option value="{{$val->code}}">
                                    » &nbsp; {{ $val->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                        <br>
                        <button type="button" class="btn btn-add mt-2 pt-1 ml-2" id="addDetail">
                            <i class="fas fa-plus-square"></i> &nbsp; Detail
                        </button>
                    </div>

                    {{-- TABLE PURCHASE ORDER DETAIL --}}
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2" id="detail-list">
                        <button type="button" id="add-new" class="btn btn-primary btn-sm mb-2 float-right"> <i class="fas fa-plus-square"></i> </button>
                        <table class="table" id="container-table">
                            <thead>
                                <tr>
                                    <th style="width:30px">No.</th>
                                    <th>Produk</th>
                                    <th style="text-align: right; width: 150px;">Qty</th>
                                    <th style="text-align: right; width: 200px;">Harga</th>
                                    <th style="text-align: center; width: 60px;">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                {{-- 
                                <button type="button" id="edit" class="btn text-warning p-0"> <i class="fas fa-edit"></i> </button>
                                <button type="button" id="delete" class="btn text-danger p-0"> <i class="fas fa-trash-alt"></i> </button>
                                 --}}
                            </tbody>
                        </table>
                    </div>

                </div>
    
                <hr style="margin: 0 22px 20px;">
                <div class="row justify-content-end mx-3">
                    <section class="col-lg-4">
                        <section style="float: right;">
                            <a href="/purchase-order" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
                            <button type="button" id="saveButton" class="btn my-button-save"><i class="far fa-save"></i> Simpan</button>
                        </section>
                    </section>
                </div>
                
            </div>
        </div>
    </div>

</section> 

@endsection

<div class="modal fade" id="modal-delete" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ml-2 font-weight-bold">Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" id="clickDelete">Ya</button>
        </div> 
      </div>
    </div>
</div>