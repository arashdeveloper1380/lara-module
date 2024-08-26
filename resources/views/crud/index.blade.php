@extends('master')

@section('content')
    <h2>
        لیست کراد
        <span class="text-danger">{{ $crudName }}</span>
    </h2><br>

    <a href="{{ route('crud-generator.create') }}" class="btn btn-primary pull-left">ایجاد کراد جدید</a><br>

    <input style="box-shadow: rgba(100, 100, 111, 0.2) 0 7px 29px 0;border: 0;border-radius: 5px; width: 300px;" type="text" name="search" class="form-control" placeholder="جست وجو کنید ...!">
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
            @forelse ($curdData as $item)
                <tr>
                    @foreach ($supports as $support)
                        <th style="text-align: center; vertical-align: middle">{{ $item->$support }}</th>
                    @endforeach
                    <th style="text-align: center; vertical-align: middle">
                        <a href="{{ route("$crudName.edit", $item->id) }}" class="btn btn-warning">ویرایش</a>
                        <form action="{{ route("$crudName.destroy", $item->id) }}" style="display: contents" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </th>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="alert alert-warning">چیزی پیدا نشد</div>
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
    <br>

@endsection
