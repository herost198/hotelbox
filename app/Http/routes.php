<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['prefix'=>'/'],function(){



    Route::get('/','HomeController@index')->name('home');

    Route::get('/login','Auth\Admin\LoginController@login')->name('auth.login');
    Route::post('/login','Auth\Admin\LoginController@loginAdmin');
    Route::post('/logout','Auth\Admin\LoginController@logout')->name('auth.logout');

    Route::get('/changePassword/{id}','AdminController@changePassword');
    Route::post('/changePassword/{id}','AdminController@submitChangePassword');

    /*
     * ----------- Quản Lý User  (ADMIN)
     * */
    Route::group(['prefix'=>'hotel','middleware'=>'check'], function(){
        Route::get('/','HotelController@index')->name('hotel.index');
//        Route::get('/search','HotelController@search');
        Route::get('/create','HotelController@create');
        Route::get('/delete/{id}','HotelController@destroy');
        Route::get('/edit/{id}','HotelController@edit');

        Route::post('/create','HotelController@stored');
        Route::post('/edit/{id}','HotelController@updated');

        Route::get('/resetpw/{id}','HotelController@resetpw');

    });
    /*
     * -------- Khai báo Cụm Phòng   (ADMIN và USER)
     * */
    Route::group(['prefix'=>'cumphong' ,'middleware'=>'auth:admin' ],function(){
        /*
         * ------------       Admin
         * */

        Route::get('/','CumPhongController@IndexAdmin')->middleware('check');
        Route::get('/create','CumPhongController@createAdmin');
        Route::get('/edit/{id}','CumPhongController@editAdmin');
        Route::get('/delete/{id}','CumPhongController@destroyAdmin');

        Route::post('/create','CumPhongController@storedAdmin');
        Route::post('/edit/{id}','CumPhongController@updatedAdmin');

        /*
         * ------------       USER
         * */

        Route::get('/{id}','CumPhongController@index');
        Route::get('/{id}/create','CumPhongController@create');
        Route::get('/{id}/edit/{idCp}','CumPhongController@edit');
        Route::get('/{id}/delete/{idCp}','CumPhongController@destroy');

        Route::post('/{id}/create','CumPhongController@stored');
        Route::post('/{id}/edit/{idCp}','CumPhongController@updated');
    });




    /*
     * --------    QUẢN LÝ PHÒNG (ADMIN và USER)
     * */

    Route::group(['prefix'=>'phong' ,'middleware'=>'auth:admin'], function (){
        /*
         * ------------       Admin
         * */

        Route::get('/','PhongController@indexAdmin')->middleware('check');
        Route::get('/create','PhongController@createAdmin');
        Route::get('/edit/{id}','PhongController@editAdmin');
        Route::get('/delete/{id}','PhongController@destroyAdmin');

        Route::post('/create','PhongController@storedAdmin');
        Route::post('/edit/{id}','PhongController@updatedAdmin');

        /*
         * ------------       USER
         * */

        Route::get('/{id}','PhongController@index');
        Route::get('/{id}/create','PhongController@create');
        Route::get('/{id}/edit/{room}','PhongController@edit');
        Route::get('/{id}/delete/{room}','PhongController@destroy');

        Route::post('/{id}/create','PhongController@stored');
        Route::post('/{id}/edit/{room}','PhongController@updated');

    });

    /*
     * -------- QUẢN LÝ BOX TV  (ADMIN và USER)
     * */

    Route::group(['prefix'=>'box','middleware'=>'auth:admin'],function(){
        /*
         *  -------------- ADMIN
         * */
        Route::get('/','BoxTvController@indexAdmin');

        Route::get('/create','BoxTvController@create');
        Route::get('/edit/{id}','BoxTvController@editAdmin');
        Route::get('/delete/{id}','BoxTvController@destroy');

        Route::post('/create','BoxTvController@stored');
        Route::post('/edit/{id}','BoxTvController@updatedAdmin');

//        Route::get('/creates','BoxTvController@creates');
//        Route::post('/creates','BoxTvController@manyBox');
        /*
         * ------------       USER
         * */

        Route::get('/{id}','BoxTvController@index');
        Route::get('/{id}/edit/{box}','BoxTvController@edit');

        Route::post('/{id}/edit/{box}','BoxTvController@updated');


    });

    /*
     * --------- Dùng AJAX ĐỂ LOAD DỮ LIỆU    (ADMIN)
     * */
    Route::group(['prefix'=>'ajax','middleware'=>'auth:admin'],function(){
        Route::get("cumphong/{hotel_id}",'AjaxController@getCumPhong');
        Route::get("phong/{cumphong_id}",'AjaxController@getPhong');

        Route::get("phong1/{cumphong_id}",'AjaxController@getPhong1');

        Route::get("cumphong/{hotel_id}/{cumphong_id}",'AjaxController@getCP');
        Route::get("phong/{cumphong_id}/{phong_id}",'AjaxController@getP');

        Route::get('box/{phong_id}','AjaxController@getBox');

        Route::get("image/{hotel_id}",'AjaxController@getImage');
    });


    /*
     * ------------- QUẢN LÝ THÔNG BÁO    (ADMIN và USER)
     * */

    Route::group(['prefix'=>'notification','middleware'=>'auth:admin'],function(){
        // index of admin
        Route::get('/','NotificationController@IndexAdmin')->middleware('check');
        Route::get('/edit','NotificationController@editAdmin');
//        Route::get('/delete/{id}','NotificationController@destroyAdmin');
        Route::post('/edit','NotificationController@updatedAdmin');
        /*
        * ------------       USER
        * */
        Route::get('/{id}','NotificationController@index');
        Route::get('/{id}/edit','NotificationController@edit');
//        Route::get('/{id}/delete/{room}','NotificationController@destroy');
        Route::post('/{id}/edit','NotificationController@updated');

    });

    /*
     * -------------- Quản lÝ BackGround (ADMIN và USER)
     * */

    Route::group(['prefix'=>'background','middleware'=>'auth:admin'],function(){
        /*
         * ------------       ADMIN
         * */
        Route::get('/','BackgroundController@indexAdmin')->middleware('check');
//        Route::get('/create','BackgroundController@createAdmin');

        Route::get('/edit/{id}','BackgroundController@editAdmin')->name('edit.background');

//        Route::post('/create','BackgroundController@storedAdmin');

        Route::post('/edit/{id}','BackgroundController@updatedAdmin');
        /*
         * ------------       USER
         * */
//        Route::get('/edit/{id}','BackgroundController@edit');

//        Route::post('/edit/{id}','BackgroundController@updated');
    });

    /*
     * ------------- QUẢN LÝ SERVICE     (ADMIN và USER)
     * */
    Route::group(['prefix'=>'service','middleware'=>'auth:admin'],function(){
        /*
         * ------------       ADMIN
         * */
        Route::get('/','ServiceController@indexAdmin')->middleware('check');
        Route::get('/create','ServiceController@createAdmin');
        Route::get('/edit/{id}','ServiceController@editAdmin');
        Route::get('/delete/{id}','ServiceController@destroyAdmin');

        Route::post('/create','ServiceController@storedAdmin');
        Route::post('/edit/{id}','ServiceController@updatedAdmin');
        /*
         * ------------       USER
         * */
        Route::get('/{id}','ServiceController@index');
        Route::get('/{id}/create','ServiceController@create');
        Route::get('/{id}/edit/{idS}','ServiceController@edit');
        Route::get('/{id}/delete/{idS}','ServiceController@destroy');

        Route::post('/{id}/create','ServiceController@stored');
        Route::post('/{id}/edit/{idS}','ServiceController@updated');
    });

    /*
         * ------------- QUẢN LÝ POP UP     (ADMIN và USER)
         * */

    Route::group(['prefix'=>'popup' ,'middleware'=>'auth:admin'], function (){
        /*
         * ------------       Admin
         * */

        Route::get('/','popUpController@indexAdmin')->middleware('check');
        Route::get('/create','popUpController@createAdmin');

        Route::get('/edit/{id}','popUpController@editAdmin');

        Route::post('/create','popUpController@storedAdmin');

        Route::post('/edit/{id}','popUpController@updatedAdmin');

    });

    Route::group(['prefix'=>'logo','middleware'=>'auth:admin'],function(){

        Route::get('/edit/{id}','LogoController@edit');

        Route::post('/edit/{id}','LogoController@updated');
    });
});

