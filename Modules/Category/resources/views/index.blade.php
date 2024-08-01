@extends('master')

@section('content')
    <h2>
        Category
        <span class="text-info">{{ $isEnable ? 'فعال' : 'غیر فعال' }}</span>
    </h2><br>

    <a href="{{ route('category.create') }}" class="btn btn-success">ایجاد دسته بندی</a>
@endsection
