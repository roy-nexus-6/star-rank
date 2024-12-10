<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use App\Models\CelebrityView;
use App\Models\Comment;

use Illuminate\Http\Request;

class CelebrityController extends Controller
{
    public function ranking()
    {
        $celebrities = Celebrity::orderBy('like_count', 'desc')->paginate(10);

        return view('ranking', compact('celebrities'));
    }

    public function unpopular()
    {
        // Dislikeが多い順にセレブリティを取得
        $celebrities = Celebrity::orderBy('dislike_count', 'desc')->paginate(10);

        return view('unpopular', compact('celebrities'));
    }

    public function show($id)
    {
        $celebrity = Celebrity::with('tags')->findOrFail($id);

        // 今日の日付
        $today = now()->toDateString();

        // 当日の閲覧履歴を更新または作成
        $view = \App\Models\CelebrityView::firstOrCreate(
            ['celebrity_id' => $celebrity->id, 'view_date' => $today],
            ['view_count' => 0]
        );

        $view->increment('view_count');

        // 関連する画像を取得（images リレーションを想定）
        $images = $celebrity->images;

        // コメント一覧を取得
        $comments = \App\Models\Comment::where('celebrity_id', $celebrity->id)->latest()->get();

        // タグ一覧を取得
        $tags = $celebrity->tags;

        return view('celebrity.show', compact('celebrity', 'images', 'comments', 'tags'));
    }

    public function vote(Request $request, $id)
    {
        $celebrity = Celebrity::findOrFail($id);

        // セッションで投票済みか確認
        if (session()->has("voted_celebrity_{$id}")) {
            return redirect()->back()->with('error', 'すでに投票済みです。');
        }

        $voteType = $request->input('type'); // 'like' or 'dislike'

        if ($voteType === 'like') {
            $celebrity->increment('like_count');
        } elseif ($voteType === 'dislike') {
            $celebrity->increment('dislike_count');
        }

        // 投票済みフラグをセッションに保存
        session()->put("voted_celebrity_{$id}", true);

        return redirect()->back()->with('success', '投票ありがとうございました！');
    }

    public function trending($period)
    {
        // 基本クエリ
        $query = CelebrityView::with('celebrity')
            ->select('celebrity_id', \DB::raw('SUM(view_count) as total_views'))
            ->groupBy('celebrity_id');

        // 期間ごとの条件を追加
        if ($period === 'daily') {
            $query->where('view_date', now()->toDateString());
        } elseif ($period === 'weekly') {
            $query->whereBetween('view_date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'monthly') {
            $query->whereBetween('view_date', [now()->startOfMonth(), now()->endOfMonth()]);
        }

        // 閲覧数でソートしてページネーション
        $celebrities = $query->orderBy('total_views', 'desc')->paginate(10);

        return view('trending', compact('celebrities', 'period'));
    }
}
