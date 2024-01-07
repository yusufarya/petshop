
@extends('user-page.layouts.user_main')

@section('header-pages')
<div class="banner">
  <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
      <div class="carousel carousel-inner">
        <div class="carousel-item item active" style="height: 360px;">
            <img src="{{ asset('img/header1.png') }}" class="d-block w-100 px-5 bg-white" alt="header1">
        </div>
        <div class="carousel-item item">
            <img src="{{ asset('img/header2.png') }}" class="d-block w-100" alt="header2">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
  </div>
</div>
@endsection

@section('content-pages')

<h4 class="mt-4 text-center">Kategori Produk</h4>
<div class="service-panel my-3 mx-1 bg-white shadow row justify-content-center" >
  <div class="parent-category-panel mt-3">
    
    @foreach ($category as $item)
        
      <div class="category-panel">
        <a href="/our-products/{{$item->id}}" class="text-decoration-none text-dark-emphasis">
          <div class="box-category">
            <div class="text-center">
              <b class="text-center">{{ $item->name }} </b>
            </div>
          </div>
        </a>
      </div>

    @endforeach

  </div>

</div>

<div class="row">
  <div class="col">
    <h5 class="ms-3">Cara Pemesanan Produk</h5>
    <ul>
      <li >Pergi ke halaman "<b>Produk</b>"</li>
      <li >Pilih produk yg anda inginkan, lalu klik "<b>Beli Sekarang</b>"</li>
      <li> Anda akan di arahkan ke halaman "<b>Detail Pesanan</b>"</li>
      <li> Selanjutnya klik tombol "<b>Pembayaran</b>"</li>
      <li> Kemudian anda akan di arahkan ke halaman "<b>Pembayaran</b>" dan silahkan pilih Metode Pembayaran </li>
      <li> Setelah anda melakukan pembayaran silahkan kirim bukti pembayaran</li>
      <li> Dan selesai Pesanan anda akan segera di proses.</li>
    </ul>
  </div>
</div>

@endsection