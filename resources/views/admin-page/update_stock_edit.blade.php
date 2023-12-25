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
            <div class="card mx-3 elevation-1 p-3 w-75">
                <form action="/update-stock/{{ $resultData->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row my-4 mx-3">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <label for="product_id">Produk</label> 
                            <select class="form-control @error('product_id')is-invalid @enderror" name="product_id" id="product_id">
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $val)
                                    <option value="{{$val->id}}" {{ $val->id == $resultData->product_id ? 'selected' : '' }} >
                                        » &nbsp; {{ $val->name . ' / ' . $val->categories->name . ' / ' . $val->sizes->initial }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <small class="invalid-feedback">
                                Produk {{ $message }}
                            </small>
                            @enderror
                        </div>
                        
                        <div class="col-lg-5 col-md-5 col-sm-5 mt-2">
                            <label for="qty">Quantity</label>
                            <input type="text" name="qty" id="qty" class="form-control" style="text-align: right;" placeholder="0" onkeyup="onlyNumbers(this)" maxlength="4" value="{{ number_format($resultData->qty) }}">
                            @error('qty')
                            <small class="invalid-feedback">
                                Quantity {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-7 mt-2">
                            <label for="price">Harga</label>
                            <input type="text" name="price" id="price" class="form-control" style="text-align: right;" placeholder="0" onkeyup="formatRupiah(this, this.value)" value="{{ number_format($resultData->price) }}">
                            @error('price')
                            <small class="invalid-feedback">
                                Harga {{ $message }}
                            </small>
                            @enderror
                        </div>

                    </div>
        
                    <hr style="margin: 0 22px 20px;">
                    <div class="row justify-content-end mx-3">
                        <section class="col-lg-4">
                            <section style="float: right;">
                                <a href="/update-stock" class="btn btn-outline-secondary mr-2"><i class="fas fa-backspace"></i> Batal</a>
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