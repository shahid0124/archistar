<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group([
    'namespace' => 'Api'
],
    function () use ($router) {
        $router->post(
            'properties',
            [
                'uses' => 'PropertiesController@create'
            ]
        );

        $router->get(
            'properties/{property_id}',
            [
                'uses' => 'PropertiesController@get'
            ]
        );

        $router->post(
            'properties/{property_id}/analytics/{analytics_id}',
            [
                'uses' => 'PropertyAnalyticsController@create'
            ]
        );

        $router->patch(
            'properties/{property_id}/analytics/{analytics_id}',
            [
                'uses' => 'PropertyAnalyticsController@update'
            ]
        );

        $router->get(
            'properties/summary_by_suburb/{suburb}',
            [
                'uses' => 'PropertiesController@getSummaryBySuburb'
            ]
        );

        $router->get(
            'properties/summary_by_country/{country}',
            [
                'uses' => 'PropertiesController@getSummaryByCountry'
            ]
        );
        $router->get(
            'properties/summary_by_state/{state}',
            [
                'uses' => 'PropertiesController@getSummaryByState'
            ]
        );
    }
);

