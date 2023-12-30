
@extends('user-page.layouts.user_main')

@section('content-pages')

<?php 
// dd(session());
?>

<div class="explain-product my-5 rounded">

  <div class="row my-3 p-3">
    @if (session()->has('message'))
        <div class="alert alert-danger py-1 text-center">
            <a href="/update-profile" class="text-decoration-none text-dark font-weight-bolder"> {{ session()->get('message') }}</a>
        </div>
    @endif
    <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
    
        <div class="card shadow-sm p-2" style="width: 100%;">
            @if ($service->image)
                <img src="{{ asset('/storage').'/'.$service->image }}" class="card-img-top" alt="{{$service->id}}">
            @else
                <img src="{{ asset('/img/logo.png') }}" class="card-img-top p-3" alt="{{$service->id}}">
            @endif
        </div>

    </div>

    <div class="col mx-3">
        <h4 style="font-size: 28px; font-weight: 700; text-transform: uppercase;"> {{ $service->name }} </h4>
        <div class="mb-2">
            <small class="alert alert-warning py-0">{{ $service->categories->name }}</small>
        </div>
        <p>
            <small class="card-text"> 
                <i class="fas fa-hourglass-end me-2"></i>
                Durasi
                {{ $service->duration }} {{ $service->type }}
            </small><br>
            <small class="card-text"> 
                <i class="fas fa-comment-dollar me-2"></i>
                Harga
                {{ number_format($service->price) }}
            </small>
        </p>
        <p class="text-black " style="font-size: 16.5px; line-height: 1.6; text-align: justify"><?= $service->description ?></p>
        <a href="/checkDataUserService/{{$service->id}}" class="btn bg-secondary-color text-dark"><i class="fab fa-get-pocket"></i> Pesan Sekarang</a>

    </div>
    <hr class="mx-3 mt-3">

  </div>

  <div class="row">
    
  </div>

</div>

@endsection