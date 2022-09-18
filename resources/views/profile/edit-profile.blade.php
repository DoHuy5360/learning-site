@extends('layouts.header-footer-create')
@section('title', 'Chỉnh sửa hồ sơ')
@section('content')
    <form action="{{ route('profile.update', $profile_id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <input type="file" name="avatar" id="">
        <button type="submit">Cập nhật</button>
    </form>
@endsection