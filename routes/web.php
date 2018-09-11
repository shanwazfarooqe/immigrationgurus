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

Route::get('imap', 'ImapController@index')->name('imap');

Route::get('gmail/{pageToken?}', 'GmailController@index')->name('gmail');
Route::delete('gmail/trash/{id}', 'GmailController@trash')->name('gmail.trash');
Route::delete('gmail/delete/{id}', 'GmailController@delete')->name('gmail.delete');
Route::delete('gmail/deleteAll', 'GmailController@deleteAll')->name('gmail.deleteAll');
Route::delete('gmail/trashAll', 'GmailController@trashAll')->name('gmail.trashAll');
Route::get('gmail/detail/{id}', 'GmailController@detail')->name('gmail.detail');

Route::get('/oauth/gmail', function (){
    return LaravelGmail::redirect();
});

Route::get('/oauth/gmail/callback', function (){
    LaravelGmail::makeToken();
    return redirect()->to('gmail');
});

Route::get('/oauth/gmail/logout', function (){
    LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/');
});

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

Route::post('forms/category', 'FormController@category')->name('forms.category');
Route::post('forms/customer', 'FormController@customer')->name('forms.customer');
Route::get('forms/{id}/view', 'FormController@view')->name('forms.view');
Route::get('forms/{id}/data', 'FormController@data')->name('forms.data');
Route::get('leads/{id}/application', 'LeadController@application')->name('leads.application');
Route::get('leads/{id}/decision', 'LeadController@decision')->name('leads.decision');
Route::get('leads/{id}/application/{form}/detail', 'LeadController@detail')->name('leads.detail');
Route::get('leads/{id}/{form}/view', 'LeadController@view')->name('leads.view');
Route::get('leads/{id}/{lead}/data', 'LeadController@data')->name('leads.data');
Route::post('leads/formdata', 'LeadController@formdata')->name('leads.formdata');
Route::post('leads/org', 'LeadController@org')->name('leads.org');
Route::post('leads/user', 'LeadController@user')->name('leads.user');
Route::post('leads/categories', 'LeadController@categories')->name('leads.categories');
Route::get('customers', 'LeadController@customers')->name('leads.customers');
Route::get('qualified-customers', 'LeadController@qualified')->name('leads.qualified');
Route::get('prequalified-customers', 'LeadController@prequalified')->name('leads.prequalified');
Route::post('leads/getmodal', 'LeadController@getmodal')->name('leads.getmodal');
Route::put('leads/{id}/status', 'LeadController@status')->name('leads.status');
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
Route::resource('orgnotes', 'OrgNoteController');
Route::resource('activities', 'ActivityController');
Route::resource('orgactivities', 'OrgActivityController');
Route::resource('tasks', 'TaskController');
Route::resource('orgtasks', 'OrgTaskController');
Route::prefix('leads/{lead}')->group(function () {
	Route::resource('invoices', 'InvoiceController');
});

Route::resource('emaillogs', 'EmailLogController');
Route::resource('decemaillogs', 'DecEmailLogController');
Route::resource('orgemaillogs', 'OrgEmailLogController');
Route::resource('email-comments', 'EmailLogCommentController');
Route::resource('decemail-comments', 'DecEmailLogCommentController');
Route::resource('orgemail-comments', 'OrgEmailLogCommentController');

//Customer Routes

Route::get('dashboard', 'CustomerController@index')->name('customer.index');