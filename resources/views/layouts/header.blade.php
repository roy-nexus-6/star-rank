<header class="text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl">Suki-Kirai.jp</span>
        </a>
        <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
            <a class="mr-5 hover:text-gray-900">好感度ランキング</a>
            <a class="mr-5 hover:text-gray-900">不人気ランキング</a>
            <a class="mr-5 hover:text-gray-900">トレンドランキング</a>
        </nav>
        <form action="{{ route('search') }}" method="GET" class="flex items-center mt-4 md:mt-0">
            <input
                type="text"
                name="query"
                placeholder="検索"
                class="w-48 px-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            <button type="submit" class="ml-2 inline-flex items-center text-white bg-indigo-500 border-0 py-1 px-3 focus:outline-none hover:bg-indigo-600 rounded text-base">
                検索
            </button>
        </form>
    </div>
</header>