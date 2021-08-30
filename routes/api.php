<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/route', function (Request $request){
    $request->validate(['name' => 'required|string|max:50']);
    return response()
        ->json(['uri' => \route($request->name)]);
});

Route::get('/routes', function(){
//    dd(Route::getRoutes());
    $routes = Route::getRoutes();
    $names = $routes->getRoutesByName();
    $data = [];
    foreach ($names as $key => $name) {
        $name = (array)$name;
        if (preg_match('#\{[\w\d]+?\}#si', $name['uri'])) {
            continue;
        }
        if (preg_match('#^\_.*?#si', $name['uri'])) {
            continue;
        }
        $data[] = ['route' => $key, 'uri' => $name['uri']];
    }
    return response()
        ->json(new \App\Http\Responses\ApiResponse(true, 'Route name list',
            $data));
});

Route::post('/transliteration', [App\Http\Controllers\ArticleController::class, 'transliteration'])
    ->name('api.transliteration');

Route::post('/tag/search', [App\Http\Controllers\TagController::class, 'search'])
    ->name('api.tag.search');
Route::post('/tag/create', [App\Http\Controllers\TagController::class, 'create'])
    ->name('api.tag.create');

Route::post('/menu/positions', [App\Http\Controllers\MenuController::class, 'getPositions']);

Route::group([
    'prefix' => '/menu'
], function () {
    Route::get('/get', [App\Http\Controllers\MenuController::class, 'getMenu'])
        ->name('api.menu.get');
});

Route::group([
    'prefix' => '/comment'
], function(){
    Route::get('/get', [CommentController::class, 'show'])
        ->name('api.comment.get');
});

Route::prefix('article')->group(function () {
    Route::get('/tag', [ArticleController::class, 'fromTagArticleApi'])
    ->name('api.article.get');

    Route::get('/main', [ArticleController::class, 'fromArticleApi'])
    ->name('api.article.main');
});
