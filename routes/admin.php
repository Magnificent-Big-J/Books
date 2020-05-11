<?php

Route::post('/register-employee', 'Admin\AdminController@register');
Route::resource('category','Admin\CategoryController');
Route::resource('publisher','Admin\PublisherController');
Route::resource('author','Admin\AuthorController');
Route::resource('book','Admin\BookController');
