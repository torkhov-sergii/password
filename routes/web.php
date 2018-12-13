<?php

//================SYTE================
Route::group(['middleware' => ['language']], function () {
    Route::get('/', ['url' => [''], 'as' => 'home', 'uses' => 'MainController@getIndex']);

    Route::get('articles/poradi-prozorro', ['url' => [''], 'uses' => 'MainController@getLandingPoradi']);
    Route::get('articles/yak-shukati-cikavi-tenderi', ['url' => [''], 'uses' => 'MainController@getLandingYak']);

    //Route::get('company', ['url' => ['company'], 'as' => 'company', 'uses' => 'MainController@getCompany']);

    Route::get('updates', ['url' => ['updates'], 'as' => 'news', 'uses' => 'NewsController@getNews']);
    Route::get('news-mert', ['url' => ['news-mert'], 'as' => 'news-mert', 'uses' => 'NewsController@getNewsMert']);
    Route::get('updates/{slug}', ['url' => ['updates', 'slug'], 'as' => 'news.view', 'uses' => 'NewsController@getNewsItem']);
    Route::get('news-mert/{slug}', ['url' => ['news-mert', 'slug'], 'as' => 'news-mert.view', 'uses' => 'NewsController@getNewsItemMert']);

    Route::get('courses', ['url' => ['courses'], 'as' => 'courses', 'uses' => 'CoursesController@getCourses']);
    Route::get('courses/{slug}', ['url' => ['courses', 'slug'], 'as' => 'courses.view', 'uses' => 'CoursesController@getCourseItem']);

    Route::get('articles', ['url' => ['articles'], 'as' => 'articles', 'uses' => 'ArticlesController@getArticles']);
    Route::get('articles/{slug}', ['url' => ['articles', 'slug'], 'as' => 'articles.view', 'uses' => 'ArticlesController@getArticleItem']);

    Route::get('faq', ['as' => 'faq', 'uses' => 'FaqController@getIndex']);
    Route::get('faq/{slug}', ['url' => ['faq', 'slug'], 'as' => 'faq.view', 'uses' => 'FaqController@getItem']);

    //Route::get('career', ['url' => ['career', 'slug'], 'as' => 'career', 'uses' => 'MainController@getCareer']);

    //BLOG
    //Route::get('blog', ['as' => 'blog', 'uses' => 'BlogController@getBlog']);
    //Route::get('blog/{slug}', ['as' => 'blog.category', 'uses' => 'BlogController@getBlogCategory']);
    //Route::get('blog/tag/{slug}', ['url' => ['blog', 'tag', 'slug'], 'as' => 'blog.tag', 'uses' => 'BlogController@getBlogTag']);
    //Route::get('blog/{category_slug}/{slug}', ['url' => ['blog', 'parenttype=11=slug', 'slug'], 'as' => 'blog.post', 'uses' => 'BlogController@getBlogPost']);

    //===============STANDART=============
    Route::get('search', ['as' => 'search', 'uses' => 'SearchController@search']);
    Route::get('search/{search_string}', ['as' => 'search.result', 'uses' => 'SearchController@search']);
    Route::get('sitemap.xml', 'SitemapController@generate');

//    //================COMMENTS================
//    Route::group(['prefix' => 'comments', 'before' => 'auth'], function () {
//        Route::get('/', ['as' => 'comments.store', 'uses' => 'CommentsController@store']);
//    });

    //redirect
    Route::get('/mertnews/{id}/view', ['as' => 'search', 'uses' => 'NewsController@redirectMert']);
    Route::get('/news/{id}/view', ['as' => 'search', 'uses' => 'NewsController@redirect']);
    Route::get('/knowledge-base/view/{id}', ['as' => 'search', 'uses' => 'ArticlesController@redirect']);
    Route::get('/specifications', ['as' => 'search', 'uses' => 'RedirectController@specificationsIndex']);
    Route::get('/specifications/product/{id}/view', ['as' => 'search', 'uses' => 'RedirectController@specificationsItem']);
    Route::get('/specifications/constructor/{id}', ['as' => 'search', 'uses' => 'RedirectController@specificationsConstructor']);
});

//================AUTH================
Route::get("register", function(){ App::abort(404); }); //отключить возможность регистрации
//Route::auth(); Auth::routes();
Route::group(['middleware' => ['web']], function() {
    // Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    // Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset/{token}', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

    Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
    Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

    //login as - logout
    Route::get("/user/log_out_as", ['as' => 'user.log_out_as', 'uses' => 'Admin\UserController@logOutAs']); //вернуться из (войти как)
});

