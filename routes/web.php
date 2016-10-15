<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', 'PagesController@home');
Route::get('page/about', 'PagesController@about');
Route::get('page/biz-owner', 'PagesController@businessOwners');
Route::get('page/add-place', 'PagesController@addPlace');
Route::post('page/add-place', 'PagesController@storePlace');
Route::get('page/contact-us', 'PagesController@contact');
Route::post('page/contact-us', 'PagesController@storeContact');
//Route::get('page/privacy', 'PagesController@privacy');  I really miss you
//Route::get('page/terms', 'PagesController@privacy');  I really miss you too
Route::get('page/policies', 'PagesController@policies');
Route::get('page/guidelines', 'PagesController@guidelines');
Route::get('page/cookie-policy', 'PagesController@cookiePolicy');
Route::post('page/feedback', 'PagesController@feedback');
// Authentication routes...
Auth::routes();
Route::group(['middleware' => 'guest'], function ()
{
	Route::get('auth/confirm/{token}', 'Auth\LoginController@confirmEmail');
});
/*Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
Route::group(['middleware' => 'guest'], function ()
{
	Route::get('auth/confirm/{token}', 'Auth\AuthController@confirmEmail');
});
*/
/*
			*** Social media logins for gamification is remained for next updates ***
Route::get('auth/instagram', 'InstagramOauthController@redirectProvider');
Route::get('auth/instagram/callback', 'InstagramOauthController@handleProviderCallback');
Route::get('auth/twitter', 'TwitterOauthController@redirectProvider');
Route::get('auth/twitter/callback', 'TwitterOauthController@handleProviderCallback');
Route::get('auth/facebook', 'FacebookOauthController@redirectProvider');
Route::get('auth/facebook/callback', 'FacebookOauthController@handleProviderCallback');
 */
Route::get('auth/google', 'GoogleOauthController@redirectProvider');
Route::get('auth/google/callback', 'GoogleOauthController@handleProviderCallback');

Route::get('search/venue/{venueName}', 'SearchesController@searchVenue');
Route::get('search/city/{cityName}', 'SearchesController@searchCity');
//Users routes...
Route::get('/@{username}', 'UsersController@show');
Route::get('user/{username}/followers', 'UsersController@followers');
Route::get('user/{username}/photos', 'UsersController@photos');
Route::get('user/{username}/reviews', 'UsersController@reviews');

//    Registered users
Route::group(['middleware' => 'auth'], function ()
{
	Route::post('user/follow/{id}', 'FollowersController@store');
	Route::delete('user/unfollow/{id}', 'FollowersController@destroy');
	Route::post('user/add-avatar', 'UsersController@addProfilePhoto');
	Route::post('user/add-venue-photos/{venueSlug}', 'UsersController@addVenuePhoto');
	Route::post('user/review/add', 'UsersController@addReview');
	Route::delete('user/review/delete/{reviewId}', 'UsersController@deleteReview');
	Route::get('user/settings', 'UsersController@settings');
	Route::patch('user/settings', 'UsersController@updateSettings');
	Route::get('biz-owner', 'UsersController@venues');
});
//City routes...
Route::get('city/{citySlug}', 'CitiesController@index');
Route::get('city/set-city/{citySlug}', 'CitiesController@setCity');
Route::get('city/{citySlug}/cuisine/all', 'CitiesController@allCuisines');
Route::get('city/{citySlug}/cuisine/{cuisine}', 'CitiesController@allVenuesCuisine');

//Venues
Route::get('venue/{venueSlug}', 'VenuesController@show');
Route::get('venue/{venueSlug}/photos', 'VenuesController@photos');
Route::get('venue/{venueSlug}/menu', 'VenuesController@menu');

//Photo routes...
Route::get('photo/city/{citySlug}', 'PhotosController@getCityPhoto');
Route::get('photo/cuisine/{cuisineSlug}', 'PhotosController@getCuisinePhoto');
Route::get('photo/venue/{venueSlug}', 'PhotosController@getVenuePhoto');
Route::get('photo/user/{username}', 'PhotosController@getUserAvatar');
Route::get('photo/{filename}', 'PhotosController@getPhotoByFilename');
Route::get('photo/collection/{collectionSlug}', 'PhotosController@getCollectionPhoto');

