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

Route::redirect('/', 'home');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::namespace('Auth')->group(function () {
	Route::get('teams', 'RegisterController@view')->name('teams');
	Route::get('companies', 'RegisterController@companies')->name('companies');
	Route::get('companies/register', 'RegisterController@company_add')->name('companies.register');
	Route::post('companies/register', 'RegisterController@company_store')->name('companies.store');
	Route::name('teams.')->group(function () {
	    Route::patch('teams', 'RegisterController@status')->name('status');
	    Route::get('profile', 'RegisterController@profile')->name('profile');
	});
	Route::name('profile.')->group(function () {
	    Route::put('profile/update', 'RegisterController@update')->name('update');
	    Route::post('profile', 'RegisterController@updatepassword')->name('updatepassword');
	    Route::post('profile/image', 'RegisterController@updateimage')->name('image');
	});
});

Route::post('leads/org', 'LeadController@org')->name('leads.org');
Route::post('leads/user', 'LeadController@user')->name('leads.user');
Route::get('customers', 'LeadController@customers')->name('leads.customers');
Route::post('leads/getmodal', 'LeadController@getmodal')->name('leads.getmodal');
Route::post('templates/module', 'TemplateController@module')->name('templates.module');
Route::post('templates/files', 'TemplateController@files')->name('templates.files');
Route::post('templates/deleteFile', 'TemplateController@deleteFile')->name('templates.deleteFile');
Route::post('templates/mail', 'TemplateController@mail')->name('templates.mail');
Route::post('templates/mailupdate', 'TemplateController@mailupdate')->name('templates.mailupdate');
Route::get('templates/{id}/detail', 'TemplateController@detail')->name('templates.detail');
Route::put('templates/{id}/status', 'TemplateController@status')->name('templates.status');
Route::put('templates/{id}/favorite', 'TemplateController@favorite')->name('templates.favorite');
Route::post('invoices/record', 'InvoiceController@record')->name('invoices.record');

Route::resource('forms', 'FormController');
Route::resource('organizations', 'OrganizationController');
Route::resource('leads', 'LeadController');
Route::resource('visas', 'VisaController');
Route::resource('socials', 'SocialController');
Route::resource('templates', 'TemplateController');
Route::resource('notes', 'NoteController');
Route::resource('activities', 'ActivityController');
Route::resource('tasks', 'TaskController');
Route::prefix('leads/{lead}')->group(function () {
	Route::resource('invoices', 'InvoiceController');
});

Route::resource('emaillogs', 'EmailLogController');
Route::resource('email-comments', 'EmailLogCommentController');
