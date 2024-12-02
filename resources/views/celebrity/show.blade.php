@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-4">{{ $celebrity->name }}のことが、好きですか？嫌いですか？</h1>

    <div class="flex justify-center mb-8">
        @foreach ($images as $image)
        <div class="w-1/4 px-2">
            <img src="{{ $image->url }}" alt="{{ $celebrity->name }}" class="rounded shadow">
        </div>
        @endforeach
    </div>

    <div class="text-center mb-8">
        <form action="{{ route('celebrity.vote', $celebrity->id) }}" method="POST">
            @csrf
            <button name="type" value="like" class="bg-green-500 text-white px-4 py-2 rounded">好き</button>
            <button name="type" value="dislike" class="bg-red-500 text-white px-4 py-2 rounded">嫌い</button>
        </form>
    </div>

    @if(session('success'))
    <div class="text-center text-green-600 mb-8">
        {{ session('success') }}
    </div>
    @endif

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold mb-4">投票結果</h2>
        <p>好き: {{ $celebrity->like_count }}票</p>
        <p>嫌い: {{ $celebrity->dislike_count }}票</p>
        @php
        $totalVotes = $celebrity->like_count + $celebrity->dislike_count;
        $likePercentage = $totalVotes ? round(($celebrity->like_count / $totalVotes) * 100, 2) : 0;
        $dislikePercentage = $totalVotes ? round(($celebrity->dislike_count / $totalVotes) * 100, 2) : 0;
        @endphp
        <p>好きの割合: {{ $likePercentage }}%</p>
        <p>嫌いの割合: {{ $dislikePercentage }}%</p>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4">コメントを投稿</h2>
        <form action="{{ route('comment.store', $celebrity->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">タイプを選択してください:</label>
                <select name="type" id="type" class="w-full p-2 border rounded" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="like">好き</option>
                    <option value="dislike">嫌い</option>
                </select>
            </div>
            <textarea name="comment" class="w-full p-2 border rounded mb-4" placeholder="コメントを入力してください"></textarea>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">コメントを投稿</button>
        </form>
    </div>

    <div>
        <h3 class="text-xl font-bold mb-4">コメント一覧</h3>
        @foreach ($comments as $comment)
        <div class="mb-4 p-4 border rounded">
            <p class="text-gray-700">{{ $comment->comment }}</p>
            <p class="text-sm text-gray-500">タイプ: {{ $comment->type === 'like' ? '好き' : '嫌い' }}</p>
            <p class="text-sm text-gray-500">投稿日時: {{ $comment->created_at->format('Y-m-d H:i') }}</p>
        </div>
        @endforeach
    </div>

</div>
@endsection