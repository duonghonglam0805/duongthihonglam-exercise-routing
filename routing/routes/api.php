<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user', function () {
    global $users;
    return $users;
});
Route::prefix('/user')->group(function () {
    Route::get('/{userIndex?}', function ($userIndex = null) {
        global $users;
        foreach ($users as $index => $user) {
            if ($userIndex ==  $index) {
                return $user;
            }
        }
        return 'Cannot find the user with index ' . $userIndex;
    })->where(['userIndex' => '[0-9]+']);
    Route::get('/{userName?}', function ($userName) {
        global $users;
        foreach ($users as $index => $user) {
            if ($user['name'] == $userName) {
                return $user;
            }
        }
        return 'Cannot find the user with user ' . $userName;
    })->where(['userName' => '[a-zA-Z]+']);
    Route::get('/{userIndex?}/post/{postIndex?}', function ($userIndex = null, $postIndex = null) {
        global $users;
        foreach ($users as $index => $user) {
            if ($userIndex ==  $index) {
                if ($userIndex == $index) {
                    if (isset($user['posts'][$postIndex])) {
                        return $user['posts'][$postIndex];
                    } else {
                        return 'Cannot find the post with id ' . $postIndex . ' for user ' . $userIndex;
                    }
                }
            }
        }
    })->where(['userIndex' => '[0-9]+', 'postIndex' => '[0-9]+']);
    Route::fallback(function () {
        return "You cannot get a user like this !";
    });
});