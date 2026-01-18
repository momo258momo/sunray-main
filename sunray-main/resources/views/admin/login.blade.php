@extends('layouts.app')

@section('title', 'Đăng nhập Admin')

@section('content')
<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4>Đăng nhập Admin</h4>
            <hr>

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="admin_email" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" id="admin_email" name="email" value="{{ old('email') }}" placeholder="Email admin">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="admin_password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="admin_password" name="password" placeholder="Mật khẩu">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-2">Đăng nhập</button>
            </form>

            <p class="mt-3 text-muted">
                Quay lại <a href="{{ route('login.create') }}">Trang đăng nhập người dùng</a>
            </p>
        </div>
    </div>
</div>
@endsection