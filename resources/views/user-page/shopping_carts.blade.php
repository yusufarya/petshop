
@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4">
    <div class="heading text-center ">
        <div class="pt-3">
        <h3 style="font-size: 26px; font-weight: 600"> {{$title}} </h3>
        </div>
    </div>

    <div class="row mt-3 mx-auto w-75 shadow">
      @if (count($shopping_carts))
        <div class="mt-3 p-3 card shadow-lg">
          <div class="row">
            {{-- <div class="col-lg-1">
              <div class="input-group mb-3">
                <div class="input-group-text">
                  <input class="form-check-input mt-0" type="checkbox" value="All" id="selectAll">
                  &nbsp; Pilih Semua
                </div>
              </div>
            </div> --}}
            <div class="col">
              <h5 class="font-weight-bolder pt-1" style="float: right;"> Total Harga</h5>
            </div>
            <div class="col-md-2">
              <input type="text" name="vtotal_price" id="vtotal_price" class="form-control d-inline w-100" style="text-align: right;" value="0">
              <input type="hidden" name="total_price" id="total_price" class="form-control d-inline w-100" style="text-align: right;" value="0">
            </div>
            <div class="col-md-2">
              <button type="button" class="btn bg-primary-color text-white" id="checkout" style="float: right;"> Checkout </button>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn bg-danger text-white" id="delete" style="float: right;"> Hapus </button>
            </div>
          </div>
        </div>
        <input type="hidden" name="id_cart" id="id_cart" value="">
        @foreach ($shopping_carts as $item)
            <div class="mt-3 p-3 card shadow-lg">
                <div class="row">
                    <div class="col-lg-1">
                      <div class="input-group mb-3">
                        <div class="shadow rounded p-2">
                          <input class="form-check-input mt-0" type="checkbox" value="{{ $item->id }}" id="items" onclick="selectItem(`{{ $item->id }}`, `{{ $item->products->selling_price*$item->qty }}`)" style="height: 20px; width: 20px;">
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                        <h5>{{$item->products->name}}</h5>
                        <span class="alert alert-info py-0"> {{$item->products->categories->name}}</span>
                        <span class="alert alert-info py-0"> {{$item->products->sizes->initial}}</span>
                        <p class="mt-2">Qty &nbsp; : {{$item->qty}}</p>
                        <p class="mt-2">Harga &nbsp; : {{ number_format($item->products->selling_price,2) }}</p>
                        <p class="mt-2">Jumlah &nbsp; : {{ number_format($item->products->selling_price*$item->qty,2) }} <sub>X{{$item->qty}}</sub></p>
                        <br>
                    </div>
                    <div class="col-lg-3">
                        <img src="{{asset('/storage/'.$item->products->image)}}" style="width: 75%" alt="serviceImg">
                    </div>
                </div>
            </div>
        @endforeach
      @else
        <br><br><br>
        <hr>
        <div class="row text-center" >
          <span class="alert alert-info text-danger pt-4 ms-2" style="height: 80px;">Keranjang belanja masih kosong.</span>
        </div>
        <br><br><br><br><br><br><br><br>
      @endif
    </div>

</div>

@endsection

<div class="modal fade" id="printCard" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Kartu Pembelian</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Kartu Pembelian" >
          <i class="fas fa-print me-1"></i> Cetak
      </button>
      </div>
    </div>
  </div>
</div>

  
<div class="modal fade" id="deleteCart" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b><i class="fas fa-exclamation-triangle text-warning"></i>&nbsp; Hapus Item</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus item ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary" id="ya">Ya</button>
      </div>
    </div>
  </div>
</div>