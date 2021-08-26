<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SitemapXmlController extends Controller
{
    function article()
    {
        $articles = Article::select('id', 'title', 'url', 'created_at')->get();
        return response()->view('sitemapArticle', [
            'articles' => $articles
        ])->header('Content-type', 'text/xml');
    }
}