//================ADMIN================
Route::group(['middleware' => ['permission:admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get("/", ['as' => 'admin.index', 'uses' => 'IndexController@index']);
    Route::get("/about", ['as' => 'admin.about', 'uses' => 'IndexController@about']);
    Route::group(['middleware' => 'permission:type'], function() {Route::resource("type","TypeController", ["as"=>"admin"]);});

    Route::group(['middleware' => 'permission:seo'], function() {
        Route::resource("seo","SeoController", ["as"=>"admin"]);
        Route::post("seo", ['as' => 'admin.seo.update', 'uses' => 'SeoController@update']);
    });

    Route::group(['middleware' => 'permission:settings'], function() {
        Route::resource("settings","SettingsController", ["as"=>"admin"]);
    });

    Route::group(['middleware' => 'permission:main'], function() {
        Route::resource("main","MainController", ["as"=>"admin"]);
        Route::delete('main/{id}/destroy', ['as' => 'admin.main.destroy', 'uses' => 'MainController@destroy']);
        Route::get('main/create/{parent_id}/{type_id}', ['as' => 'admin.main.create', 'uses' => 'MainController@create']);
        Route::get('main/{id}/posts', ['as' => 'main.posts-in-category', 'uses' => 'MainController@getPostsInCategory']);
        Route::get('main/{id}/{direction}', ['as' => 'main.sort', 'uses' => 'MainController@sort']);
    });

    //USER
    Route::group(['middleware' => 'permission:user'], function() {Route::resource("user","UserController", ["as"=>"admin"]);});
    Route::get('profile', ['as' => 'admin.user.profile', 'uses' => 'UserController@myProfile']);

    Route::group(['middleware' => 'permission:role'], function() {Route::resource("role","RoleController", ["as"=>"admin"]);});

    Route::group(['prefix' => 'translations', 'middleware' => 'permission:translations'], function() {
        Route::get("/", ['as' => 'admin.translations', 'uses' => 'TranslationController@getIndex']);
        Route::get("view/{group}", ['as' => 'admin.translations.view', 'uses' => 'TranslationController@getView']);
        Route::post("add/{group}", ['as' => 'admin.translations.add', 'uses' => 'TranslationController@postAdd']);
        Route::post("publish/{group}", ['as' => 'admin.translations.publish', 'uses' => 'TranslationController@postPublish']);
        Route::post("update", ['as' => 'admin.translations.edit', 'uses' => 'TranslationController@update']);
        Route::delete("delete/{group}/{key}", ['as' => 'admin.translations.delete', 'uses' => 'TranslationController@delete']);
        //Route::post("/import", ['as' => 'admin.translations.import', 'uses' => '\Barryvdh\TranslationManager\Controller@postImport']);
    });

    //login as
    Route::get("/user/login_as/{id}", ['as' => 'user.login_as', 'uses' => 'UserController@loginAs']); //войти как

    Route::group(['middleware' => 'permission:backup'], function() {
        Route::get("/backup", ['as' => 'admin.backup.index', 'uses' => 'BackupController@backupIndex']);
        Route::get("/backup/files/create", ['as' => 'admin.files.create', 'uses' => 'BackupController@createFiles']);
        Route::get("/backup/bd/create", ['as' => 'admin.bd.create', 'uses' => 'BackupController@createBd']);
    });

    //================COMMENTS================
    Route::group(['prefix' => 'comments', 'middleware' => 'permission:comments'], function () {
        Route::get('/', ['as' => 'admin.comments.index', 'uses' => 'CommentsController@index']);
        Route::get('not_approved', ['as' => 'admin.comments.not_approved', 'uses' => 'CommentsController@notApproved']);
        Route::delete('{id}/destroy', ['as' => 'admin.comments.destroy', 'uses' => 'CommentsController@destroy']);
        Route::post('{id}/approve', ['as' => 'admin.comments.approve', 'uses' => 'CommentsController@approve']);
    });

    //TAGS
    Route::group(['prefix' => 'tag', 'middleware' => 'permission:tags'], function () {
        Route::resource("tag","TagController", ["as"=>"admin"]);
//        Route::get('/', ['as' => 'admin.tag.index', 'uses' => 'TagController@index']);
//        Route::delete('{id}', ['as' => 'admin.tag.edit', 'uses' => 'TagController@edit']);
//        Route::delete('{id}/destroy', ['as' => 'admin.tag.destroy', 'uses' => 'TagController@destroy']);
    });

    //вынос мозга с method, http://laravel.com/docs/4.2/controllers#basic-controllers
    //иногда надо определить в форме метод  <input type="hidden" name="_method" value="PUT">

    //prozorro
    Route::get("/prozorro/start-blocks", ['uses' => 'ProzorroController@startBlocks']);
    Route::post("/prozorro/start-blocks", ['uses' => 'ProzorroController@startBlocksSave']);
});

// Js Localization
Route::get("/js/lang.js", ['uses' => 'Admin\TranslationController@generatedLangJs']);