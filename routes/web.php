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

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function ()
{
	Route::get('/',  ['as' => 'home.show',  'uses' => 'DashboardController@show']);

	Route::get('/banner',  ['as' => 'banner.show',  'uses' => 'BannerController@show']);
	Route::post('/banner-save',  ['as' => 'banner.save',  'uses' => 'BannerController@save']);
	Route::post('/banner-delete',  ['as' => 'banner.delete',  'uses' => 'BannerController@delete']);

	Route::get('/services-offer',  ['as' => 'services.offer.show',  'uses' => 'ServicesOfferController@show']);
	Route::post('/services-offer-save',  ['as' => 'service.offer.save',  'uses' => 'ServicesOfferController@save']);
	Route::post('/services-offer-delete',  ['as' => 'service.offer.delete',  'uses' => 'ServicesOfferController@delete']);

	Route::get('/services',  ['as' => 'services.show',  'uses' => 'ServicesController@show']);
	Route::post('/service-save',  ['as' => 'service.save',  'uses' => 'ServicesController@save']);
	Route::post('/service-delete',  ['as' => 'service.delete',  'uses' => 'ServicesController@delete']);

	Route::get('/company',  ['as' => 'company.show',  'uses' => 'CompanyController@show']);
	Route::post('/company-save',  ['as' => 'company.save',  'uses' => 'CompanyController@save']);

	Route::get('/partners', ['as' => 'partners.show', 'uses' => 'PartnerController@show']);
	Route::post('/partners-save',  ['as' => 'partner.save',  'uses' => 'PartnerController@save']);
	Route::post('/partners-delete',  ['as' => 'partner.delete',  'uses' => 'PartnerController@delete']);

	Route::get('/about', ['as' => 'about.show', 'uses' => 'AboutController@show']);
	Route::post('/about-save',  ['as' => 'about.save',  'uses' => 'AboutController@save']);
	Route::post('/about-delete',  ['as' => 'about.delete',  'uses' => 'AboutController@delete']);

	Route::get('/team', ['as' => 'team.show', 'uses' => 'TeamController@show']);
	Route::post('/team-save',  ['as' => 'team.save',  'uses' => 'TeamController@save']);
	Route::post('/team-delete',  ['as' => 'team.delete',  'uses' => 'TeamController@delete']);

	Route::get('/portfolio', ['as' => 'portfolio.show', 'uses' => 'PortfolioController@show']);
	Route::post('/portfolio-save',  ['as' => 'portfolio.save',  'uses' => 'PortfolioController@save']);
	Route::post('/portfolio-delete',  ['as' => 'portfolio.delete',  'uses' => 'PortfolioController@delete']);

	Route::get('/team-social-network', ['as' => 'team.social.network.show', 'uses' => 'TeamSocialNetworkController@show']);
	Route::post('/team-social-save',  ['as' => 'team.social.network.save',  'uses' => 'TeamSocialNetworkController@save']);
	Route::post('/team-social-delete',  ['as' => 'team.social.network.delete',  'uses' => 'TeamSocialNetworkController@delete']);

	Route::get('/contact', ['as' => 'contact.show', 'uses' => 'ContactController@show']);
});

