<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CollectionController;

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

//Unauthenticated routes
Route::get("/collections/{collection}", [CollectionController::class, "collection"])->name("collections.collection");
Route::post("/commands/index", [CommandController::class, "index"])->name("commands.index");
Route::post("/commands/collection/{collection}", [CommandController::class, "collectionCommands"])->name("commands.collection_commands");
Route::post("/contact", [ContactController::class, "sendMail"])->name("send-mail");

//Authenticated routes
Route::middleware(["auth:sanctum"])->get("/user", function (Request $request) {
    return $request->user();
});

//Collections
Route::prefix("/collections")
    ->middleware(["auth:sanctum"])
    ->name("collections.")
    ->group(function () {
        Route::get("index", [CollectionController::class, "index"])->name("index");
        Route::post("store", [CollectionController::class, "store"])->name("store");
        Route::get("users/{userID}", [CollectionController::class, "userCollections"])->name("user");
        Route::get("users/{user}/{collection}", [CollectionController::class, "userCollection"])->name("user_collection");
        Route::post("sort/{userID}", [CollectionController::class, "sortCollections"])->name("sort");

        Route::get("edit/{collection}", [CollectionController::class, "edit"])->name("edit");
        Route::post("update/{collection}", [CollectionController::class, "update"])->name("update");
        Route::post("destroy/{collection}", [CollectionController::class, "destroy"])->name("destroy");
    });

//Commands
Route::prefix("/commands")
    ->middleware(["auth:sanctum"])
    ->name("commands.")
    ->group(function () {
        Route::post("store", [CommandController::class, "store"])->name("store");
        Route::post("sort/{collectionID}", [CommandController::class, "sortCollectionCommands"])->name("sort");
        Route::get("users/{userID}", [CommandController::class, "userCommands"])->name("user");
        Route::get("users/{user}/{command}", [CommandController::class, "userCommand"])->name("user_command");
        Route::get("edit/{command}", [CommandController::class, "edit"])->name("edit");
        Route::post("update/{command}", [CommandController::class, "update"])->name("update");
        Route::post("destroy/{command}", [CommandController::class, "destroy"])->name("destroy");
    });

//Commands
Route::prefix("/theme")
    ->middleware(["auth:sanctum"])
    ->name("theme.")
    ->group(function () {
        Route::get("{user}", [ThemeController::class, "get"])->name("get");
        Route::post("{user}", [ThemeController::class, "update"])->name("update");
    });
