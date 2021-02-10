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
Route::get('all/publishers',array('uses'=>'PublisherController@getAllPublishers'));

Route::get('all/locations',array('uses'=>'LocationController@getAllLocations'));

Route::get('all/genders',array('uses'=>'GenderController@getAllgenders'));

Route::post('register/user',array('uses'=>'UserController@registerUser'));

Route::post('register/reader',array('uses'=>'UserController@RegisterReader'));

Route::post('forgot/password',array('uses'=>'UserController@forgotPassword'));

Route::post('forgot/password/code',array('uses'=>'UserController@checkForgotPasswordCode'));

Route::post('new/password',array('uses'=>'UserController@forgotPasswordChange'));


Route::group(['middleware' => ['auth:api']], function () {


    Route::get('/user',array('uses'=>'UserController@getUser'));


    Route::get('all/groups',array('uses'=>'GroupController@getAllUserGroups'));

    
    Route::get('all/publications',array('uses'=>'PublicationController@getAllPublications'));

    Route::get('all/publications/reading',array('uses'=>'PublicationController@getPublicationForReading'));


    Route::get('all/types',array('uses'=>'TypeController@getAllTypes'));

    Route::get('all/languages',array('uses'=>'LanguageController@getAllLanguages'));

    Route::get('all/perspectives',array('uses'=>'PerspectiveController@getAllPerspectives'));

    Route::post('all/comments',array('uses'=>'CommentController@getCommentsFromRequest'));

    Route::post('all/headlines',array('uses'=>'HeadlineController@getAllHeadlines'));

    Route::post('send/views',array('uses'=>'ViewsController@sendViews'));


    Route::post('all/coverPages',array('uses'=>'CoverPageController@getAllCoverPages'));


    Route::post('invite',array('uses'=>'InviteController@invite'));


    Route::post('upload/image',array('uses'=>'UploadController@Upload'));

    Route::post('create/coverpage',array('uses'=>'CoverPageController@create'));

    Route::post('create/headlines',array('uses'=>'HeadlineController@create'));

    Route::post('delete/headline',array('uses'=>'HeadlineController@delete'));

    Route::post('edit/headline',array('uses'=>'HeadlineController@edit'));
    

    Route::post('block/headline',array('uses'=>'HeadlineController@block'));


    Route::post('create/publisher',array('uses'=>'PublisherController@create'));

    Route::post('edit/publisher',array('uses'=>'PublisherController@edit'));

    Route::post('delete/publisher',array('uses'=>'PublisherController@delete'));

    Route::post('delete/publication',array('uses'=>'PublicationController@deletePublicationFromRequest'));

    Route::post('create/publication',array('uses'=>'PublicationController@create'));

    Route::post('delete/coverPage',array('uses'=>'CoverPageController@delete'));

    Route::post('block/coverPage',array('uses'=>'CoverPageController@block'));

    Route::post('edit/coverpage',array('uses'=>'CoverPageController@edit'));


    Route::post('create/comment',array('uses'=>'CommentController@create'));

    Route::post('change/password',array('uses'=>'UserController@changePassword'));

    Route::post('filter/publication',array('uses'=>'PublicationController@filterPublication'));

    Route::post('sort/publication',array('uses'=>'PublicationController@sortPublication'));

    Route::post('profile/edit',array('uses'=>'UserController@editProfile'));

    Route::post('rate/headline',array('uses'=>'RatingController@rate'));




});

Route::get('test',array('uses'=>'HeadlineController@test'));

