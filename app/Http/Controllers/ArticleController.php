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
        return view('welcome', [
            'articles' => $this->service->getNewArticle(),
            'leftMenu' => (new MenuService())->getItemsFromNameMenu('ліве меню'),
        ]);
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
        dd($url);
    }
}
