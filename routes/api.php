<?php
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\tagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', [ArticlesController::class,'index']);
Route::get('/articles/{id}/comments', [ArticlesController::class,'article_comments']);
Route::get('/tags', [TagsController::class,'index']);
Route::get('/tags/{id}/articles', [TagsController::class,'tags_articles']);