//Owner Role
Route::group(['prefix' => 'dep/admin', 'namespace' => 'Admin'], function ()
{
	Route::group(['middleware' => 'manage-user'], function ()
	{
		Route::get('user/all', 'UsersController@all');
		Route::get('user/search/{userData}', 'UsersController@getSearchEmail');
		Route::post('user/search', 'UsersController@postSearchEmail');
		Route::get('user/{userSlug}', 'UsersController@show');
		Route::post('user/toggle-ban/{userId}', 'UsersController@toggleBan');
	});
	Route::group(['middleware' => 'manage-city'], function ()
	{
		Route::get('city/all', 'CitiesController@all');
		Route::post('city/toggle-status/{cityId}', 'CitiesController@toggleStatus');
		Route::get('city/create', 'CitiesController@create');
		Route::post('city/create', 'CitiesController@store');
		Route::get('city/{citySlug}', 'CitiesController@show');
		Route::post('city/{citySlug}/add-photo', 'CitiesController@addCityPhoto');
		Route::patch("city/{citySlug}", 'CitiesController@update');
	});
	Route::group(['middleware' => 'manage-venue'], function ()
	{
		Route::get('venue/all', 'VenuesController@all');
		Route::get('venue/pending', 'VenuesController@pending');
		Route::post('venue/assign-user', 'VenuesController@assignUser');
		Route::post('venue/change-status', 'VenuesController@changeStatus');
		Route::get('venue/{venueSlug}/json', "VenuesController@json");
		Route::post('venue/{venueSlug}/upload-photos', "VenuesController@uploadPhotos");
		Route::get('venue/add', 'VenuesController@create');
		Route::post('venue/add', 'VenuesController@store');
		Route::get('update', 'VenuesController@updateVenuesMainPhoto');
	});
	Route::get('owner', 'AdminController@index');

	Route::group(['middleware' => 'manage-role'], function ()
	{
		Route::get('role/all', 'RolesController@all');
		Route::get('role/create', 'RolesController@create');
		Route::get('role/{roleId}', 'RolesController@show');
		Route::post('role/create', 'RolesController@store');
		Route::put("role /{roleId}", 'RolesController@update');
		Route::delete("role/{roleId}", 'RolesController@delete');
	});
	Route::group(['middleware' => 'manage-tag'], function ()
	{
		Route::get('tag/all', 'TagsController@all');
		Route::get('tag/create', 'TagsController@create');
		Route::get('tag/{tagId}', 'TagsController@show');
		Route::put('tag/{tagId}', 'TagsController@update');
		Route::delete('tag/{tagId}', 'TagsController@delete');
		Route::post('tag/create', 'TagsController@store');
	});
	Route::group(['middleware' => 'manage-feature'], function ()
	{
		Route::get('feature/all', 'FeaturesController@all');
		Route::get('feature/create', 'FeaturesController@create');
		Route::get('feature/{tagId}', 'FeaturesController@show');
		Route::put('feature/{tagId}', 'FeaturesController@update');
		Route::delete('feature/{tagId}', 'FeaturesController@delete');
		Route::post('feature/create', 'FeaturesController@store');
	});
	Route::group(['middleware' => 'manage-cuisine'], function ()
	{
		Route::get('cuisine/all', 'CuisinesController@all');
		Route::get('cuisine/create', 'CuisinesController@create');
		Route::post('cuisine/create', 'CuisinesController@store');
		Route::get('cuisine/{cuisineId}', 'CuisinesController@show');
		Route::put('cuisine/{cuisineId}', 'CuisinesController@update');
		Route::delete('cuisine/{cuisineId}', 'CuisinesController@delete');
		Route::post('cuisine/{cuisineSlug}/add-photo', 'CuisinesController@addCuisinePhoto');
	});

	Route::group(['middleware' => 'permission.manage-collection'], function ()
	{
		Route::get('collection/all', 'CollectionsController@all');
		Route::get('collection/create', 'CollectionsController@create');
		Route::post('collection/create', 'CollectionsController@store');
		Route::get('collection/{collectionSlug}', 'CollectionsController@show');
		Route::put('collection/{collectionId}', 'CollectionsController@update');
		Route::delete("collection/{collectionId}", "CollectionsController@delete");
		Route::post('collection/{collectionSlug}/add-photo', 'CollectionsController@addPhoto');
	});
});

