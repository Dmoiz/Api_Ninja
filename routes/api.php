<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NinjaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MisionController;
use App\Http\Controllers\RecruitController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//NINJAS//
Route::prefix('/ninjas')->group(function() {
    //Show All
    Route::get('/', [NinjaController::class, 'show_all']);
    //Create
    Route::put('/create', [NinjaController::class, 'create']);
    //Get ninja by Id
    Route::get('/{id}', [NinjaController::class, 'show_by_id']);
    //Edit ninja
    Route::post('/edit/{id}', [NinjaController::class, 'edit']);
    //Edit ninja state
    Route::post('edit_status/{id}', [NinjaController::class, 'change_state']);
    //Show by name
    Route::get('/show_by_name/{name}', [NinjaController::class, 'show_by_name']);
    //Show by state
    Route::get('/show_by_state/{name}', [NinjaController::class, 'show_by_state']);
    //Assign ninjas to mission
    Route::post('/assign', [NinjaController::class, 'assign']);
    //Unassign
    Route::delete('/unassign', [NinjaController::class, 'unassign']);
});

//CLIENTS//
Route::prefix('/clients')->group(function() {
    //Show All + misions of the client
    Route::get('/', [ClientController::class, 'show_all']);
    //Create
    Route::put('/create', [ClientController::class, 'create']);
    //Edit (Code & Preference)
    Route::post('/edit/{id}', [ClientController::class, 'edit']);
});

//MISONS//
Route::prefix('/misions')->group(function() {
    //Show All
    Route::get('/', [MisionController::class, 'show_all']);
    //Create
    Route::put('/create', [MisionController::class, 'create']);
    //Get by Id
    Route::get('/{id}', [MisionController::class, 'show_by_id']);
    //Edit mission 
    Route::post('/edit/{id}', [MisionController::class, 'edit']);
    //Change status
    Route::post('/edit_state/{id}', [MisionController::class, 'change_state']);

});

//RECRUITS//
Route::prefix('/recruits')->group(function() {
    //Show All
    Route::get('/', [RecruitController::class, 'show_all']);
    //Create
    Route::put('/create', [RecruitController::class, 'create']);
    //Edit
    Route::post('/edit/{id}', [RecruitController::class, 'edit']);
    //Delete
    Route::delete('/delete/{id}', [RecruitController::class, 'delete']);
    //Promote
    Route::put('/promote/{id}', [RecruitController::class, 'promote']);
});