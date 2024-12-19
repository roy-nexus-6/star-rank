@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-4">{{ $celebrity->name }}のことが、好き？嫌い？</h1>

    <div class="flex justify-center mb-8">
        @if (count($googleImages) > 0)
        @foreach ($googleImages as $image)
        <img src="{{ $image }}" alt="{{ $celebrity->name }}" style="max-width: 200px; margin: 10px;" class="object-contain">
        @endforeach
        @else
        <p>Google 検索画像が見つかりません。</p>
        @endif
    </div>

    {{-- 投票フォーム --}}
    @if(!session("voted_celebrity_{$celebrity->id}"))
    <div class="text-center mb-8">
        <h2 class="mb-2">＼ 投票してコメントを見てみよう! ／</h2>
        <form action="{{ route('celebrity.vote', $celebrity->id) }}" method="POST">
            @csrf
            <button name="type" value="like" class="bg-red-500 text-white px-4 py-2 mx-2 my-2 w-80 rounded">好き</button>
            <button name="type" value="dislike" class="bg-blue-500 text-white px-4 py-2 mx-2 my-2 w-80 rounded">嫌い</button>
        </form>
        <p class="mt-4">※「好き」「嫌い」の投票は1日1回まで</p>
    </div>
    @else
    {{-- 投票結果 --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold mb-4">投票結果</h2>
        <div class="flex justify-between">
            <div>
                <p class="mb-2">好き: {{ $celebrity->like_count }}票</p>
            </div>
            <div>
                <p class="mb-2">嫌い: {{ $celebrity->dislike_count }}票</p>
            </div>
        </div>
        @php
        $totalVotes = $celebrity->like_count + $celebrity->dislike_count;
        $likePercentage = $totalVotes ? round(($celebrity->like_count / $totalVotes) * 100, 2) : 0;
        $dislikePercentage = $totalVotes ? round(($celebrity->dislike_count / $totalVotes) * 100, 2) : 0;
        @endphp

        {{-- 横棒グラフ --}}
        <div class="relative w-full max-w-2xl mx-auto h-8 bg-gray-200 rounded overflow-hidden">
            {{-- 好きバー --}}
            <div class="absolute top-0 left-0 h-full bg-red-500 text-white text-xs font-medium flex items-center justify-center"
                style="width: {{ $likePercentage }}%;">
                {{ $likePercentage }}%
            </div>
            {{-- 嫌いバー --}}
            <div class="absolute top-0 right-0 h-full bg-blue-500 text-white text-xs font-medium flex items-center justify-center"
                style="width: {{ $dislikePercentage }}%;">
                {{ $dislikePercentage }}%
            </div>
        </div>
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
            <button type="submit" class="bg-black hover:bg-gray-600 text-white px-4 py-2 rounded">コメントを投稿</button>
        </form>
    </div>

    {{-- コメント一覧 --}}
    <div>
        <h3 class="text-xl font-bold mb-4">コメント一覧</h3>
        @foreach ($comments as $comment)
        <div class="mb-4 p-4 border rounded">
            {{-- コメント内容 --}}
            <p class="text-gray-700 text-lg font-bold">
                <span class="text-gray-500 text-sm">#{{ $comment->id }}</span>
                @if ($comment->parent_id)
                <span class="text-blue-500 ml-2">>>{{ $comment->parent_id }}</span>
                @endif
                {{ $comment->comment }}
            </p>
            <p class="text-sm text-gray-500">
                タイプ: {{ $comment->type === 'like' ? '好き' : '嫌い' }}
            </p>
            <p class="text-sm text-gray-500">投稿日時: {{ $comment->created_at->format('Y-m-d H:i') }}</p>

            {{-- 返信ボタン --}}
            <button
                onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
                class="text-sm text-blue-500 hover:underline mt-2">
                返信
            </button>

            {{-- 返信フォーム --}}
            <form
                action="{{ route('comment.store', $celebrity->id) }}"
                method="POST"
                id="reply-form-{{ $comment->id }}"
                class="hidden mt-2">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                {{-- Type選択 --}}
                <label for="type-{{ $comment->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                    タイプを選択してください:
                </label>
                <select name="type" id="type-{{ $comment->id }}" class="w-full p-2 border rounded mb-2" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="like">好き</option>
                    <option value="dislike">嫌い</option>
                </select>

                {{-- コメント入力 --}}
                <textarea
                    name="comment"
                    class="w-full p-2 border rounded mb-2"
                    placeholder="返信を入力してください" required></textarea>

                {{-- 送信ボタン --}}
                <button type="submit" class="bg-black hover:bg-gray-600 text-white px-4 py-2 rounded">
                    返信を投稿
                </button>
            </form>
        </div>
        @endforeach
    </div>
    <!-- ページネーション -->
    <div class="flex items-center justify-between border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <!-- Previous Page for Small Screen -->
            <a href="{{ $comments->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Previous
            </a>
            <a href="{{ $comments->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Next
            </a>
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <!-- Page Info -->
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $comments->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $comments->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $comments->total() }}</span>
                    results
                </p>
            </div>

            <!-- Pagination Links -->
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    {{-- Previous Page --}}
                    @if ($comments->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    @else
                    <a href="{{ $comments->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    @endif

                    {{-- Pagination Links --}}
                    @foreach ($comments->links()->elements[0] as $page => $url)
                    @if ($page == $comments->currentPage())
                    <span class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        {{ $page }}
                    </a>
                    @endif
                    @endforeach

                    {{-- Next Page --}}
                    @if ($comments->hasMorePages())
                    <a href="{{ $comments->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    @else
                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    @endif
                </nav>
            </div>
        </div>
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