//BusinessesOwner Role
Route::group(['middleware' => 'biz-owner', 'namespace' => 'BusinessOwner'], function ()
{

	Route::post('venue/{venueSlug}/biz-owner/basic', 'InfoController@basic');
	Route::post('venue/{venueSlug}/biz-owner/social', 'InfoController@social');
	Route::post('venue/{venueSlug}/biz-owner/communication', 'InfoController@communication');
	Route::post('venue/{venueSlug}/biz-owner/menu/add', 'MenusController@store');
	Route::post('venue/{venueSlug}/biz-owner/photo', 'VenuesController@postPhoto'); //validated
	Route::post('venue/{venueSlug}/biz-owner/map', 'VenuesController@postMap');
	Route::patch('venue/{venueSlug}/biz-owner/menu/edit/{itemId}', 'MenusController@update');
	Route::post('venue/{venueSlug}/biz-owner/support', 'VenuesController@storeSupport');
	Route::post('venue/{venueSlug}/biz-owner/suggestion', 'VenuesController@storeSuggestion');
	Route::post('venue/biz-owner/venue/{venueSlug}/reviews/{reviewId}/report', 'VenuesController@reportReview');
	Route::post('venue/{venueSlug}/biz-owner/storeSchedule', 'VenuesController@storeSchedule');
	Route::get('venue/{venueSlug}/biz-owner/info', 'VenuesController@info');
	Route::get('venue/{venueSlug}/biz-owner/photo', 'VenuesController@getPhoto');
	Route::get('venue/{venueSlug}/biz-owner/map', 'VenuesController@getMap');
	Route::get('venue/{venueSlug}/biz-owner/menu/all', 'MenusController@all');
	Route::get('venue/{venueSlug}/biz-owner/menu/add', 'MenusController@create');
	Route::get('venue/{venueSlug}/biz-owner/menu/edit/{itemId}', 'MenusController@edit');
	Route::get('venue/{venueSlug}/biz-owner/schedules', 'VenuesController@schedules');
	Route::get('venue/{venueSlug}/biz-owner/support', 'VenuesController@support');
	Route::get('venue/{venueSlug}/biz-owner/suggestion', 'VenuesController@suggestion');
	Route::get('venue/{venueSlug}/biz-owner/reviews', 'VenuesController@reviews');
});
Route::group(['middleware' => 'auth'], function ()
{
	Route::post('venue/post-claim', 'VenuesController@postClaim');
	Route::get('venue/claim/{citySlug}/{venueSlug}', 'VenuesController@getClaim');
	Route::get('payment/initialize/{venueSlug}', 'PaymentsController@initialize');
	Route::get('payment/handle-callback', 'PaymentsController@handleCallback');
});
Route::get('admin/{path?}', function ()
{
	return view('admin.build.index');
})->where('path', '.*');

