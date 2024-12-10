@extends('layouts.app')

@section('content')

<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">今、一番輝いているのは誰？芸能人の人気ランキングをチェック！
            </h1>
            <p class="mb-8 leading-relaxed">今注目の芸能人やスターの人気度ランキングをリアルタイムでチェック！テレビ、映画、音楽、SNSで話題沸騰中のあの人の順位がわかる。あなたの応援でランキングが変わるかも！？</p>
            <div class="flex justify-center">
                <a href="#ranking-section" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">ランキングを見る</a>
                <!-- <button class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">不人気度ランキング</button> -->
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="hero" src="{{ asset('images/hero.webp') }}">
        </div>
    </div>
</section>

<section>
    <div class="container px-5 py-24 mx-auto">
        <div id="ranking-section" class="flex flex-wrap md:flex-nowrap justify-between space-x-4">
            <!-- 好感度ランキング -->
            <div class="bg-white shadow-md rounded-md overflow-hidden max-w-lg mx-auto mt-16">
                <div class="bg-gray-100 py-2 px-4">
                    <h2 class="text-xl font-semibold text-gray-800">好感度ランキング</h2>
                </div>
                <ul class="divide-y divide-gray-200">
                    @foreach ($popularCelebrities as $index => $popularCelebrity)
                    <li class="flex items-center py-4 px-6 h-26">
                        <span class="text-gray-700 text-lg font-medium mr-4">{{ $loop->iteration }}位</span>
                        <img class="w-20 h-20 object-cover mr-4" src="https://randomuser.me/api/portraits/men/{{ $popularCelebrity->id }}.jpg" alt="User avatar">
                        <div class="flex-1 overflow-hidden">
                            <a href="{{ route('celebrity.show', $popularCelebrity->id) }}">
                                <h3 class="text-lg font-medium text-indigo-500 truncate hover:text-indigo-600">{{ $popularCelebrity->name }}</h3>
                            </a>
                            <p class="text-gray-600 text-base truncate">{{ $popularCelebrity->like_count }} 人が好き</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="py-2 px-4 text-center">
                    <a href="{{ route('ranking') }}" class="font-semibold text-indigo-500">もっと見る</a>
                </div>
            </div>

            <!-- 不人気度ランキング -->
            <div class="bg-white shadow-md rounded-md overflow-hidden max-w-lg mx-auto mt-16">
                <div class="bg-gray-100 py-2 px-4">
                    <h2 class="text-xl font-semibold text-gray-800">不人気度ランキング</h2>
                </div>
                <ul class="divide-y divide-gray-200">
                    @foreach ($unpopularCelebrities as $index => $unpopularCelebrity)
                    <li class="flex items-center py-4 px-6 h-26">
                        <span class="text-gray-700 text-lg font-medium mr-4">{{ $loop->iteration }}位</span>
                        <img class="w-20 h-20 object-cover mr-4" src="https://randomuser.me/api/portraits/men/{{ $unpopularCelebrity->id }}.jpg" alt="User avatar">
                        <div class="flex-1 overflow-hidden">
                            <a href="{{ route('celebrity.show', $unpopularCelebrity->id) }}">
                                <h3 class="text-lg font-medium text-indigo-500 truncate hover:text-indigo-600">{{ $unpopularCelebrity->name }}</h3>
                            </a>
                            <p class="text-gray-600 text-base truncate">{{ $unpopularCelebrity->dislike_count }} 人が嫌い</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="py-2 px-4 text-center">
                    <a href="{{ route('unpopular') }}" class="font-semibold text-indigo-500">もっと見る</a>
                </div>
            </div>

            <!-- トレンドランキング -->
            <div class="bg-white shadow-md rounded-md overflow-hidden max-w-lg mx-auto mt-16">
                <div class="bg-gray-100 py-2 px-4">
                    <h2 class="text-xl font-semibold text-gray-800">トレンドランキング</h2>
                </div>
                <ul class="divide-y divide-gray-200">
                    @foreach ($trendingCelebrities as $index => $celebrity)
                    <li class="flex items-center py-4 px-6 h-26">
                        <span class="text-gray-700 text-lg font-medium mr-4">{{ $loop->iteration }}位</span>
                        <img class="w-20 h-20 object-cover mr-4" src="https://randomuser.me/api/portraits/men/{{ $celebrity->id }}.jpg" alt="User avatar">
                        <div class="flex-1 overflow-hidden">
                            <a href="{{ route('celebrity.show', $celebrity->id) }}">
                                <h3 class="text-lg font-medium text-indigo-500 truncate hover:text-indigo-600">{{ $celebrity->name }}</h3>
                            </a>
                            <p class="text-gray-600 text-base truncate">{{ $celebrity->total_views }} 人が閲覧</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="py-2 px-4 text-center">
                    <a href="{{ route('trending', ['period' => 'all']) }}" class="font-semibold text-indigo-500">もっと見る</a>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-4">
            <h1 class="text-2xl font-medium title-font mb-4 text-gray-900">話題の人物</h1>
        </div>
        <div class="flex flex-wrap -m-4">
            @foreach ($commentedCelebrities as $index => $commentedCelebrity)
            <div class="p-4 lg:w-1/6 md:w-1/3 sm:w-1/2 w-full">
                <div class="h-full flex flex-col items-center text-center">
                    <!-- 画像のサイズを小さく -->
                    <img alt="{{ $commentedCelebrity->name }}" class="w-24 h-24 object-cover mb-4" src="https://randomuser.me/api/portraits/men/{{ $commentedCelebrity->id }}.jpg">
                    <div class="w-full">
                        <!-- 名前 -->
                        <a href="{{ route('celebrity.show', $commentedCelebrity->id) }}">
                            <h2 class="title-font font-medium text-base text-indigo-500 hover:text-indigo-600">{{ $commentedCelebrity->name }}</h2>
                        </a>
                        <!-- その他情報 -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- 関連付けの多いタグを表示するセクション -->
<section class="text-gray-600 body-font">
    <div class="m-6 p-4">
        <div class="flex flex-wrap gap-3 justify-light">
            <div class="flex items-center w-full">
                <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
                <span class="text-2xl font-medium title-font text-gray-900">話題のタグ</span>
                <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
            </div>
            @foreach ($popularTags as $tag)
            <a href="{{ route('search', ['query' => $tag->name]) }}" class="bg-gray-100 rounded-md px-3 py-2">
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex items-center w-full">
            <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
            <span class="text-2xl font-medium title-font text-gray-900">最新のコメント</span>
            <span class="flex-grow bg-gray-200 rounded h-0.5"></span>
        </div>
        <div class="flex flex-wrap -m-2">
            @foreach ($latestComments as $comment)
            <div class="p-4 lg:w-1/2 md:w-full">
                <div class="h-full bg-gray-100 p-6 rounded-lg">
                    <!-- Loop index を使用して画像を一意に -->
                    <img class="w-20 h-20 object-cover mb-2" src="https://randomuser.me/api/portraits/men/{{ $comment->celebrity_id }}.jpg" alt="User avatar">
                    <h2 class="text-lg text-indigo-500 font-medium title-font mb-2">
                        <a href="{{ route('celebrity.show', $comment->celebrity_id) }}">
                            {{ $comment->celebrity_name }} について
                        </a>
                    </h2>
                    <p class="leading-relaxed text-base mb-4">{{ $comment->comment }}</p>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') }}</span>
                    <span class="text-xs ml-2 py-1 px-3 bg-gray-300 rounded">
                        {{ $comment->type === 'like' ? '好き' : '嫌い' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


@endsection