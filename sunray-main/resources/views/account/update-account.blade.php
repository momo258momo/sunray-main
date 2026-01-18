@extends('layouts.app')

@section('title', 'Cập nhật tài khoản')

@section('content')

<div class="container mt-5 pb-5">

    <div class="row">
        <div class="col-lg-3">

            @include('partials.sidebar')

        </div>

        <div class="col-lg-9">

            <h4 class="mb-3">Cập nhật tài khoản</h4>

            <form action="{{ route('update.account.store') }}" 
                  method="POST" 
                  class="col-lg-7 rounded p-3 border"
                  onsubmit="return confirm('Bạn có chắc muốn cập nhật thông tin?');">

                @csrf

                <div class="mb-3">
                    <label for="first_name" class="form-label">Tên</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ old('first_name', auth()->user()->first_name) }}">
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Họ</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ old('last_name', auth()->user()->last_name) }}">
                    @error('last_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', auth()->user()->email) }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-2">Cập nhật</button>

            </form>

            {{-- delete account --}}
            <div class="col-lg-7 border-top mt-4 pt-3">
                <p class="text-muted">Bạn muốn xóa toàn bộ thông tin tài khoản?</p>

                <form action="{{ route('update.account.destroy') }}" 
                      method="POST" 
                      onsubmit="return confirm('Xác nhận xóa tài khoản? Hành động này không thể hoàn tác.');">
                      
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Xóa tài khoản</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
