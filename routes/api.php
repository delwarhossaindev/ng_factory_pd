<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ImportController;

/*
|--------------------------------------------------------------------------
| Applications API Route
|--------------------------------------------------------------------------
|
| Here you may register all of the applications API route
|
*/

Route::controller(ImportController::class)->group(function () {
    Route::post('upload', 'import')->name('import.user');
    Route::get('batch', 'getBatch')->name('batch');
    Route::get('batch/in-progress', 'getImportProgress')->name('batch.progress');
});
