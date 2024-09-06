@extends('master')

@section('content')
    <h2>
        ایجاد فیلد های سفارشی برای کراد
        <span style="color: crimson;">{{ $crud->name }}</span>
    </h2><br>

    @if (session()->has('meta_table_exist'))
        <div class="alert alert-danger">{{ session()->get('meta_table_exist') }}</div>
    @endif

    
    
    <form action="{{ route('crud-generator.add-meta-store', $crud->id) }}" method="post">
        @csrf
        <input type="hidden" name="crud_name" value="{{ $crud->name }}">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="form-group">
                <label for="name">
                    عنوان جدول متا
                    <span style="color: crimson">قابل ادیت</span>
                    @error('name') <span style="color: crimson">{{ $message }}</span> @enderror
                </label>
                <input type="text" name="name" value="@if($getMetaTable) {{ $getMetaTable }} @else {{ $crud->name . "_meta" }} @endif"  class="form-control">
            </div>

        </div>


        @if(!$getMetaTable)
            <div class="form-group" style="clear: both">
                <button type="submit" class="btn btn-primary">ثبت جدول متا</button>
            </div>
        @endif

    </form>
    <div style="clear: both"></div>
    

    @if ($getMetaTable)

    <form action="{{ route('crud-generator.add-meta-filed-store') }}" method="POST">
        @csrf
        <input type="hidden" name="crud_name" value="{{ $crud->name }}">
            <div class="box">
                <br>
                <div style="float: right; padding-left: 10px">
                    <div class="form-group">
                        <button type="button" value="{{ old('add_field[]') }}" id="add-input-btn" class="btn btn-primery">+</button>
                    </div>
                </div>
                <h5 style="padding-top: 5px; padding-right: 10px">تعریف فیلد ها</h5>
                
                <hr>
                <div class="container">
                    <div class="row" id="fields-container">

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <div id="input-container">
                                    <label for="name">عنوان فیلد</label>
                                    <input type="text" name="meta_key[]" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="float: right;">
                            <div class="form-group">

                                <div id="input-container-saheb_phone">
                                    <label for="name">نوع فیلد</label>
                                    <select name="type[]" class="form-control" id="">
                                        <option value="text">text</option>
                                        <option value="select">select</option>
                                        <option value="radio">radio</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="float: right;">
                            <div class="form-group">

                                <div id="input-container-saheb_phone">
                                    <label for="name">type</label>
                                    <select name="return_type[]" class="form-control" id="">
                                        <option value="string">string</option>
                                        <option value="array">array</option>
                                        <option value="bool">bool</option>
                                        <option value="int">int</option>
                                    </select>
                                        
                                </div>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="form-group" style="clear: both">
                <button type="submit" class="btn btn-primary">ثبت فیلد</button>
            </div>
        </form>
    @endif

@endsection

@section('footer')
<script>
    document.getElementById('add-input-btn').addEventListener('click', function() {
        var container = document.getElementById('fields-container');
    
        var newFields = container.cloneNode(true);

        container.parentNode.insertBefore(newFields, container.nextSibling);

    });
    </script>
@endsection