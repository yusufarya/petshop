
@extends('user-page.layouts.user_main')

@section('content-pages')

<hr>
<form action="/update-profile/{{ auth('customer')->user()->code }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="p-3 row rounded-2 shadow mx-2">
        <div class="col-lg-3 col-md-3 col-sm-3 mt-2">
            <label for="image">&nbsp;</label> 
            <div class="card img-bordered ml-5 p-2">
                @if ($auth_user->image)
                    <img id="preview" src="{{ asset('/storage').'/'.$auth_user->image }}" alt="preview" style="height: 240px;"/>
                @else
                    <img id="preview" src="{{ asset('/img/no_preview.jpg') }}" alt="preview" style="height: 240px;"/>
                @endif
            </div>
            <div class=" mt-2">
                <label for="image">Pas Foto</label>

                <input type="file" name="image" id="image" class="form-control @error('image')is-invalid @enderror">
                
                @error('image')
                <small class="invalid-feedback">
                    File {{ $message }}
                </small>
                @enderror
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 mt-4">
            <div class=" mt-2 d-flex">
                <label for="code" class="col-md-3 ms-3">Kode Pelanggan</label>
                <input type="text" class="form-control inline-block border-0" name="code" id="code" value="{{ old('code', $auth_user->code) }}" maxlength="45" disabled>
            </div>
            <div class=" mt-2 d-flex">
                <label for="fullname" class="col-md-3 ms-3">Nama Lengkap</label>
                <input type="text" class="form-control inline-block @error('fullname')is-invalid @enderror" name="fullname" id="fullname" value="{{ old('fullname', $auth_user->fullname) }}" maxlength="45">
                @error('fullname')
                <small class="invalid-feedback">
                    No. Telp {{ $message }}
                </small>
                @enderror
            </div>
            <div class=" mt-2 d-flex">
                <label for="phone" class="col-md-3 ms-3">No. Telp </label>
                <input type="text" class="form-control inline-block @error('phone')is-invalid @enderror" name="phone" id="phone" value="{{ old('phone', $auth_user->phone) }}" onkeyup="onlyNumbers(this)" maxlength="15">
                @error('phone')
                <small class="invalid-feedback">
                    No. Telp {{ $message }}
                </small>
                @enderror
            </div>
            <div class=" mt-2 d-flex">
                <label for="place_of_birth" class="col-md-3 ms-3">Tempat Lahir </label>
                <input type="text" class="form-control inline-block @error('place_of_birth')is-invalid @enderror" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $auth_user->place_of_birth) }}">
                @error('place_of_birth')
                <small class="invalid-feedback">
                    &nbsp; Tempat lahir {{ $message }}
                </small>
                @enderror
            </div>
            <div class=" mt-2 d-flex">
                <label for="date_of_birth" class="col-md-3 ms-3">Tanggal Lahir </label>
                <input type="date" class="form-control inline-block @error('date_of_birth')is-invalid @enderror" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $auth_user->date_of_birth) }}">
                @error('date_of_birth')
                <small class="invalid-feedback">
                    &nbsp; Tanggal lahir {{ $message }}
                </small>
                @enderror
            </div>
            <div class=" mt-2 d-flex">
                <label for="city" class="col-md-3 ms-3">Kota </label>
                <input type="text" class="form-control inline-block @error('city')is-invalid @enderror" name="city" id="city" value="{{ old('city', $auth_user->city) }}">
                @error('city')
                <small class="invalid-feedback">
                    &nbsp; Kota {{ $message }}
                </small>
                @enderror
            </div>
            <div class=" mt-2 d-flex">
                <label for="address" class="col-md-3 ms-3">Alamat </label>
                <input type="text" class="form-control inline-block @error('address')is-invalid @enderror" name="address" id="address" value="{{ old('address', $auth_user->address) }}">
                @error('address')
                <small class="invalid-feedback">
                    &nbsp; Alamat {{ $message }}
                </small>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success mt-3">Simpan Data</button>
    </div>
</form>

@endsection
