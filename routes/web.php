<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

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

if (isset ($_SERVER['HTTP_HOST'])) {
	$http_host = $_SERVER['HTTP_HOST'];
	if ($http_host && strpos($http_host, 'digitracker24.com') === false && strpos($http_host, 'digitracker24.dev') === false && $http_host != "digilinks24.com" && $http_host != "www.digilinks24.com" && $http_host != "digilinks24.dev" && $http_host != "www.digilinks24.dev" && $http_host != "localhost" && $http_host != "127.0.0.2") {	
		Route::get('/{text_link}', function($text_link, Request $request) {
			$account = "";
			$result = @dns_get_record($_SERVER['HTTP_HOST'], DNS_CNAME);
			if (count($result) > 0) {
				for ($i=0;$i<count($result);$i++) {
					if ($result[$i]['target']) {
						$account = str_replace(".digitracker24.com", "",$result[$i]['target']);
						break;
					}
				}
			}

			return app('App\Http\Controllers\SubDomainController')->index($text_link, $account, $request);

		});
	}
}



Route::group(array('domain' => '{account}.digitracker24.com'), function() {
    Route::get('/', function($account, Request $request) {
		return app('App\Http\Controllers\SubDomainController')->index(false, $account, $request);
    });
	Route::get('/{text_link}', function($account, $text_link, Request $request) {
		return app('App\Http\Controllers\SubDomainController')->index($text_link, $account, $request);
    });
});
Route::group(array('domain' => '{account}.digitracker24.dev'), function() {
    Route::get('/', function($account, Request $request) {
		return app('App\Http\Controllers\SubDomainController')->index(false, $account, $request);
    });
	Route::get('/{text_link}', function($account, $text_link, Request $request) {
		return app('App\Http\Controllers\SubDomainController')->index($text_link, $account, $request);
    });
});

//welcome page
Route::get('/', function () {
	//return view('auth.login');
	return redirect(route('login'));
})->name('welcome');

//member
Route::get('/member', function () {
	if ( !Auth::check() ) {
		return view('auth.login');
	} else if ( isUser() ) {
		return redirect(route('user_dashboard'));
	} else if ( isAdmin() ) {
		return redirect(route('admin_dashboard'));
	}
})->name('member');

//login, registration ...
Auth::routes(['verify' => true]);

//admin/users pages
Route::middleware(['verified', 'auth', 'publish'])->group(function () {
    
	Route::get('/ajax', 'AjaxController@index')->name('ajax');
	Route::get('/user/profile', 'UserController@UserProfile')->name('user.profile');
	Route::post('/user/profile/update', 'UserController@UserProfileUpdate')->name('user.profileUpdate');
	
	//admin
	Route::middleware(['admin'])->group(function () {
		
		Route::get('/admin', function () {
			return redirect(route('users.list'));
		})->name('admin_dashboard');

		//users
		Route::get('/users', 'UserController@UsersList')->name('users.list');
		Route::get('/users/add', 'UserController@UsersAdd')->name('users.add');
		Route::get('/users/edit/{id}', 'UserController@UsersEdit')->name('users.edit');
		Route::post('/users/edit/update', 'UserController@UsersEditUpdate')->name('users.update');
	});
	
	//users
	Route::middleware(['user'])->group(function () {
		
		Route::get('/home', function () {
			return view('home');
		})->name('home');
		
		Route::get('/user', function () {
			return view('home');
		})->name('user_dashboard');

		//links
		Route::get('/links', 'LinksController@List')->name('links.list');
		Route::get('/links/add', 'LinksController@Add')->name('links.add');
		Route::get('/links/edit/{id}', 'LinksController@Edit')->name('links.edit');
		Route::post('/links/edit/update', 'LinksController@Update')->name('links.update');
		Route::get('/links/delete/{id}', 'LinksController@Delete')->name('links.delete');
		//stats
		Route::get('/stats/{id}/{type}', 'StatsController@List')->name('stats.list');
		//vendors
		Route::get('/vendors', 'VendorsController@List')->name('vendors.list');
		Route::get('/vendors/add', 'VendorsController@Add')->name('vendors.add');
		Route::get('/vendors/edit/{id}', 'VendorsController@Edit')->name('vendors.edit');
		Route::post('/vendors/edit/update', 'VendorsController@Update')->name('vendors.update');
		Route::get('/vendors/delete/{id}', 'VendorsController@Delete')->name('vendors.delete');
		//groups
		Route::get('/groups', 'GroupsController@List')->name('groups.list');
		Route::get('/groups/add', 'GroupsController@Add')->name('groups.add');
		Route::get('/groups/edit/{id}', 'GroupsController@Edit')->name('groups.edit');
		Route::post('/groups/edit/update', 'GroupsController@Update')->name('groups.update');
		Route::get('/groups/delete/{id}', 'GroupsController@Delete')->name('groups.delete');
		//rpixels
		Route::get('/rpixels', 'RpixelsController@List')->name('rpixels.list');
		Route::get('/rpixels/add', 'RpixelsController@Add')->name('rpixels.add');
		Route::get('/rpixels/edit/{id}', 'RpixelsController@Edit')->name('rpixels.edit');
		Route::post('/rpixels/edit/update', 'RpixelsController@Update')->name('rpixels.update');
		Route::get('/rpixels/delete/{id}', 'RpixelsController@Delete')->name('rpixels.delete');
		//domains
		Route::get('/domains', 'DomainsController@List')->name('domains.list');
		Route::get('/domains/add', 'DomainsController@Add')->name('domains.add');
		Route::get('/domains/edit/{id}', 'DomainsController@Edit')->name('domains.edit');
		Route::post('/domains/edit/update', 'DomainsController@Update')->name('domains.update');
		Route::get('/domains/delete/{id}', 'DomainsController@Delete')->name('domains.delete');
		Route::get('/domains/download/{id}/{type}', 'DomainsController@Download')->name('domains.download');
		//pages
		Route::get('/pages', 'PagesController@List')->name('pages.list');
		Route::get('/pages/add', 'PagesController@Add')->name('pages.add');
		Route::get('/pages/edit/{id}', 'PagesController@Edit')->name('pages.edit');
		Route::post('/pages/edit/update', 'PagesController@Update')->name('pages.update');
		Route::get('/pages/delete/{id}', 'PagesController@Delete')->name('pages.delete');
		Route::post('/pages/edit/updatedef', 'PagesController@UpdateDef')->name('pages.updatedef');
		
		//video library
		Route::get('/video-library', function () {
			return view('other.videolibrary');
		})->name('other.videolibrary');
	});

});

