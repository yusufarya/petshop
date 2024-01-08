@extends('admin-page.layouts.main_layout')

@section('content-pages')


<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 ml-2"> {{ $title }}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard </li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$newOrder}}</h3>

            <p>Pesanan</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="/orders" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$salesOrder}}</h3>

            <p>Sales Order</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="/sales-order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $serviceOrder }}</h3>

            <p>Order Pelayanan</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="/service-order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      {{-- <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>

            <p>Unique Visitors</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col --> --}}
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">   
      <section class="col-lg-12 connectedSortable">

        <!-- PRODUCT LIST -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Recently Sales Products</h3>

            {{-- <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div> --}}
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0 px-3">
            @foreach ($salesOrderData as $item)
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item">
                  <div class="product-img">
                    <img src="{{ asset('/storage').'/'.$item->products->image }}" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{ $item->products->name }}
                      <span class="badge badge-warning float-right">{{ number_format($item->price,2) }}</span></a>
                    <span class="product-description">
                      <?= $item->products->categories->name .' / &nbsp; Ukuran : '. $item->products->sizes->initial .' / &nbsp; Quantity : '. $item->qty ?>
                    </span>
                  </div>
                </li>
              </ul>
            @endforeach
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            {{-- <a href="javascript:void(0)" class="uppercase">View All Products</a> --}}
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection