@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-4">検索結果</h1>

    <p class="text-center text-gray-700 mb-8">検索キーワード: <span class="font-semibold">{{ $query }}</span></p>

    @if($celebrities->isEmpty())
    <p class="text-center text-gray-500">該当するセレブリティが見つかりませんでした。</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($celebrities as $celebrity)
        <div class="bg-white p-4 border rounded shadow">
            <h2 class="text-xl font-bold mb-2">{{ $celebrity->name }}</h2>
            @if($celebrity->tags->isNotEmpty())
            <p class="text-gray-500 mb-2">
                タグ:
                @foreach ($celebrity->tags as $tag)
                <span class="text-indigo-500">{{ $tag->name }}</span>{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>
            @endif
            <a href="{{ route('celebrity.show', $celebrity->id) }}" class="text-indigo-500 hover:underline">詳細を見る</a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection