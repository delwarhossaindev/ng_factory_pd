<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\AjaxController;

/*
|--------------------------------------------------------------------------
| Applications AJAX Route
|--------------------------------------------------------------------------
|
| Here you may register all of the applications AJAX request route
|
*/

Route::get('delete/rows', [AjaxController::class, 'deleteRows']);
Route::get('ajax_search_tag', [AjaxController::class, 'ajaxSearchTag']);
Route::get('invoice_search', [AjaxController::class, 'invoiceSearch'])->name('search.invoice');
Route::get('invoice_detail_search', [AjaxController::class, 'searchInvoiceDetails'])->name('search.invoice.detail');