Route::group(['prefix'=>'api'],function(){
	
	Route::get('getPopUp', function(){
		include(app_path().'/getPopUp.php');
	});
	
	Route::get('getApp', function(){
		include(app_path().'/getApp.php');
	});

    Route::get('getBackground', function(){
        include(app_path().'/getBackground.php');
    });
    Route::get('getHotelInformation', function(){
        include(app_path().'/getHotelInformation.php');
    });
    Route::get('getServices', function(){
        include(app_path().'/getServices.php');
    });
    Route::get('getVersion', function(){
        include(app_path().'/getVersion.php');
    });

    Route::post('/user/login','API\UserController@login');

    Route::post('user/changePassword','API\UserController@changePassword');

//Route::get('user/getHotelInformation','API\UserController@getHotelInformation');
//    Route::get('/user/getBackground', 'API\UserController@getBackground');

    Route::get('user/getService','API\UserController@getService');
    Route::post('service/delete','API\UserController@destroyService');

    Route::get('hotel/cumphong','API\HotelController@getCPhong');

    Route::get('hotel/phong','API\HotelController@getPhong');

    Route::get('hotel/getListRoom','API\HotelController@getListRoomByIdCumPhong');

    Route::post('cumphong/create','API\HotelController@storedCumPhong');

    Route::post('phong/create','API\HotelController@storedPhong');

    Route::post('phong/update','API\HotelController@updatedPhong');

    Route::get('user/getBackground','API\HotelController@getBackground');

    Route::post('background/delete','API\HotelController@deletePhoto');

    Route::post('background/upload','API\HotelController@addPhoto');

    Route::post('cumphong/update','API\HotelController@updatedCumPhong');

    Route::post('cumphong/delete','API\HotelController@destroyedCumPhong');

    Route::post('phong/delete','API\HotelController@destroyedPhong');

    Route::get('user/getBox','API\HotelController@getBox');

    Route::post('service/edit','API\HotelController@updatedService');

    Route::post('user/changeAvatar','API\UserController@changeAvatar');


    Route::get('user/getPopup','API\HotelController@getPopup');

    Route::post('popup/delete','API\HotelController@deletePhotoPopup');

    Route::post('popup/upload','API\HotelController@addPhotoPopup');

    Route::post('popup/edit','API\HotelController@editPopup');
});

