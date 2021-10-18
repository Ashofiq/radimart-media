<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Uploader\UploaderController;
use App\Http\Controllers\Response\ResponseController;

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

Route::Post('/uploader', [UploaderController::class,'uploader'])->middleware('ImageGuard');
Route::Get('p/{imageType}/{name}', [ResponseController::class,'response']);


// Route::get('/', function()
// {
//     // return phpinfo();
//     $img = Image::make('https://d12zh9bqbty5wp.cloudfront.net/ckeditor_assets/attachments/2072/content_cdn-02_updated.jpg')->resize(300, 200);
//     // $img->save(public_path().'/baz.jpg');

//     echo Cache::put('img', '$img', 200);
//     echo Cache::get('img');
//     if(Cache::get('img') != null){
//         return Cache::get('img');
//     }
//     return $img->response('jpg');
// });