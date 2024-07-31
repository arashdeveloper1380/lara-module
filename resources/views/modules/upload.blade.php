@extends('master')

@section('content')

    <h2>upload Modules</h2>
    <br><br>
    <form action="{{ route('module.store.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="module" value="module file">

        <input type="submit" value="upload">
    </form>

@endsection
