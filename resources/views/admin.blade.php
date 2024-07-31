@extends('master')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
@endsection

@section('content')

    <h2>داشبورد</h2>
    <br><br>

    <p>لیست ماژول ها :</p>



    <div class="col-md-6">

        @if(Module::find('Category'))
            <div class="container">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="card text-center col-md-4 mt-3 col-sm-10 p-0">
                        <form action="{{ route('module.export', 'Category') }}" method="post" class="m-t-2">
                            @csrf
                            <input class="btn btn-outline-primary" type="submit" name="category" value="خروجی گرفتن از ماژول category">
                        </form>
                        <div class="card-header p-0">
                            <img
                                src="https://i.pinimg.com/originals/fc/68/f8/fc68f86873c9c661e84ad442cf8fb6cf.gif"
                                alt="" class="w-100">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">ماژول دسته بندی</h5>
                            <p class="card-text">در ماژول دسته بندی شما میتوانید انواع دسته بندی ایجاد و مدیریت کنید</p>

                        </div>
                        <div class="card-footer text-muted">
                            @if(App\Http\Controllers\DashboardController::isEnableModules('category'))
                                <form method="post" action="{{ route('module.disable', 'Category') }}" style="float: right">
                                    @csrf
                                    <button class="btn btn-warning">غیر فعال</button>
                                </form>
                            @else
                                @if(App\Http\Controllers\DashboardController::existTableModule('category'))
                                    <form method="post" action="{{ route('module.enable', 'Category') }}" style="float: right">
                                        @csrf
                                        <button class="btn btn-success">فعال</button>
                                    </form>
                                @endif
                            @endif

                            @if(App\Http\Controllers\DashboardController::existTableModule('category'))
                                <form method="post" action="{{ route('module.uninstall', 'Category') }}" style="float: left">
                                    @csrf
                                    <button class="btn btn-warning">حذف نصب</button>
                                </form>
                            @else
                                <form method="post" action="{{ route('module.install', 'Category') }}">
                                    @csrf
                                    <button class="btn btn-success">نصب ماژول دسته بندی</button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        @endif

    </div>


@endsection
