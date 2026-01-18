@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h4>Đăng nhập</h4>
            <hr>

            <form action="{{ route('login.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-2">Đăng nhập</button>
            </form>

            <p class="mt-3 text-muted">
                Chưa có tài khoản? <a href="{{ route('register.create') }}">Đăng ký</a>
            </p>
        
        </div>
    </div>
</div>

@endsection
