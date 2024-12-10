@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-4">{{ $celebrity->name }}のことが、好き？嫌い？</h1>

    <div class="flex justify-center mb-8">
        <div class="px-2">
            <img src="https://randomuser.me/api/portraits/men/{{ $celebrity->id }}.jpg" alt="ダミー画像" class="rounded shadow">
        </div>
    </div>

    {{-- 投票フォーム --}}
    @if(!session("voted_celebrity_{$celebrity->id}"))
    <div class="text-center mb-8">
        <form action="{{ route('celebrity.vote', $celebrity->id) }}" method="POST">
            @csrf
            <button name="type" value="like" class="bg-green-500 text-white px-4 py-2 rounded">好き</button>
            <button name="type" value="dislike" class="bg-red-500 text-white px-4 py-2 rounded">嫌い</button>
        </form>
    </div>
    @else
    {{-- 投票結果 --}}
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

    {{-- コメント投稿フォーム --}}
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

    {{-- コメント一覧 --}}
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
    @endif
    <section class="text-gray-600 body-font">
    <div class="m-6 p-4">
        <div class="flex flex-wrap gap-3 justify-light">
            <div class="flex items-center w-full">
                <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
                <span class="text-2xl font-medium title-font text-gray-900">関連タグ</span>
                <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
            </div>
            @if ($tags->isNotEmpty())
                @foreach ($tags as $tag)
                <a href="{{ route('search', ['query' => $tag->name]) }}" class="bg-gray-100 rounded-md px-3 py-2">
                    {{ $tag->name }}
                </a>
                @endforeach
            @else
                <p class="text-gray-500">タグはありません。</p>
            @endif
        </div>
    </div>
</section>
</div>
@endsection