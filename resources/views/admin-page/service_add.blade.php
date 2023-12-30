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
                <form action="/services" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row my-4 mx-3">
                        <div class="col-lg-6 col-md-6 col-sm-12" >
                            <div class="row">
        
                                <div class="col-lg-5 col-md-5 col-sm-5 mt-2">
                                    <label for="duration">Durasi</label>
                                    <input type="text" class="form-control @error('duration')is-invalid @enderror" name="duration" id="duration" value="0" onkeyup="onlyNumbers(this)">
                                    @error('duration')
                                    <small class="invalid-feedback">
                                        Durasi {{ $message }}
                                    </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-5 col-md-5 col-sm-5 mt-2">
                                    <label for="type">Jenis Waktu</label>
                                    <select class="form-control @error('type')is-invalid @enderror" name="type" id="type">
                                        <option value="">Pilih</option>
                                        <option value="Jam">Per Jam</option>
                                        <option value="Hari">Per Hari</option>
                                    </select>
                                    @error('type')
                                    <small class="invalid-feedback">
                                        Jenis {{ $message }}
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
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <label for="name">Nema Layanan</label>
                                    <input type="text" autocomplete="off" class="form-control @error('name')is-invalid @enderror" name="name" id="name" maxlength="50" placeholder="Nama Layanan" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback">
                                            Nama Layanan {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                    <label for="stock">Stok</label>
                                    <input type="text" class="form-control @error('stock')is-invalid @enderror" name="stock" id="stock" value="{{ old('stock') }}" onkeyup="onlyNumbers(this);" style="text-align: right;">
                                    @error('stock')
                                    <small class="invalid-feedback">
                                        Stok {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                    <label for="price">Harga</label>
                                    <input type="text" class="form-control @error('price')is-invalid @enderror" name="price" id="price" value="{{ old('price') }}" onkeyup="formatRupiah(this, this.value);" style="text-align: right;">
                                    @error('price')
                                    <small class="invalid-feedback">
                                        Harga {{ $message }}
                                    </small>
                                    @enderror
                                </div>
        
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <label for="description">Keterangan Layanan</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>
        
                            </div>
                        </div>

                        <div class="bg-transparent col" style="max-width: 5%"></div>
                        <div class="col" >
                            <div class="elevation-1">
                                <img src="{{ asset('img/default.png')}}" id="blah" class="img-fluid" alt="img-product" style="height: 400px; margin-left: 25px; padding: 10px;">
                                <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px; margin-top: -10px;">
                                    <input type="file" class="form-control border-0" name="image" id="img_service">
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