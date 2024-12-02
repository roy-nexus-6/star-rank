@extends('layouts.app')

@section('content')
    <h1>人気度ランキング</h1>

    <table border="1">
        <thead>
            <tr>
                <th>順位</th>
                <th>名前</th>
                <th>Like数</th>
                <th>Dislike数</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($celebrities as $index => $celebrity)
            <tr>
                <td>{{ $loop->iteration + ($celebrities->currentPage() - 1) * $celebrities->perPage() }}</td>
                <td>{{ $celebrity->name }}</td>
                <td>{{ $celebrity->like_count }}</td>
                <td>{{ $celebrity->dislike_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーション -->
    <div>
        {{ $celebrities->links() }}
    </div>
@endsection