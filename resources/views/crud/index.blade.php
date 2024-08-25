@extends('master')

@section('content')
    <h2>
        لیست کراد 
        <span class="text-danger">{{ $crudName }}</span>
    </h2><br>

    <a href="{{ route('crud-generator.create') }}" class="btn btn-primary pull-left">ایجاد کراد جدید</a><br>

    <input style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;border: 0;border-radius: 5px; width: 300px;" type="text" name="search" class="form-control" placeholder="جست وجو کنید ...!">
    <br>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                @foreach ($supports as $item)
                    <th style="text-align: center">{{ $item }}</th>
                @endforeach
                <th style="text-align: center">مدیریت</th>
            </tr>
        </thead>
        <tbody style="text-align: center">
            <tr>
                @foreach ($supports as $support)
                    @forelse ($curdData as $item)
                        <th style="text-align: center; vertical-align: middle">{{ $item->$support }}</th>
                    @empty
                        <td colspan="6">
                            <div class="alert alert-warning">چیزی پیدا نشد</div>
                        </td>
                    @endforelse
                @endforeach
                <th style="text-align: center; vertical-align: middle">
                    <a href="" class="btn btn-warning">ویرایش</a>
                    <form action="{{ route("$crudName.destroy", $item->id) }}" style="display: contents" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                    
                </th>
            </tr>
        </tbody>

    </table>
    <br>

@endsection
