@extends('admin.layout')

@section('content')
    <h2>Sửa thông tin Người dùng</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="first_name">Họ:</label>
            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
        </div>

        <div class="form-group">
            <label for="last_name">Tên:</label>
            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật Người dùng</button>
    </form>
@endsection