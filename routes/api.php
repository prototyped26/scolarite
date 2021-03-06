<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'users'], function (){
        Route::get('/current', 'Api\UserController@currentUser');
    });

    Route::apiResources([
        'paiements' => 'Api\PaiementController',
    ]);
});

Route::apiResources([
    'users' => 'Api\UserController',
    'eleves' => 'Api\EleveController',
    'familles' => 'Api\FamilleController',
    'annees' => 'Api\AnneeController',
    'parcours' => 'Api\ParcourController',
    'roles' => 'Api\RoleController',
    'parents' => 'Api\ParentController',
    'classes' => 'Api\ClasseController',
    'caracteristiques' => 'Api\CaracteristiqueController',
    'motifs' => 'Api\MotifController',
]);



Route::get('/annee-active', 'Api\AnneeController@active');
Route::get('/eleve-classe/{classe}', 'Api\EleveController@eleveClasse');
Route::get('/frais-caracteristiques/{frais}', 'Api\CaracteristiqueController@list');
