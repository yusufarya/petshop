
@extends('user-page.layouts.user_main')

@section('content-pages')

<?php 
// dd(session());
?>

<div class="explain-product my-5 rounded">

  <div class="row my-3 p-3">
    @if (session()->has('message'))
        <div class="alert alert-danger py-1 text-center">
            {{-- <a href="/update-profile" class="text-decoration-none text-dark font-weight-bolder"> {{ session()->get('message') }}</a> --}}
            <a href="/update-profile" class="text-decoration-none text-dark font-weight-bolder"> <?php echo session()->get('message') ?></a>
        </div>
    @endif
    <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
    
        <div class="card shadow-sm p-2" style="width: 100%;">
            @if ($product->image)
                <img src="{{ asset('/storage').'/'.$product->image }}" class="card-img-top" alt="{{$product->id}}">
            @else
                <img src="{{ asset('/img/logo.png') }}" class="card-img-top p-3" alt="{{$product->id}}">
            @endif
        </div>

    </div>

    <div class="col mx-3">
        <h4 style="font-size: 28px; font-weight: 700; text-transform: uppercase;"> {{ $product->name }} </h4>
        <div class="mb-2">
            <small class="alert alert-warning py-0">{{ $product->categories->name }}</small>
            <small class="alert alert-info py-0">Stok :{{ $product->inventory ? $product->inventory->stock : 0 }}</small>
        </div>
        <p>
            <small class="card-text"> 
                Ukuran : {{ $product->sizes->initial }}
            </small><br>
            <br>
            <small class="card-text"> 
                Harga : {{ number_format($product->selling_price,2) }}
            </small>
        </p>
        <p class="text-black " style="font-size: 16.5px; line-height: 1.6; text-align: justify"><?= $product->description ?></p>
        
        <button type="button" onclick="popUpAddCart()" class="btn bg-warning text-white shadow"><i class="fas fa-cart-plus"></i> Keranjang</button> 
        <a href="/checkDataUser/{{$product->id}}" class="btn bg-danger text-white shadow"><i class="fas fa-dollar-sign"></i> Beli Sekarang</a>
        <br> <br> <br>
        <div class="row mt-3">
            <div class="col">
                <a href="/our-products" style="float: right" class="btn btn-sm btn-secondary">Kembali</a>
            </div>

        </div>
    </div>
    <hr class="mx-3 mt-3">

  </div>

  <div class="row">
    
  </div>

</div>


<div class="modal fade" id="modal-add-cart" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Tambah Ke Keranjang</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/add-to-cart/{{$product->id}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="qty">Quantity</label>
                    </div>
                    <div class="col">
                        <button style="display: inline" type="button" class="btn bg-primary-color text-white" id="min">-</button>
                        <input type="text" name="qty" id="qty" class="form-control" onkeyup="onlyNumbers(this)" style="width: 62%; display: inline;" value="1">
                        <button style="display: inline" type="button" class="btn bg-primary-color text-white" id="plus">+</button>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ke keranjang" >
                    Tambah
                </button>
            </div>
        </form> 
      </div>
    </div>
</div>

@endsection