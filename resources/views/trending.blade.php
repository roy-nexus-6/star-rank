@extends('layouts.app')

@section('contents')
<h1>
    トレンドランキング -
    @if ($period === 'daily')
    日次
    @elseif ($period === 'weekly')
    週次
    @elseif ($period === 'monthly')
    月次
    @else
    全期間
    @endif
</h1>

<table border="1">
    <thead>
        <tr>
            <th>順位</th>
            <th>名前</th>
            <th>閲覧数</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($celebrities as $celebrityView)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $celebrityView->celebrity->name }}</td>
            <td>{{ $celebrityView->total_views }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $celebrities->links() }}
</div>
@endsection