<?php 
if(auth('customer')->user()) {
  $getCountCart = DB::table('shopping_carts')
                      ->where(['customer_code' => auth('customer')->user()->code, 'updated_at' => NULL])
                      ->count();
}
?>

<nav class="navbar navbar-expand-lg sticky-top" id="navigasi">
    <div class="container-fluid mx-0">
      <a class="navbar-brand" href="/"><b>SI - PETSHOP</b></a>
      <div class="d-flex">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item mx-2">
              <a class="nav-link {{ Request::segment(1) == '' ? 'active-link' : '' }}" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link {{ Request::segment(1) == 'our-products' ? 'active-link' : '' }}" aria-current="page" href="/our-products">Produk</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link {{ Request::segment(1) == 'our-services' ? 'active-link' : '' }}" href="/our-services">Layanan</a>
            </li>
            
            {{-- <li class="nav-item mx-2 dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Kategori Produk
              </a>
              <ul class="dropdown-menu">
                @foreach ($category as $item)
                  <li><a class="dropdown-item" href="/category_/{{$item->id}}">» {{$item->name}}</a></li>
                @endforeach
              </ul>
            </li> --}}
            @if (auth('customer')->user())
              <li class="nav-item mx-2">
                <a href="/my-orders" class="btn {{ Request::segment(1) == 'my-orders' ? 'btn-success' : 'btn-outline-success' }} register py-1 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Pesanan Saya">
                  <i class="fas fa-shopping-cart"></i> Pesanan Saya
                </a>
              </li>
              {{-- <li class="nav-item mx-2">
                <a href="/my-req-orders" class="btn {{ Request::segment(1) == 'my-req-orders' ? 'btn-success' : 'btn-outline-success' }} register py-1 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Pesanan Saya">
                  
                  Permintaan Saya
                </a>
              </li> --}}
              <li class="nav-item mx-2">
                <a href="/shopping-cart" class="btn {{ Request::segment(1) == 'shopping-cart' ? 'btn-primary' : 'btn-outline-primary' }} register py-1 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Keranjang Saya">
                  <i class="fas fa-shopping-cart"></i> 
                  <sup><span class="badge bg-danger">{{ $getCountCart }}</span></sup>
                </a>
              </li>
              <li class="nav-item mx-2">
                <a href="/_profile" class="btn btn-outline-danger register py-1 mt-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Profile">
                 Hi, {{ auth('customer')->user()->fullname }}
                </a>
              </li>
              <li class="nav-item mx-2">
                <button type="button" class="btn btn-danger" id="logout" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Logout">
                  <i class="fas fa-sign-out-alt"></i><span class="text-danger">'</span>
                </button>
              </li>
            @else
              <div class="mt-1">&nbsp; &nbsp; </div>
              <li class="nav-item mx-2">
                <a href="/login" class="btn primary-color button-login py-1 mt-1">Masuk</a>
              </li>
              <li class="nav-item mx-2">
                <a href="/register" class="btn bg-primary-color text-white button-register py-1 mt-1">Daftar</a>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </nav>


  <div class="modal fade" id="logout-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Logout</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin keluar dari sistem ?</p>
        </div>
        <form action="/logout" method="post">
          @csrf
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn text-white bg-primary-color">Ya</button>
          </div>
        </form>
      </div>
    </div>
  </div>