//deprecated
Route::group(['prefix' => 'api/v1', 'namespace' => 'Api'], function ()
{
	Route::get('city/list', 'CitiesController@all');
	Route::get('{citySlug}/venue/top', 'CitiesController@topVenues');
	Route::get('{citySlug}/venue/nearby/lat/{lat}/lng/{lng}', 'CitiesController@nearbyVenues');
	Route::get('{citySlug}/venue/selected', 'CitiesController@selectedVenues');
	Route::get('venue/search/city/{citySlug}/', 'VenuesController@search');
	Route::get('venue/{venueSlug}', 'VenuesController@index');
	Route::get('venue/{venueSlug}/reviews', 'VenuesController@reviews');
	Route::get('venue/{venueSlug}/menus', 'VenuesController@menus');
	Route::get('venue/{venueSlug}/photos', 'VenuesController@photos');
	Route::post('auth/register', 'AuthController@postRegister');
	Route::post('auth/login', 'AuthController@postLogin');
	Route::post('auth/google', 'AuthController@handleApiProviderCallback');
	Route::post('auth/refresh-token', "AuthController@refreshToken");
	Route::group(['middleware' => ['jwt.auth']], function ()
	{
		Route::post('user/review/add', 'UsersController@addReview');
		Route::post('user/add-venue-photo/{venueSlug}', 'UsersController@addVenuePhoto');
	});
});
$api = app('api.router');
$api->version('v2', ['middleware' => array('api.throttle')], function ($api)
{
	$mobileControllerNameSpace = 'App\Http\Controllers\Api\V2\Mobile\\';
	$api->post("venue/search/nearby", $mobileControllerNameSpace . "SearchesController@nearby");
	$api->post("venue/search", $mobileControllerNameSpace . "SearchesController@streetSearch");

	$api->get('city/all', $mobileControllerNameSpace . "CitiesController@all");
	$api->get('venue/nearby/lat/{lat}/lng/{lng}', $mobileControllerNameSpace . 'CitiesController@nearbyVenues');
	$api->get("venue/search/city/{citySlug}", $mobileControllerNameSpace . "VenuesController@search");
//    $api->post("venue/suggest", $mobileControllerNameSpace . "SearchesController@suggestVenues");
	$api->post("location/suggest", $mobileControllerNameSpace . "SearchesController@suggestStreets");
	$api->post("location/search", $mobileControllerNameSpace . "SearchesController@searchVenues");
//    $api->post("street/search", $mobileControllerNameSpace . "SearchesController@searchStreets");
	$api->get("venue/{venueSlug}", $mobileControllerNameSpace . "VenuesController@index");
	$api->get("venue/{venueSlug}/reviews", $mobileControllerNameSpace . "VenuesController@reviews");
	$api->get("venue/{venueSlug}/menus", $mobileControllerNameSpace . "VenuesController@menus");
	$api->get("venue/{venueSlug}/photos", $mobileControllerNameSpace . "VenuesController@photos");
	$api->get("city/{citySlug}/collections", $mobileControllerNameSpace . "CollectionsController@all");
	$api->get("city/{citySlug}/collection/{collectionSlug}", $mobileControllerNameSpace . "CollectionsController@index");
	$api->post("auth/register", $mobileControllerNameSpace . "AuthController@postRegister");
	$api->post("auth/login", $mobileControllerNameSpace . "AuthController@postLogin");
	$api->post("auth/google", $mobileControllerNameSpace . "AuthController@handleApiProviderCallback");
	$api->post("auth/refreshToken", $mobileControllerNameSpace . "AuthController@refreshToken");
	$api->group(['middleware' => ['jwt.auth']], function () use ($api, $mobileControllerNameSpace)
	{
		$api->post("user/review/add", $mobileControllerNameSpace . "UsersController@addReview");
		$api->post("user/addVenuePhoto/{venueSlug}", $mobileControllerNameSpace . "UsersController@addVenuePhoto");
	});
	$api->group(['middleware' => ['jwt.auth', 'permission.manage-collection']], function () use ($api, $backendControllerNameSpace)
	{
		$api->post('panel/collections', $backendControllerNameSpace . "CollectionsController@all");
		$api->post('panel/collections/store', $backendControllerNameSpace . "CollectionsController@store");
		$api->get('panel/collections/city/all', $backendControllerNameSpace . "CollectionsController@allCities");
		$api->post('panel/collections/uploadPhoto', $backendControllerNameSpace . "CollectionsController@addPhoto");
		$api->post('panel/collections/venue/search', $backendControllerNameSpace . "CollectionsController@searchVenues");

		$api->post('panel/tags', $backendControllerNameSpace . "TagsController@all");
		$api->post('panel/tags/store', $backendControllerNameSpace . "TagsController@store");
		$api->post('panel/tags/uploadPhoto', $backendControllerNameSpace . "TagsController@addPhoto");
	});
});

