@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded-md overflow-hidden max-w-4xl mx-auto">
        <div class="bg-gray-100 py-4 px-6">
            <h2 class="text-2xl font-semibold text-gray-800">人気度ランキング</h2>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach ($celebrities as $index => $celebrity)
            <li class="flex items-center py-4 px-6">
                <span class="text-gray-700 text-lg font-medium mr-4">{{ $loop->iteration + ($celebrities->currentPage() - 1) * $celebrities->perPage() }}位</span>
                <img class="w-20 h-20 object-cover mr-4" src="https://randomuser.me/api/portraits/men/{{ $index + 10 }}.jpg" alt="{{ $celebrity->name }}">
                <div class="flex-1 overflow-hidden">
                    <a href="{{ route('celebrity.show', $celebrity->id) }}">
                        <h3 class="text-lg font-medium text-indigo-500 truncate hover:text-indigo-600">{{ $celebrity->name }}</h3>
                    </a>
                    <p class="text-gray-600 text-sm">Like数: {{ $celebrity->like_count }} / Dislike数: {{ $celebrity->dislike_count }}</p>
                </div>
            </li>
            @endforeach
        </ul>
        <!-- ページネーション -->
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            <div class="flex flex-1 justify-between sm:hidden">
                <a href="{{ $celebrities->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Previous
                </a>
                <a href="{{ $celebrities->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $celebrities->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $celebrities->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $celebrities->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        {{-- Previous Page --}}
                        @if ($celebrities->onFirstPage())
                        <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @else
                        <a href="{{ $celebrities->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        @endif
                        {{-- Pagination Elements --}}
                        @foreach ($celebrities->links()->elements[0] as $page => $url)
                        @if ($page == $celebrities->currentPage())
                        <span class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                        @endif
                        @endforeach
                        {{-- Next Page --}}
                        @if ($celebrities->hasMorePages())
                        <a href="{{ $celebrities->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
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
    </div>
</div>
@endsection