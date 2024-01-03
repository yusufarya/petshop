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
            <div class="card mx-3 elevation-1 p-3">
                <form action="/products" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row my-4 mx-3">
                        <div class="col-lg-6 col-md-6 col-sm-12" >
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                    <label for="category_id">Kategori</label>
                                    <select class="form-control @error('category_id')is-invalid @enderror" name="category_id" id="category_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $val)
                                            <option value="{{$val->id}}" {{ old('category_id') == $val->id ? 'selected' : '' }} >
                                                » &nbsp;  {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <small class="invalid-feedback">
                                        Kategori {{ $message }}
                                    </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-4 col-md-4 col-sm-4 mt-2">
                                    <label for="unit_id">Satuan</label>
                                    <select class="form-control @error('unit_id')is-invalid @enderror" name="unit_id" id="unit_id">
                                        <option value="">Pilih Satuan</option>
                                        @foreach ($units as $val)
                                            <option value="{{$val->id}}" {{ old('unit_id') == $val->id ? 'selected' : '' }} >
                                                » &nbsp;  {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                    <small class="invalid-feedback">
                                        Satuan {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-2 col-md-2 col-sm-2 mt-2">
                                    <div class="form-check mt-1">
                                        <label for="is_active">Aktif ?</label>
                                        <input class="form-check-input mt-5" type="checkbox" checked value="Y" name="is_active" id="is_active" style="width: 1.3rem; height: 1.3rem; top:-1rem; left: 2.5rem;">
                                        <div class="form-check-label" style="margin-left: 30px">Ya</div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <label for="name">Nama Produk</label>
                                    <input type="text" autocomplete="off" class="form-control @error('name')is-invalid @enderror" name="name" id="name" maxlength="50" placeholder="Nama Produk" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback">
                                            Nama Produk {{ $message }}
                                        </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <label for="size_id">Ukuran</label>
                                    <select class="form-control @error('size_id')is-invalid @enderror" name="size_id" id="size_id">
                                        <option value="">Pilih Ukuran</option>
                                        @foreach ($sizes as $val)
                                            <option value="{{$val->id}}" {{ old('size_id') == $val->id ? 'selected' : '' }} >
                                                » &nbsp;  {{ $val->initial . ' - '. $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('size_id')
                                    <small class="invalid-feedback">
                                        Ukuran {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <label for="purchase_price">Standar Beli</label>
                                    <input type="text" class="form-control @error('purchase_price')is-invalid @enderror" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" onkeyup="formatRupiah(this, this.value);" style="text-align: right;">
                                    @error('purchase_price')
                                    <small class="invalid-feedback">
                                        Standar Beli {{ $message }}
                                    </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <label for="selling_price">Standar Jual</label>
                                    <input type="text" class="form-control @error('selling_price')is-invalid @enderror" name="selling_price" id="selling_price" value="{{ old('selling_price') }}" onkeyup="formatRupiah(this, this.value);" style="text-align: right;">
                                    @error('selling_price')
                                    <small class="invalid-feedback">
                                        Standar Jual {{ $message }}
                                    </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <label for="description">Keterangan Produk</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>
        
                            </div>
                        </div>

                        <div class="bg-transparent col" style="max-width: 5%"></div>
                        <div class="col" >
                            <div class="elevation-1">
                                <img src="{{ asset('img/default.png')}}" id="blah" class="img-fluid" alt="img-product" style="height: 400px; margin-left: 25px; padding: 10px;">
                                <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px; margin-top: -10px;">
                                    <input type="file" class="form-control border-0" name="image" id="img_product">
                                </div>
                            </div>
                            <div class="row"></div>
                        </div>
                    </div>
        
                    <hr style="margin: 0 22px 20px;">
                    <div class="row justify-content-end mx-3">
                        <section class="col-lg-4">
                            <section style="float: right;">
                                <a href="/products" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
                                <button type="submit" class="btn my-button-save"><i class="far fa-save"></i> Simpan</button>
                            </section>
                        </section>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</section> 

@endsection