<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// dd(Request::segment(1));



//Route::group(['middleware' => ['web']], function ()
//{
//
//});
// Route::get('front', 'frontController@home');
// Route::post('front','frontController@home');
Route::group(['middleware' => ['web']], function ()
{
	Route::group(['middleware' => ['auth'] ], function ()
	{
		Route::get('contact', ['as' => 'contact', 'uses' => 'UserController@showUserContact']);
		Route::post('contactUpd', ['as' => 'contactUpd', 'uses' => 'UserController@editUserContact']);
		Route::get('addresses', ['as' => 'addresses', 'uses' => 'UserController@showUserAddresses']);
		Route::post('addressesUpd', ['as' => 'addressesUpd', 'uses' => 'UserController@editUserAddresses']);
		Route::post('addressesAdd', ['as' => 'addressesAdd', 'uses' => 'UserController@addUserAddresses']);
		Route::get('terms', ['as' => 'terms', 'uses' => 'UserController@showUserTerms']);
		Route::post('terms', ['as' => 'terms', 'uses' => 'UserController@editUserTerms']);
		Route::get('passwd', ['as' => 'passwd', 'uses' => 'UserController@showUserPasswd']);
		Route::post('passwd', ['as' => 'passwd', 'uses' => 'UserController@editUserPasswd']);
	});
    Route::get('/', function ()
    {
        return view('welcome');
    });


    // Route::get('no-admin', function ()
    // {
    //     return view('auth.no-admin');
    // });

    Route::get('cron/hourly', ['as' => 'cron.hourly', 'uses' => 'CronController@hourlyRun']);

    Route::get('request-form/{encodedId}', ['as' => 'request-form', 'uses' => 'RequestController@requestForm']);
    Route::put('request-form/{encodedId}', ['as' => 'request-form.feedback-update', 'uses' => 'RequestController@feedbackUpdate']);

    Route::get('request-ask-for-rating/{encodedId}', ['as' => 'request-ask-for-rating', 'uses' => 'RatingController@ratingForm']);
    Route::put('request-ask-for-rating/{encodedId}', ['as' => 'request-ask-for-rating-update', 'uses' => 'RatingController@ratingFormUpdate']);
    Route::get('request-ask-for-rating-success/{encodedId}', ['as' => 'request-ask-for-rating-success', 'uses' => 'RatingController@ratingFormSuccess']);


    Route::get('category/{id?}/get-children', ['as' => 'category.get-children', 'uses' => 'CategoryController@getChildren']);
    Route::get('category//get-children', ['as' => 'category.get-children-empty', 'uses' => 'CategoryController@getChildren']);


    Route::get('country/{id}/get-cities', ['as' => 'country.get-cities', 'uses' => 'CountryController@getCities']);

    Route::auth();

    Route::group(['middleware' => ['auth', 'admin'] ], function ()
    {

        Route::get('index', ['as' => 'index', 'uses' => 'HomeController@index']);
        Route::get('/', ['as' => 'home', 'uses' => 'ContactController@index']);
				Route::get('trans', ['as' => 'trans', 'uses' => 'HomeController@trans']);
				Route::post('trans', ['as' => 'trans', 'uses' => 'HomeController@AddTrans']);
				Route::post('transUpdate', ['as' => 'transUpdate', 'uses' => 'HomeController@updateTrans']);

        Route::get('contacts/create-request', ['as' => 'contacts.create-request', 'uses' => 'RequestController@create']);

        Route::get('contacts/{contactId}/send-mail-create', ['as' => 'contacts.send-mail-create', 'uses' => 'ContactController@sendMailCreate']);
        Route::post('contacts/{contactId}/send-mail-send', ['as' => 'contacts.send-mail-send', 'uses' => 'ContactController@sendMailSend']);
        Route::post('contacts/{contactId}/store-comment', ['as' => 'contacts.store-comment', 'uses' => 'ContactController@commentStore']);
//
        Route::get('contacts/create-ask-request/{contactId}', ['as' => 'contacts.create-ask-request', 'uses' => 'RequestController@createAskRequest']);

        Route::post('requests/store', ['as' => 'requests.store', 'uses' => 'RequestController@store']);
        Route::post('requests/storeArray', ['as' => 'requests.storeArray', 'uses' => 'RequestController@storeArray']);
        Route::get('requests/storeArray/success', ['as' => 'requests.storeArray.success', 'uses' => 'RequestController@storeArraySuccess']);


        Route::get('requests/', ['as' => 'requests.index', 'uses' => 'RequestController@index']);
        Route::get('requests/create', ['as' => 'requests.create', 'uses' => 'RequestController@create']);
        Route::get('requests/{id}/edit', ['as' => 'requests.edit', 'uses' => 'RequestController@edit']);
        Route::get('requests/{id}', ['as' => 'requests.show', 'uses' => 'RequestController@show']);

        Route::get('requests/{id}/admin-process-view', ['as' => 'requests.admin-process-view', 'uses' => 'RequestController@adminProcessView']);
        Route::put('requests/{id}/admin-process-view/{contactId}', ['as' => 'requests.admin-process-save', 'uses' => 'RequestController@adminProcessSave']);
        Route::get('requests/{id}/admin-process-view/reject', ['as' => 'requests.admin-process-reject', 'uses' => 'RequestController@adminProcessReject']);


        Route::get('request/{id}/delete', ['as' => 'request.delete', 'uses' => 'RequestController@destroy']);

        Route::resource('contacts', 'ContactController');
        Route::get('contact/{id}/delete', ['as' => 'contact.delete', 'uses' => 'ContactController@destroy']);

        Route::resource('mainobjects', 'MainobjectController');
        Route::get('mainobject/{id}/delete', ['as' => 'mainobject.delete', 'uses' => 'MainobjectController@destroy']);

        Route::resource('categories', 'CategoryController');
        Route::get('category/{id}/delete', ['as' => 'category.delete', 'uses' => 'CategoryController@destroy']);


        Route::resource('stages', 'StageController');
        Route::get('stage/{id}/delete', ['as' => 'stage.delete', 'uses' => 'StageController@destroy']);
        Route::put('stage/{id}/updatecontactdetails', ['as' => 'stage.updatecontactdetails', 'uses' => 'StageController@updateContactDetails']);

        Route::resource('contactdetails', 'ContactDetailController');
        Route::get('contactdetail/{id}/delete', ['as' => 'contactdetail.delete', 'uses' => 'ContactDetailController@destroy']);


        Route::resource('ratings', 'RatingController');


        Route::post('rating/ask-for-rating', ['as' => 'rating.ask-for-rating', 'uses' => 'RatingController@askForRating']);
        Route::get('rating/ask-for-rating/success', ['as' => 'rating.ask-for-rating.success', 'uses' => 'RatingController@askForRatingSuccess']);

        Route::get('rating/admin-do-rating/{id}', ['as' => 'rating.admin-do-rating', 'uses' => 'RatingController@adminDoRating']);
        Route::put('rating/admin-do-rating/{id}/update', ['as' => 'rating.admin-do-rating-update', 'uses' => 'RatingController@adminDoRatingUpdate']);

        Route::get('rating/{id}/delete', ['as' => 'rating.delete', 'uses' => 'RatingController@destroy']);
        Route::get('rating/{id}/restore', ['as' => 'rating.restore', 'uses' => 'RatingController@unDestroy']);


        Route::resource('contactdetailoptions', 'ContactDetailOptionController');

        Route::resource('countries', 'CountryController');
        Route::get('country/{id}/delete', ['as' => 'country.delete', 'uses' => 'CountryController@destroy']);

        Route::resource('cities', 'CityController');
        Route::get('city/{id}/delete', ['as' => 'city.delete', 'uses' => 'CityController@destroy']);


        Route::resource('users', 'UserController');
        Route::get('user/{id}/delete', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
        Route::get('user/{encriptedId}/set-admin-role', ['as' => 'user.setAdminRole', 'uses' => 'UserController@setAdminRole']);


        /* ajax */

        Route::get('ajax/get-contacts-emails', ['as' => 'ajax.get-contacts-emais', 'uses' => 'AjaxController@getContactsEmails']);
        Route::get('ajax/get-contacts-emails-phones-tags', ['as' => 'ajax.get-contacts-emais-phones-tags', 'uses' => 'AjaxController@getContactsEmailsPhonesTags']);
        Route::get('ajax/get-contacts-tags', ['as' => 'ajax.get-contacts-tags', 'uses' => 'AjaxController@getContactsTags']);

        /* test */




    });


});
