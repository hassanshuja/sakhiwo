<?php

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


/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users
    Route::get('users', 'UserController@index')->name('users');
    Route::post('create', 'UserController@create')->name('create');
    Route::get('registerForm', 'UserController@registerForm')->name('registerForm');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::get('users/{user}/destroy', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');
  //QuotesController functions
    Route::get('uploadQuote', 'QuotesController@index')->name('uploadQuote');
    Route::post('importExcelForUpload', 'QuotesController@importExcelForUpload')->name('importExcelForUpload');
    Route::get('edit/{id}', 'QuotesController@editQuote')->name('edit');
    Route::get('uploads/{id}/deleteUploads', 'QuotesController@deleteUploads')->name('uploads.deleteUploads');
    Route::get('getQuotes', 'QuotesController@getQuotes')->name('getQuotes');
    //Route::post('search', 'QuotesController@searchquotes')->name('search');

    Route::match(['get', 'post'], 'search',[
        'as' => 'search',
        'uses' => 'QuotesController@searchquotes' ]);
    Route::post('capturing', 'QuotesController@capturing')->name('capturing');
    // Route::get('capturing', 'QuotesController@capturing')->name('capturing');
    Route::post('getfacility', 'QuotesController@getfacility')->name('getfacility');
    Route::get('newCapturing', 'QuotesController@newCapturing')->name('newCapturing');
    Route::get('reports', 'QuotesController@reports')->name('reports');
    Route::get('vetting_reports', 'QuotesController@vetting_reports')->name('vetting_reports');
    //Route::post('search_vetting', 'QuotesController@search_vetting')->name('search_vetting');
    Route::match(['get', 'post'], 'search_vetting',[
        'as' => 'search_vetting',
        'uses' => 'QuotesController@search_vetting' ]);


   // Route::get('search_dfmiy', 'QuotesController@search_dfmiy')->name('search_dfmiy');

    Route::match(['get', 'post'], 'search_dfmiy',[
        'as' => 'search_dfmiy',
        'uses' => 'QuotesController@search_dfmiy' ]);


    Route::get('search_total', 'QuotesController@search_total')->name('search_total');
    Route::get('status_change', 'QuotesController@status_change')->name('status_change');
    
    Route::post('downloadpdf', 'QuotesController@downloadpdf')->name('downloadpdf');
    Route::post('downloadxlsx', 'QuotesController@downloadxlsx')->name('downloadxlsx');
    Route::post('downloadStatusxlsx', 'QuotesController@downloadStatusxlsx')->name('downloadStatusxlsx');
   // Route::post('search_filter_dfm', 'QuotesController@search_filter_dfm')->name('search_filter_dfm');

     Route::match(['get', 'post'], 'search_filter_dfm',[
        'as' => 'search_filter_dfm',
        'uses' => 'QuotesController@search_filter_dfm' ]);

    Route::post('downloadDFMxlsx', 'QuotesController@downloadDFMxlsx')->name('downloadDFMxlsx');
    Route::get('excel_total', 'QuotesController@excel_total')->name('excel_total');
    Route::post('download_total_excel', 'QuotesController@download_total_excel')->name('download_total_excel');
    Route::get('charts', 'QuotesController@charts')->name('charts');
    Route::get('viewfacilities', 'SettingsController@facility_view')->name('viewfacilities');
    Route::get('editfacility/{id}', 'SettingsController@facility_edit')->name('editfacility');
    //FOR Facility Settings
    Route::post('updatefacility', 'SettingsController@facility_update')->name('updatefacility');
    Route::get('addfacility', 'SettingsController@new_facility')->name('addfacility');
    Route::post('addfacility', 'SettingsController@add_facility')->name('addfacility');
    Route::get('deleteFacility/{id}', 'SettingsController@deleteFacility')->name('deleteFacility');

    //For DFM SETTINGS
    Route::get('viewdfm', 'SettingsController@dfm_view')->name('viewdfm');
    Route::get('editdfm/{id}', 'SettingsController@dfm_edit')->name('editdfm');
    Route::post('updateDFM', 'SettingsController@DFM_update')->name('updateDFM');
    Route::get('addDFM', 'SettingsController@new_DFM')->name('addDFM');
    Route::post('addDFM', 'SettingsController@add_DFM')->name('addDFM');
    Route::get('deleteDFM/{id}', 'SettingsController@deleteDFM')->name('deleteDFM');


    // FOR Districts Settings
    Route::get('viewdistricts', 'SettingsController@viewDistricts')->name('viewdistricts');
    Route::post('editdistrict', 'SettingsController@editDistrict')->name('editdistrict');
    Route::get('deleteDistrict/{id}','SettingsController@deleteDistrict')->name('deleteDistrict');
    Route::post('add_district','SettingsController@add_district')->name('add_district');
    
    // FOR SUB Districts Settings
    Route::get('viewsubdistricts', 'SettingsController@viewSubDistricts')->name('viewsubdistricts');
    Route::post('editsubdistrict', 'SettingsController@editsubDistrict')->name('editsubdistrict');
    Route::get('deletesubDistrict/{id}','SettingsController@deletesubDistrict')->name('deletesubDistrict');
    Route::post('add_subdistrict','SettingsController@add_subdistrict')->name('add_subdistrict');

    // FOR Contractors Settings
    Route::get('viewContractor', 'SettingsController@viewContractor')->name('viewContractor');
    Route::post('editContractor', 'SettingsController@editContractor')->name('editContractor');
    Route::get('deleteContractor/{id}','SettingsController@deleteContractor')->name('deleteContractor');
    Route::post('addContractor','SettingsController@addContractor')->name('addContractor');
});


Route::get('/', 'HomeController@index');

/**
 * Membership
 */
Route::group(['as' => 'protection.'], function () {
    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});
