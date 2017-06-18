<?php

use Illuminate\Http\Request;

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
/**
 * 星火点赞
 */
Route::get('xinghuo', 'PageHomeController@xinghuo');

/**
 * 生成新pdf
 */
Route::get('fpdf/new', 'ApiFpdfController@newPdf');
/**
 * pdf转换成图片
 */
Route::post('pdf/to/img', 'ApiFpdfController@pdfToImg');


/**
 * 聚合获取手机归属地
 */
Route::post('get/mobile/region', 'ApiJuHeController@getMobileRegion');
/**
 * 聚合证件识别
 */
Route::get('juhe/card', 'ApiJuHeController@juheCard');
