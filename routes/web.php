<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapXmlController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductSectionController;
use App\Http\Controllers\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/fake', function(){
    $faker = Faker\Factory::create();
    foreach(range(1,20) as $item) {
        echo "<img src=\"".$faker->imageUrl(400, 400)."\" /><br />";
    }
});

Route::get('/lab', function(){
    $faker = Faker\Factory::create();
    $data = [];
    foreach(range(0, 40) as $item) {
        $data[] = $faker->text(200);
    }
    return view('lab', ['data' => $data]);
})->name('lab');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('sitemap-articles.xml', [SitemapXmlController::class, 'article'])
    ->name('sitemap.articles');

Route::group([
    'prefix' => '/ajax'
], function(){
    // /ajax
    Route::group([
        'prefix' => '/upload'
    ], function(){
        // /ajax/upload
        Route::post('/image', [App\Http\Controllers\UploadController::class, 'uploadImage']);
    });
});

Route::group([
    'prefix' => '/panel',
    'middleware' => 'admin'
], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home.panel');

    Route::group([
        'prefix' => '/category-product'
    ], function(){
        Route::post('/create', [ProductCategoryController::class, 'create'])
            ->name('panel.api.createCategory');
        Route::post('/update', [ProductCategoryController::class, 'update'])
            ->name('panel.api.updateCategory');
        Route::post('/delete', [ProductCategoryController::class, 'delete'])
            ->name('panel.api.deleteCategory');
    });

    Route::group([
        'prefix' => '/product-section'
    ], function() {
        Route::get('/', [ProductSectionController::class, 'index'])
            ->name('panel.product.section.index');
        Route::get('/getApi', [ProductSectionController::class, 'getAllApi'])
            ->name('panel.api.getSections');
        Route::post('/create', [ProductSectionController::class, 'create'])
            ->name('panel.api.createSection');
        Route::post('/update', [ProductSectionController::class, 'update'])
            ->name('panel.api.updateSection');
        Route::post('/delete', [ProductSectionController::class, 'delete'])
            ->name('panel.api.deleteSection');
    });

    Route::group([
        'prefix' => '/comment'
    ], function() {
        Route::get('/', [CommentController::class, 'index'])
            ->name('panel.comment.index');
        Route::get('/toggle/{commentId}', [CommentController::class, 'togglePublic'])
            ->name('panel.comment.toggle');
    });

    Route::group([
        'prefix' => '/menu'
    ], function(){
        Route::get('/', [App\Http\Controllers\MenuController::class, 'index'])
            ->name('panel.menu.index');
        Route::get('/create', [App\Http\Controllers\MenuController::class, 'create'])
            ->name('panel.menu.create');
        Route::post('/create/action', [App\Http\Controllers\MenuController::class, 'createAction'])
            ->name('panel.menu.create.action');
        Route::get('/delete-{id}', [App\Http\Controllers\MenuController::class, 'delete'])
            ->name('panel.menu.delete');
    });

    Route::group([
        'prefix' => '/article'
    ], function(){
        Route::get('/', [App\Http\Controllers\ArticleController::class, 'indexPanel'])
            ->name('panel.article.index');
        Route::get('/create', [App\Http\Controllers\ArticleController::class, 'create'])
            ->name('panel.article.create');
        Route::get('/delete/{id}', [App\Http\Controllers\ArticleController::class, 'delete'])
            ->name('panel.article.delete');
        Route::post('/create/action', [App\Http\Controllers\ArticleController::class, 'createAction'])
            ->name('panel.article.create.action');
    });

    Route::group([
        'prefix' => '/user'
    ], function() {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])
            ->name('panel.user.index');
        Route::post('/create', [App\Http\Controllers\UserController::class, 'create'])
            ->name('panel.user.create');
        Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])
            ->name('panel.user.update');
        Route::get('/delete/{user_id}', [App\Http\Controllers\UserController::class, 'delete'])
            ->name('panel.user.delete');
    });
});

Route::get('/', [App\Http\Controllers\ArticleController::class, 'index'])
    ->name('home');

Route::group([
    'prefix' => '/article'
], function(){
    Route::get('/', [App\Http\Controllers\ArticleController::class, 'index'])
        ->name('article.index');
    Route::get('/{url}', [App\Http\Controllers\ArticleController::class, 'showArticle'])
        ->name('article.show');
    Route::get('/tag/{tag}', [App\Http\Controllers\ArticleController::class, 'fromTagArticle'])
        ->name('article.tag');
});

Route::group([
    'prefix' => '/comment',
    'middleware' => 'auth',
], function(){
    Route::post('/create', [CommentController::class, 'create'])
        ->name('comment.create');
});

Route::get('/contact', function () {
    return view('static.contact');
})->name('page.contact');