$api = app('api.router');
$api->version('v2', ['middleware' => array('api.throttle')], function ($api)
{
	$mobileControllerNameSpace = 'App\Http\Controllers\Api\V2\Mobile\\';
	$api->get('city/all', $mobileControllerNameSpace . "CitiesController@all");
	$api->get('venue/nearby/lat/{lat}/lng/{lng}', $mobileControllerNameSpace . 'CitiesController@nearbyVenues');
	$api->get("venue/search/city/{citySlug}", $mobileControllerNameSpace . "VenuesController@search");
	$api->get("venue/{venueSlug}", $mobileControllerNameSpace . "VenuesController@index");
	$api->get("venue/{venueSlug}/reviews", $mobileControllerNameSpace . "VenuesController@reviews");
	$api->get("venue/{venueSlug}/menus", $mobileControllerNameSpace . "VenuesController@menus");
	$api->get("venue/{venueSlug}/photos", $mobileControllerNameSpace . "VenuesController@photos");
	$api->get("city/{citySlug}/collections", $mobileControllerNameSpace . "CollectionsController@all");
	$api->get("city/{citySlug}/collection/{collectionSlug}", $mobileControllerNameSpace . "CollectionsController@index");
	$api->post("auth/register", $mobileControllerNameSpace . "AuthController@postRegister");
	$api->post("auth/login", $mobileControllerNameSpace . "AuthController@postLogin");
	$api->post("auth/google", $mobileControllerNameSpace . "AuthController@handleApiProviderCallback");
	$api->post("auth/refreshToken", $mobileControllerNameSpace . "AuthController@refreshToken");
	$api->group(['middleware' => ['jwt.auth']], function () use ($api, $mobileControllerNameSpace)
	{
		$api->post("user/review/add", $mobileControllerNameSpace . "UsersController@addReview");
		$api->post("user/addVenuePhoto/{venueSlug}", $mobileControllerNameSpace . "UsersController@addVenuePhoto");
	});

	$api->group(['prefix' => 'admin'], function () use ($api)
	{
		$backendControllerNameSpace = 'App\Http\Controllers\Api\V2\Backend\\';
		$api->post("auth/login", $backendControllerNameSpace . "AuthController@postLogin");
		$api->group(['middleware' => ['jwt.auth', 'permission.admin']], function () use ($api, $backendControllerNameSpace)
		{
			$api->post('auth/refreshToken', $backendControllerNameSpace . "AuthController@refreshToken");
			$api->post("auth/permissions", $backendControllerNameSpace . "AuthController@getPermissions");

			$api->group(['middleware' => ['jwt.auth', 'permission.manage-collection']], function () use ($api, $backendControllerNameSpace)
			{
				$api->post('panel/collections', $backendControllerNameSpace . "CollectionsController@all");
				$api->post('panel/collections/store', $backendControllerNameSpace . "CollectionsController@store");
				$api->get('panel/collections/city/all', $backendControllerNameSpace . "CollectionsController@allCities");
				$api->post('panel/collections/uploadPhoto', $backendControllerNameSpace . "CollectionsController@addPhoto");
				$api->post('panel/collections/venue/search', $backendControllerNameSpace . "CollectionsController@searchVenues");

				$api->post('panel/tags', $backendControllerNameSpace . "TagsController@all");
				$api->post('panel/tags/store', $backendControllerNameSpace . "TagsController@store");
				$api->post('panel/tags/uploadPhoto', $backendControllerNameSpace . "TagsController@addPhoto");
			});

		});
	});
});
$api->version('v3', ['middleware' => array('api.throttle')], function ($api)
{
	$mobileControllerNameSpace = 'App\Http\Controllers\Api\V3\Mobile\\';
	$api->post("venue/search/nearby", $mobileControllerNameSpace . "SearchesController@nearby");
	$api->post("venue/search", $mobileControllerNameSpace . "SearchesController@streetSearch");
});
