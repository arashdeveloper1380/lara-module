@extends('master')

@section('content')
    <h2>
        ایجاد فیلد های سفارشی برای کراد
        <span style="color: crimson;">{{ $crud->name }}</span>
    </h2><br>

    <form action="{{ route('crud-generator.update', $crud->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                    عنوان جدول متا
                    <span style="color: crimson">قابل ادیت</span>
                    @error('name') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <input type="text" name="name" value="{{ $crud->name . "_meta" }}" class="form-control">
            </div>

        </div>


        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary">ثبت جدول متا</button>
        </div>

    </form>
@endsection
