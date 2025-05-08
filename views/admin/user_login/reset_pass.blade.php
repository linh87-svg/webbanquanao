@extends('admin_layout')
@section('admin_content')
<div class="main-content">
    <div class="container">
        <h3 style="margin-top: 20px;margin-bottom: 20px;">Đổi mật khẩu</h3>

        @if(session('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        <form action="{{ url('/reset-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_password">Mật khẩu hiện tại:</label>
                <input style="width: 30%;" type="password" name="current_password" class="form-control">
                @error('current_password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">Mật khẩu mới:</label>
                <input style="width: 30%;" type="password" name="new_password" class="form-control">
                @error('new_password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Xác nhận mật khẩu mới:</label>
                <input style="width: 30%;" type="password" name="new_password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
        </form>
    </div>
</div>
@endsection