<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CreditNoteApprovalController;
use App\Http\Controllers\Admin\NGFactoryPDController;

Route::middleware(['auth'])
    ->group(function () {
        Route::controller(CreditNoteApprovalController::class)
            ->group(function () {
                Route::get('credit_note_approval', 'index')->name('credit_note_approval.index');
                Route::get('credit_note_approval/create', 'create')->name('credit_note_approval.create');
                Route::post('credit_note_approval/store', 'store')->name('credit_note_approval.store');
                Route::get('credit_note_approval/{credit_note_approval}/show', 'show')->name('credit_note_approval.show');
                Route::get('credit_note_approval_list', 'list')->name('credit_note_approval.list');

                Route::get('credit_note_approval/my_submitted_list', 'my_submitted_list')->name('credit_note_approval.my_submitted_list');

                Route::get('credit_note_approval/my_submitted_edit/{credit_note_approval}', 'my_submitted_edit')->name('credit_note_approval.my_submitted_edit');
                Route::get('credit_note_approval/my_submitted_delete/{credit_note_approval}', 'my_submitted_delete')->name('credit_note_approval.my_submitted_delete');

                Route::put('credit_note_approval/my_submitted_update/{id}', 'my_submitted_update')->name('credit_note_approval.my_submitted_update');

                Route::get('credit_note_approval/request_for_approval_list', 'request_for_approval_list')->name('credit_note_approval.request_for_approval');
                Route::get('credit_note_approval/request_for_approval_edit/{credit_note_approval}', 'request_for_approval_edit')->name('credit_note_approval.request_for_approval_edit');
                Route::put('credit_note_approval/request_for_approval_update/{id}', 'request_for_approval_update')->name('credit_note_approval.request_for_approval_update');

                Route::get('credit_note_approval/approved_submission_list', 'approved_submission_list')->name('credit_note_approval.approved_submission_list');

                Route::post('/credit-note-approval/submit-selected', 'submit_selected')->name('credit_note_approval.submit_selected');

            });
    });


    Route::middleware(['auth'])
    ->group(function () {
        Route::controller(NGFactoryPDController::class)
            ->group(function () {
                Route::get('ng_factory_pd', 'index')->name('ng_factory_pd.index');
                Route::get('ng_factory_pd/create', 'create')->name('ng_factory_pd.create');
                Route::post('ng_factory_pd/store', 'store')->name('ng_factory_pd.store');
                Route::get('ng_factory_pd/edit/{id}', 'edit')->name('ng_factory_pd.edit');
                Route::get('ng_factory_pd/show/{id}', 'show')->name('ng_factory_pd.show');
                Route::get('ng_factory_pd_list', 'list')->name('ng_factory_pd.list');
                Route::put('ng_factory_pd/update/{id}', 'update')->name('ng_factory_pd.update');
                Route::delete('/ng_factory_pd/{id}','destroy')->name('ng_factory_pd.destroy');

                Route::get('ng_factory_pd/my_submitted_list', 'my_submitted_list')->name('ng_factory_pd.my_submitted_list');

                Route::get('ng_factory_pd/my_submitted_edit/{ng_factory_pd}', 'my_submitted_edit')->name('ng_factory_pd.my_submitted_edit');
                Route::get('ng_factory_pd/my_submitted_delete/{ng_factory_pd}', 'my_submitted_delete')->name('ng_factory_pd.my_submitted_delete');

                Route::put('ng_factory_pd/my_submitted_update/{id}', 'my_submitted_update')->name('ng_factory_pd.my_submitted_update');

                Route::get('ng_factory_pd/request_for_approval_list', 'request_for_approval_list')->name('ng_factory_pd.request_for_approval');
                Route::get('ng_factory_pd/request_for_approval_edit/{ng_factory_pd}', 'request_for_approval_edit')->name('ng_factory_pd.request_for_approval_edit');
                Route::put('ng_factory_pd/request_for_approval_update/{id}', 'request_for_approval_update')->name('ng_factory_pd.request_for_approval_update');

                Route::get('ng_factory_pd/approved_submission_list', 'approved_submission_list')->name('ng_factory_pd.approved_submission_list');

                Route::post('/credit-note-approval/submit-selected', 'submit_selected')->name('ng_factory_pd.submit_selected');

                Route::get('proposal/request_approval_list', 'requestForApproval')->name('proposal.request_approval_list');

                Route::get('proposal/request_approval_show/{id}', 'requestForApprovalShow')->name('proposal.request_approval_show');

                Route::post('proposal/request_approval_store', 'requestForApprovalStore')->name('proposal.request_approval_store');

            });
    });
