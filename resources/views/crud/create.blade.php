@extends('master')

@section('content')
    <h2>
        ایجاد دسته بندی
    </h2><br>

    <form action="{{ route('crud.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                    عنوان کراد
                    @error('name') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <input type="text" name="name" class="form-control" placeholder="عنوان کراد را وارد کنید">
            </div>

        </div>

        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary">ذخیره کراد</button>
        </div>

    </form>
@endsection
