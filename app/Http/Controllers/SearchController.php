<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // セレブリティ名とタグで検索
        $celebrities = Celebrity::query()
            ->where('name', 'LIKE', '%' . $query . '%') // 名前で部分一致検索
            ->orWhereHas('tags', function ($q) use ($query) { // タグで部分一致検索
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->with('tags') // 結果にタグも含める
            ->get();

        // 検索結果をビューに渡す
        return view('search-results', compact('celebrities', 'query'));
    }
}
