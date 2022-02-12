<?php

use App\Http\Controllers\CollectionController;
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

Route::middleware(["auth:sanctum"])->get("/user", function (Request $request) {
    return $request->user();
});

Route::prefix("/collections")
    //->middleware(["auth:sanctum"])
    ->name("collections.")
    ->group(function () {
        Route::get("index", [CollectionController::class, "index"])->name("index");
        Route::post("store", [CollectionController::class, "store"])->name("store");
        Route::get("user/{userID}", [CollectionController::class, "userCollections"])->name("user");
        Route::get("usersingle/{user}/{collection}", [CollectionController::class, "userCollection"])->name("user_collection");
        Route::get("edit/{collection}", [CollectionController::class, "edit"])->name("edit");
        Route::post("update/{collection}", [CollectionController::class, "update"])->name("update");
        Route::post("destroy/{collection}", [CollectionController::class, "destroy"])->name("destroy");
    });
