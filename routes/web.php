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



Route::get('/', 'JobController@index')->name('home'); 

// User
Route::get('/profile', 'UserController@index')->middleware('auth')->name('profile'); 
Route::get('/user/{slug}', 'UserController@show')->middleware('auth')->name('user.profile'); 
Route::get('/edit', 'UserController@edit')->middleware('auth')->name('user.edit');
Route::put('/edit', 'UserController@update')->middleware('auth')->name('user.update');
Route::put('/pic', 'UserController@profilePic')->middleware('auth')->name('user.pic');
Route::put('/resume', 'UserController@resume')->middleware('auth')->name('user.resume');
Route::post('/apply/{id}', 'UserController@apply')->middleware('auth')->name('user.apply');
Route::delete ('/apply/{id}', 'UserController@unapply')->middleware('auth')->name('user.unapply');

Auth::routes();

// Jobs
Route::get('/job/show/{id}', 'JobController@show')->name('job.show');
Route::get('/job/create', 'JobController@create')->middleware('auth')->name('job.create');
Route::delete('/delete/job/{id}', "JobController@destroy")->middleware('auth')->name('job.delete');
Route::post('/job/create', 'JobController@store')->middleware('auth')->name('job.store');
Route::get('/job/edit/{id}', 'JobController@edit')->middleware('auth')->name('job.edit');
Route::put('/job/edit/{id}', 'JobController@update')->middleware('auth')->name('job.update');
Route::get('/search', "JobController@controllSearch")->name('job.search');


// Admin
Route::get('/admin', 'AdminController@index')->middleware('role:admin')->name('admin');
Route::get('/admin/users', 'AdminController@users')->middleware('role:admin')->name('admin.users');
Route::get('/admin/jobs', 'AdminController@jobs')->middleware('role:admin')->name('admin.jobs');
Route::put('/admin/edit/{id}','AdminController@update')->middleware('role:admin')->name('admin.edit');
Route::delete('/admin/delete/{id}', 'AdminController@deleteUser')->middleware('role:admin')->name('admin.delete');
Route::delete('/admin/job/delete/{id}', 'AdminController@deleteJob')->middleware('role:admin')->name('admin.job.delete');
Route::get('/admin/search', 'AdminController@search')->middleware('role:admin')->name('admin.search');


// Root
Route::get('/root', 'RootController@index')->middleware('role:root')->name('root');
Route::get('/root/users', 'RootController@users')->middleware('role:root')->name('root.users');
Route::get('/root/jobs', 'RootController@jobs')->middleware('role:root')->name('root.jobs');
Route::put('/root/edit/{id}','RootController@update')->middleware('role:root')->name('root.edit');
Route::delete('/root/delete/{id}', 'RootController@deleteUser')->middleware('role:root')->name('root.delete');
Route::delete('/root/job/delete/{id}', 'RootController@deleteJob')->middleware('role:root')->name('root.job.delete');
Route::get('/root/search', 'RootController@search')->middleware('role:root')->name('root.search');



// Not found
Route::fallback(function(){
    return view('404');
});

