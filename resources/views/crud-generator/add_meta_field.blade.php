@extends('master')

@section('content')
    <h2>
        ایجاد فیلد های سفارشی برای کراد
        <span style="color: crimson;">{{ $crud->name }}</span>
    </h2><br>

    <form action="{{ route('crud-generator.update') }}" method="post">
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

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                     توضیحات
                </label>
                <input type="text" name="desc" class="form-control" placeholder="توضیحات کراد را وارد کنید">
            </div>

        </div>



        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <p>پشتیبانی</p>

            <div class="form-group col-lg-1">
                <label for="">title</label>
                <input type="checkbox" name="support[]" class="form-control" value="title">
            </div>

            <div class="form-group col-lg-2">
                <label for="">description</label>
                <input type="checkbox" name="support[]" class="form-control" value="desc">
            </div>

            <div class="form-group col-lg-2">
                <label for="">thumbnail</label>
                <input type="checkbox" name="support[]" class="form-control" value="thumbnail">
            </div>

            <div class="form-group col-lg-2">
                <label for="">excerpt</label>
                <input type="checkbox" name="support[]" class="form-control" value="excerpt">
            </div>

            <div class="form-group col-lg-2">
                <label for="">slider</label>
                <input type="checkbox" name="support[]" class="form-control" value="slider">
            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                     وضعیت
                    @error('name') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <select name="status" class="form-control">
                    <option value="1">فعال</option>
                    <option value="0">غیر فعال</option>
                </select>
            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                     قابل develope یا نه
                </label>
                <select name="develop_mode" class="form-control">
                    <option value="1">فعال</option>
                    <option value="0">غیر فعای</option>
                </select>
            </div>

        </div>


        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary">ذخیره کراد</button>
        </div>

    </form>
@endsection
