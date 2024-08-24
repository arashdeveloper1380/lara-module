@extends('master')

@section('content')
    <h2>
        ایجاد کراد
        <span class="text-danger">{{ $crudName }}</span>
    </h2><br>

    <form action="{{ route("{$crudName}.store") }}" method="post">
        @csrf
        <input type="hidden" name="crud_name" value="{{ $crudName }}">
        @if(in_array('title', $supports))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="name">
                            عنوان
                            @error('title') <span style="color: crimson">{{ $message }}</span> @enderror
                        </label>
                        <input type="text" name="title" class="form-control" placeholder="عنوان را وارد کنید">
                    </div>

                </div>
            </div>
        @endif

        @if(in_array('desc', $supports))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div class="form-group">
                        <label for="name">
                            توضصیحات
                            @error('desc') <span style="color: crimson">{{ $message }}</span> @enderror
                        </label>
                        <textarea name="desc" id=""  class="form-control" cols="30" rows="10"    placeholder="توضیحات را وارد کنید"></textarea>
                    </div>

                </div>
            </div>
        @endif

        @if(in_array('thumbnail', $supports))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div class="form-group">
                        <label for="name">
                            عکس شاخص
                            @error('thumbnail') <span style="color: crimson">{{ $message }}</span> @enderror
                        </label>
                        <input type="file" name="thumbnail" class="form-control" value="اپلود تصویر">
                    </div>

                </div>
            </div>
        @endif

        @if(in_array('excerpt', $supports))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div class="form-group">
                        <label for="name">
                            توضصیحات مختصر
                            @error('excerpt') <span style="color: crimson">{{ $message }}</span> @enderror
                        </label>
                        <textarea name="excerpt" id=""  class="form-control" cols="30" rows="5"    placeholder="توضیحات را وارد کنید"></textarea>
                    </div>

                </div>
            </div>
        @endif

        @if(in_array('slider', $supports))
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div class="form-group">
                        <label for="slider">
                            عکس شاخص
                            @error('slider') <span style="color: crimson">{{ $message }}</span> @enderror
                        </label>
                        <input type="file" name="slider" class="form-control" value="اپلود slider" multiple>
                    </div>

                </div>
            </div>
        @endif

        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
    </form>

@endsection
