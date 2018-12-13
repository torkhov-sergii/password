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

Route::group([], function () {
    Route::post('news', ['as' => 'news.server-side', 'uses' => 'NewsController@getAjaxNews']);
    Route::post('news-mert', ['as' => 'news.server-side', 'uses' => 'NewsController@getAjaxNewsMert']);
    Route::post('courses', ['as' => 'courses.server-side', 'uses' => 'CoursesController@getAjaxCourses']);
    //Route::post('articles', ['as' => 'articles.server-side', 'uses' => 'ArticlesController@getAjaxArticles']);
    Route::post('articles', ['as' => 'articles.server-side', 'uses' => 'ArticlesController@getAjaxArticles']);
    Route::post('filters', ['as' => 'filters', 'uses' => 'FiltersController@getAjaxFilters']);
    Route::post('slider-articles', ['as' => 'slider-articles', 'uses' => 'ArticlesController@getAjaxSliderArticles']);

    //default
    Route::post('feedback', ['as' => 'ajax.contact', 'uses' => 'MainController@postFeedback']);
    Route::post('search', ['as' => 'ajax.search', 'uses' => 'SearchController@search']);
    Route::post('subscribe', ['uses' => 'MainController@subscribe']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('main/server-side', ['as' => 'admin.main.server-side', 'uses' => 'Admin\MainController@serverSide']); //get main items
    Route::post('image/{id}/update_alt', ['uses' => 'ImageController@updateAlt']); //update alt for images
    Route::post('image/{id}/destroy', ['uses' => 'ImageController@destroy']); //destroy images
    Route::post('image_upload', ['uses' => 'ImageController@postAjaxImageSave']); //upload image
    Route::post('image_crop', ['uses' => 'ImageController@postAjaxImageCrop']); //crop image
    Route::post('file/{id}/destroy', ['uses' => 'FileController@destroy']); //destroy file
    //Route::post('relate', ['uses' => 'Admin\TypeController@relate']); //add relate
    Route::post('upload_file/{id}', ['uses' => 'ImageController@UploadTrumbowyg']); //upload file in fckrditor
    Route::post('tags', ['uses' => 'Admin\TagController@getAjaxTags']); //get tags list
    Route::post('translations/update', ['uses' => 'Admin\TranslationController@update']);

    //old
    //Route::post('ajax/feedback', ['as' => 'ajax.contact', 'uses' => 'MainController@postFeedback']);
    //Route::post('ajax/upload_trumbowyg/{id}', ['uses' => 'ImageController@UploadTrumbowyg']); //use in admin
    //Route::get('ajax/translate_all/', ['as'=> 'admin.translate.all', 'uses' => 'Admin\MainController@translateAll']); //use in
    //Route::post('ajax/news', ['uses' => 'MainController@getAjaxNews']); //новости ajax
    //Route::post('ajax/services', ['uses' => 'MainController@getAjaxServices']); //новости ajax
    //Route::post('ajax/main/server-side-relate', ['as' => 'admin.main.server-side-relate', 'uses' => 'Admin\MainController@serverSideRelate']);
    //Route::get('ajax/tags', ['uses' => 'TagController@getTags']); //списко тегов
});