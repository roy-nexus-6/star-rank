<?php

namespace App\Http\Controllers;

use App\Models\Celebrity;
use App\Models\CelebrityView;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

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
        // 芸能人データを取得
        $celebrity = Celebrity::with('tags')->findOrFail($id);

        // 今日の日付
        $today = now()->toDateString();

        // 当日の閲覧履歴を更新または作成
        $view = \App\Models\CelebrityView::firstOrCreate(
            ['celebrity_id' => $celebrity->id, 'view_date' => $today],
            ['view_count' => 0]
        );
        $view->increment('view_count');

        // Google APIを使用して画像検索
        $googleImages = $this->getGoogleImages($celebrity->name);

        // コメント一覧を取得
        $comments = \App\Models\Comment::where('celebrity_id', $celebrity->id)
            ->latest()
            ->paginate(10);

        // タグ一覧を取得
        $tags = $celebrity->tags;

        return view('celebrity.show', compact('celebrity', 'googleImages', 'comments', 'tags'));
    }

    /**
     * Google Custom Search API を使用して画像を取得
     */
    private function getGoogleImages($query)
    {
        $apiKey = env('GOOGLE_API_KEY');
        $cx = env('GOOGLE_CX');

        // 除外するドメインリスト
        $excludedDomains = ['instagram.com', 'twitter.com', 'facebook.com', 'threads.net'];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://www.googleapis.com/customsearch/v1', [
                'query' => [
                    'key' => $apiKey,
                    'cx' => $cx,
                    'q' => $query . ' 本人写真',
                    'searchType' => 'image',
                    'safe' => 'off',               // セーフサーチ無効
                    'imgType' => 'face',           // 顔画像を優先
                    'num' => 5,                    // 結果数
                    'gl' => 'jp',                  // 日本の地域優先
                    'hl' => 'ja',   
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $images = [];
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $url = $item['link'];

                    // 除外リストに含まれるドメインをチェック
                    $isExcluded = false;
                    foreach ($excludedDomains as $domain) {
                        if (strpos($url, $domain) !== false) {
                            $isExcluded = true;
                            break;
                        }
                    }

                    if (!$isExcluded) {
                        $images[] = $url;
                    }
                }
            }

            return $images;
        } catch (\Exception $e) {
            Log::error("Google Custom Search API エラー: " . $e->getMessage());
            return [];
        }
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
