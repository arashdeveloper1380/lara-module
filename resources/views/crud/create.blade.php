@extends('master')

@section('content')
    <h2>
        ایجاد کراد
        <span class="text-danger">{{ $crudName}}</span>
    </h2><br>

    <form action="{{ route("{$crudName}.store") }}" method="post">
        @csrf

        @if(in_array('title', $supports))
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <div class="form-group">
                    <label for="name">
                        عنوان
                        @error('title') <span style="color: crimson">{{ $message }}</span> @enderror
                    </label>
                    <input type="text" name="title" class="form-control" placeholder="عنوان را وارد کنید">
                </div>

            </div>
        @endif

        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
    </form>

@endsection
