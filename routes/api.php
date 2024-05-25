<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ScoreApiController;
use App\Http\Controllers\Api\MessageApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\TaskUserApiController;
use App\Http\Controllers\Api\CategoryTaskController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


// REVISAR RUTAS DE API AL FINALIZAR EL PROYECTO
Route::get('/calendar/{user}/tasks', [TaskUserApiController::class, 'calendarTasks']);

Route::get('/users/{user}/tasks', [TaskUserApiController::class, 'getTasksUser']);
Route::get('/tasks/{task}/users', [TaskUserApiController::class, 'getUsersTask']);
Route::post('/tasks/{task}/assign-user', [TaskUserApiController::class, 'assignUserToTask']);
Route::delete('/tasks/{taskId}/users/{userId}', [TaskUserApiController::class, 'removeUserFromTask']);

Route::get('/categories/{category}/tasks', [CategoryTaskController::class, 'getTasksCategory']);
Route::get('/tasks/{task}/categories', [CategoryTaskController::class, 'getCategoriesTask']);
Route::post('/tasks/{task}/assign-category', [CategoryTaskController::class, 'assignCategoryToTask']);

Route::get('/scores/users/{userId}', [ScoreApiController::class, 'getScoresByUserId']);
Route::get('/scores/tasks/{taskId}', [ScoreApiController::class, 'getScoresByTaskId']);
Route::get('/scores/users/{userId}/tasks/{taskId}', [ScoreApiController::class, 'getScoreByUserIdAndTaskId']);
Route::patch('/scoresAPI/{userId}/{taskId}', [ScoreApiController::class, 'updateByUserIdAndTaskId']);

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);


Route::apiResource('categoriesAPI', CategoryApiController::class);



Route::apiResource('scoresAPI', ScoreApiController::class);

Route::apiResource('usersAPI', UserApiController::class);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {

    Route::get('currentUser', function (Request $request) {
        return $request->user();
    });

    Route::get('/messages/with/{user}', [MessageApiController::class, 'getMessagesWithUser']);

    Route::post('logout', [AuthApiController::class, 'logout']);

    Route::apiResource('tasksAPI', TaskApiController::class);

    Route::apiResource('messagesAPI', MessageApiController::class);

});

