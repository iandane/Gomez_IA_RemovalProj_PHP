<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome!']);
});

Route::get('/getItems', [ItemController::class, 'getItems']);


Route::post('/addItem', [ItemController::class, 'postItem']);

Route::patch('/updateItem/{_id}', [ItemController::class, 'patchItem']);

Route::delete('/deleteItem/{_id}', [ItemController::class, 'deleteItem']);