<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 好感度ランキングを取得（like_countの降順で10件）
        $popularCelebrities = Celebrity::orderBy('like_count', 'desc')->take(10)->get();

        // 不人気ランキングを取得（dislike_countの降順で10件）
        $unpopularCelebrities = Celebrity::orderBy('dislike_count', 'desc')->take(10)->get();

        // トレンドランキングを取得（CelebrityViewのview_countを集計し、降順で10件）
        $trendingCelebrities = DB::table('celebrity_views')
            ->join('celebrities', 'celebrity_views.celebrity_id', '=', 'celebrities.id')
            ->select('celebrities.id', 'celebrities.name', DB::raw('SUM(celebrity_views.view_count) as total_views'))
            ->groupBy('celebrities.id', 'celebrities.name')
            ->orderBy('total_views', 'desc')
            ->take(10)
            ->get();

        // コメント数が多いランキングを取得
        $commentedCelebrities = DB::table('comments')
            ->join('celebrities', 'comments.celebrity_id', '=', 'celebrities.id')
            ->select('celebrities.id', 'celebrities.name', DB::raw('COUNT(comments.id) as comment_count'))
            ->groupBy('celebrities.id', 'celebrities.name')
            ->orderBy('comment_count', 'desc')
            ->take(6)
            ->get();

        // 関連付けが多いタグランキングを取得
        $popularTags = DB::table('celebrity_tag')
            ->join('tags', 'celebrity_tag.tag_id', '=', 'tags.id')
            ->select('tags.id', 'tags.name', DB::raw('COUNT(celebrity_tag.celebrity_id) as celebrity_count'))
            ->groupBy('tags.id', 'tags.name')
            ->orderBy('celebrity_count', 'desc')
            ->take(20)
            ->get();

        // 最新コメントを取得（最新順で10件）
        $latestComments = DB::table('comments')
            ->join('celebrities', 'comments.celebrity_id', '=', 'celebrities.id')
            ->select('comments.id', 'comments.comment', 'comments.type', 'comments.created_at', 'celebrities.name as celebrity_name', 'celebrities.id as celebrity_id')
            ->orderBy('comments.created_at', 'desc')
            ->take(10)
            ->get();

        return view('welcome', compact(
            'popularCelebrities',
            'unpopularCelebrities',
            'trendingCelebrities',
            'commentedCelebrities',
            'popularTags',
            'latestComments'
        ));
    }
}
