@extends('master')

@section('content')
    <h2>
        لیست کراد ها
    </h2><br>

    <a href="{{ route('crud-generator.create') }}" class="btn btn-primary pull-left">ایجاد کراد جدید</a><br>

    <input style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;border: 0;border-radius: 5px; width: 300px;" type="text" name="search" class="form-control" placeholder="جست وجو کنید ...!">
    <br>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th style="text-align: center">#</th>
                <th style="text-align: center">نام کراد</th>
                <th style="text-align: center">slug</th>
                <th style="text-align: center">قابل توسعه</th>
                <th style="text-align: center">پشتیبانی</th>
                <th style="text-align: center">وضعیت</th>
                <th style="text-align: center">مدیریت</th>
            </tr>
        </thead>
        <tbody style="text-align: center">
            @forelse($cruds as $index => $value)
                <tr>
                    <th style="text-align: center; vertical-align: middle">{{ $index + 1 }}</th>
                    <td style="text-align: center; width: 10%; vertical-align: middle">{{ $value->name }}</td>
                    <td style="text-align: center; width: 20%; vertical-align: middle">{{ $value->slug }}</td>
                    <td style="text-align: center; width: 10%; vertical-align: middle">{{ $value->developer_mode == 0 ? 'خیر' : 'بله'  }}</td>
                    <td style="text-align: center; width: 20%; vertical-align: middle">
                        <ol>
                            @foreach($value->support as $support)
                                <li>{{ $support }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td style="text-align: center; width: 10%; vertical-align: middle">{{ $value->status == 0 ? 'غیر فعال' : 'فعال' }}</td>
                    <td style="text-align: center; vertical-align: middle">
                        <a href="{{ route('crud-generator.edit', $value->id) }}" class="btn btn-info">فیلد های سفارشی</a>
                        <form action="{{ route('crud-generator.destroy', $value->id) }}" style="display: contents" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>

            @empty
                <td colspan="6">
                    <div class="alert alert-warning">چیزی پیدا نشد</div>
                </td>
            @endforelse
        </tbody>

    </table>
    <br>

@endsection
