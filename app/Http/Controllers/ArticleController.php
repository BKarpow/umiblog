<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\ArticleService;
use App\Services\MenuService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private ArticleService $service;
    public function __construct()
    {
        $this->service = new ArticleService();
    }

    function index()
    {
        return view('welcome');
    }

    function indexPanel(){
        return view('panel.article.index', [
            'articles' => $this->service->getAll(),
            'isPaginate' => $this->service->isEnablePaginate()
        ]);
    }

    function create()
    {
        return view('panel.article.create');
    }

    function createAction(Request $request)
    {
//        dd($request->all());
        $data = $this->service->validateData($request);
        $newArticleId = $this->service->createNew($data);
        return redirect()
            ->route('panel.article.index')
            ->withStatus('Статтю створено, її ід '.$newArticleId);
    }

    function transliteration(Request $request)
    {
        $request->validate([
            'text' => 'required|max:400',
        ]);
        return response()
            ->json(new ApiResponse(true,
                'Transliteration method',
                ['text'=>$this->service->getTrans($request->text)]));
    }

    function delete($id)
    {
        return redirect()
            ->route('panel.article.index')
            ->withStatus(($this->service->deleteArticle($id) ? 'Статтю видалено' : 'Помилка видалення'));
    }

    function showArticle($url)
    {
        $article = $this->service->getArticle($url);
        if (!$article) {
            abort(404);
        }
        return view('article.full', [
            'article' => $article,
            ]);
    }

    function fromTagArticle($tag)
    {
        return view('article.tag', ['tag' => $tag]);
        
    }

    function fromTagArticleApi(Request $request)
    {
        $request->validate([
            'tag' => 'required|string|min:3|max:50',
            'limit' => 'required|string|min:1|max:3',
            'offset' => 'required|min:1',
        ]);
        return response()->json(
            $this->service->getArticlesFromTagApi($request->tag, (int)$request->offset, (int)$request->limit)
        );
        
    }

    function fromArticleApi(Request $request)
    {
        $request->validate([
            'limit' => 'required|string|min:1|max:3',
            'offset' => 'required|min:1',
        ]);
        return response()->json(
            $this->service->getArticlesFromApi( (int)$request->offset, (int)$request->limit)
        );
        
    }
}
