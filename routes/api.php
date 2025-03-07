<?php

use App\Http\Controllers\API\PetController;
use App\Http\Controllers\API\PetFoodController;
use App\Http\Controllers\API\PetMedicationController;
use App\Http\Controllers\API\PetRoutineController;
use App\Http\Controllers\API\ReminderController;
use App\Http\Controllers\API\UserController;
use App\library\vet_location_bot;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);


Route::get('/vet-location/{city}', function ($city) {
    try {
        $bot = new vet_location_bot($city);
        $data = $bot->getData();
        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::group(['middleware' => ['auth:api']], function () {

    Route::group(['prefix' => 'pet'], function () {
        Route::get('/', [PetController::class, 'index']);
        Route::get('/{id}', [PetController::class, 'show']);
        Route::post('/create', [PetController::class, 'create']);
        Route::delete('/delete/{id}', [PetController::class, 'delete']);
    });

    Route::group(['prefix' => 'user'], function () {

        Route::get('/dashboard', [UserController::class, 'dashBoard']);

        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::post('/forgotPassword', [UserController::class, 'forgotPassword']);
        Route::post('/resetPassword', [UserController::class, 'resetPassword']);
        Route::delete('/deactivate/{id}', [UserController::class, 'deactivate']);
        Route::get('/', [UserController::class, 'show']);

    });
    Route::group(['prefix' => 'pet_food'], function () {
        Route::get('/', [PetFoodController::class, 'index']);
        Route::get('/{pet_id}', [PetFoodController::class, 'filterByPetId']);
        Route::post('/create', [PetFoodController::class, 'create']);
        Route::delete('/delete/{id}', [PetFoodController::class, 'delete']);
    });

    Route::group(['prefix' => 'pet_routine'], function () {
        Route::post('/create', [PetRoutineController::class, 'create']);
        Route::get('/{pet_id}', [PetRoutineController::class, 'filterByPetId']);
    });

    Route::group(['prefix' => 'pet_medication'], function () {
        Route::post('/create', [PetMedicationController::class, 'create']);
        Route::get('/{pet_id}', [PetMedicationController::class, 'filterByPetId']);
    });

    Route::group(['prefix' => 'pet_vet'], function () {
        Route::get('/nearBy', [\App\Http\Controllers\API\PetVetController::class, 'nearBy']);
        Route::get('/{pet_id}', [\App\Http\Controllers\API\PetVetController::class, 'filterByPetId']);
    });
    Route::group(['prefix' => 'reminders'], function () {
        Route::get('/{pet_id}', [ReminderController::class, 'filterByPetId']);
        Route::delete('/delete/{id}', [ReminderController::class, 'delete']);

    });

    Route::group(['prefix' => 'vet_care'], function () {
        Route::post('/findNear', [\App\Http\Controllers\API\VetCareController::class, 'findCareCenterNearByUser']);
    });

    Route::post('push-notif', [\App\Http\Controllers\API\PushNotificationController::class, 'index']);

});
