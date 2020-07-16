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
    return $request->user()->load(['role']);
});

Route::group(['middleware' => ['auth:api']], function () {

});

Route::apiResources([
    'users' => 'Api\UserController',
    'eleves' => 'Api\EleveController',
    'familles' => 'Api\FamilleController',
    'annees' => 'Api\AnneeController',
    'parcours' => 'Api\ParcourController',
    'roles' => 'Api\RoleController',
    'parents' => 'Api\ParentController',
    'paiements' => 'Api\PaiementController',
    'classes' => 'Api\ClasseController',
    'caracteristiques' => 'Api\CaracteristiqueController',
    'motifs' => 'Api\MotifController',
]);
