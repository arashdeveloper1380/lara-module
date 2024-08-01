@extends('master')

@section('content')
    <h2>
        Category
    </h2><br>

    <a href="{{ route('category.create') }}" class="btn btn-success">ایجاد دسته بندی</a>
@endsection
