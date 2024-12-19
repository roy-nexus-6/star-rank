<header class="bg-black text-white body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 mr-5 md:mb-0">
            <img src="{{ asset('images/logo.png') }}" class="h-10">
        </a>
        <nav class=" flex flex-wrap items-center text-base justify-center">
            <a href="{{ route('ranking') }}" class="mr-5 hover:underline">好感度ランキング</a>
            <a href="{{ route('unpopular') }}" class="mr-5 hover:underline">不人気ランキング</a>
            <a href="{{ route('trending',['period' => 'all']) }}" class="mr-5 hover:underline">トレンドランキング</a>
        </nav>
    </div>
</header>