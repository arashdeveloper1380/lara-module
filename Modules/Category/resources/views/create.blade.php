@extends('master')

@section('content')
    <h2>
        ایجاد دسته بندی
    </h2><br>

    <form action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="name">
                    عنوان دسته بندی
                    @error('name') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <input type="text" name="name" required class="form-control" placeholder="عنوان دسته بندی را وارد کنید">
            </div>

            <div class="form-group">
                <label for="name">
                    وضعیت
                    @error('status') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <select name="status" class="form-control">
                    <option value="1">فعال</option>
                    <option value="2">غیر فعال</option>
                </select>
            </div>

        </div>


        <div class="form-group" style="clear: both">
            <button type="submit" class="btn btn-primary" wire:click="create">ذخیره دسته بندی</button>
        </div>
    </form>
@endsection
