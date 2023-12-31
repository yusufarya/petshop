
@extends('user-page.layouts.user_main')

@section('header-pages')
<div class="banner">
  <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel carousel-inner">
          <div class="carousel-item item active">
          <img src="{{ asset('img/header1.png') }}" class="d-block w-100" alt="header1">
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

<div class="row mx-1 mt-5">
  <div class="card p-3">
    <h5 class="ms-3">Layanan Petshop</h5>
    <ol type="1">
      <li> Penitipan Hewan</li>
      <li> Pemeliharaan Hewan Seperti</li>
      <li> Grooming atau pemandian peliharaan</li>
      <ul>
        <li>Mandi Biasa : RP. 40.000</li>
        <li>Mandi Jamur : RP. 65.000 </li>
        <li>Mandi Kutu : RP. 65.000</li>
        <li>Mandi Komplit : RP. 80.000</li>
      </ul>
      <li>Bisa antar jemput hewan peliharaan anda</li>
    </ol>

    <a href="/service-form" class="btn btn-info"> Pesan Sekarang</a>
  </div>
</div> 

@endsection
