<?php

use App\Http\Middleware\CanInstall;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogoutPerfection;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ImapController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Middleware\CheckOtpSessionMiddleware;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Auth\ImpersonateController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Middleware\TwoFactorAuthenticationMiddleware;
use App\Http\Middleware\CheckResetPasswordSessionMiddleware;

Route::middleware(['guest'])
  ->group(function () {
    Route::redirect('/', 'login')->middleware(CanInstall::class);
    Route::controller(LoginController::class)
      ->group(function () {
        Route::get('login', 'index')->name('login');
        Route::post('login', 'login')->middleware('2fa.confirm');
        Route::get('logout', 'logout')
          ->withoutMiddleware('guest')
          ->middleware('auth')
          ->name('logout');
      });
  })->middleware(CanInstall::class);

Route::middleware([RedirectIfAuthenticated::class])
  ->group(function () {
    Route::controller(ForgotPasswordController::class)
      ->group(function () {
        Route::get('forgot/password', 'index')->name('forgot.password')
          ->middleware(CheckResetPasswordSessionMiddleware::class);
        Route::post('forgot/password', 'store');
        Route::post('resend/{user}', 'resend')->name('resend.otp');
      });
    Route::controller(VerifyOtpController::class)
      ->group(function () {
        Route::get('verify/otp/{otp}', 'index')->name('verify.otp')
          ->middleware(CheckOtpSessionMiddleware::class);
        Route::post('verify/otp/{otp}', 'store');
      });
    Route::controller(ResetPasswordController::class)
      ->group(function () {
        Route::get('reset/password/{otp}', 'index')->name('reset.password');
        Route::post('reset/password/{otp}', 'store');
      });
    Route::controller(TwoFactorAuthController::class)
      ->group(function () {
        Route::get('2fa', 'prepareTwoFactor')
          ->name('2fa')
          ->middleware(TwoFactorAuthenticationMiddleware::class);
        Route::post('2fa/code', 'confirmTwoFactor')->name('2fa.code.submit');
        Route::get('2fa/deactivate', 'disableTwoFactorAuth')->name('2fa.deactivate');
      });
    Route::controller(ImpersonateController::class)
      ->group(function () {
        Route::get('impersonate/user/{user}', 'index')
          ->name('impersonate');
        Route::get('impersonate/destroy', 'destroy')
          ->name('impersonate.destroy');
      });
  });

Route::controller(ProfileController::class)
  ->prefix('profile')
  ->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/{user}', 'update')->name('profile.update')->middleware('image-sanitize');
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::controller(DatabaseController::class)
      ->prefix('database')
      ->group(function () {
        Route::get('export', 'exportDatabase')
          ->name('export.database');
        Route::get('download/{backup}', 'downloadDatabase')
          ->name('download.database')
          ->withoutMiddleware(LogoutPerfection::class);
      });
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::controller(ExportController::class)
      ->prefix('export')
      ->group(function () {
        Route::get('/', 'export')->name('export');
        Route::get('download', 'download')->name('export.download');
      });
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::name('imap.')
      ->controller(ImapController::class)
      ->prefix('imap')
      ->group(function () {
        Route::get('connect', 'connectingServer')->name('connect');
        Route::get('mail/{id}/delete', 'deleteMessage')->name('mail.delete');
        Route::get('mail/{id}/show', 'seenMessage')->name('mail.show');
      });
  });

Route::post('import_data', [ImportController::class, 'import'])
  ->middleware([
    Authenticate::class,
    CanInstall::class
  ])
  ->name('model.import');

Route::middleware(['auth'])
  ->group(function () {
    Route::controller(MenuController::class)
      ->group(function () {
        Route::get('menu', 'index')->name('menu');
        Route::post('/addcustommenu', 'addcustommenu')->name('haddcustommenu');
        Route::post('/deleteitemmenu', 'deleteitemmenu')->name('hdeleteitemmenu');
        Route::post('/deletemenug', 'deletemenug')->name('hdeletemenug');
        Route::post('createnewmenu', 'createnewmenu')->name('hcreatenewmenu');
        Route::post('generatemenucontrol', 'generatemenucontrol')->name('hgeneratemenucontrol');
        Route::post('updateitem', 'updateitem')->name('hupdateitem');
      });
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::get('theme_mode', ThemeController::class)
      ->name('theme.update');
    Route::controller(SettingsController::class)
      ->group(function () {
        Route::get('settings', 'index')->name('settings');
        Route::post('settings', 'store')->name('settings.store');
        Route::patch('settings', 'update')->name('settings');
        Route::get('cache', 'cache')->name('cache');
        Route::get('change/password', 'updatePasswordForm')->name('update.password');
        Route::post('change/password', 'updatePassword');
        Route::post('store_website_info', 'saveOrUpdateWebsiteInfo')->name('store.website.info');
        Route::post('env_update', 'envManager')->name('env.update');
      });
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::controller(NotificationController::class)
      ->group(function () {
        Route::get('markAsRead/{id}', 'markAsReadById')
          ->name('notification.single.read');
        Route::get('markAsUnread/{id}', 'markAsUnreadById')
          ->name('notification.single.unread');
        Route::get('markAsRead', 'markAsRead')->name('mark.read');
        Route::get('notifications', 'getNotifications')
          ->name('notify.all');
        Route::post('delete/notification', 'deleteSelectedNotification')
          ->name('delete.notification');
      });
  });

Route::middleware(['auth'])
  ->group(function () {
    Route::controller(DashboardController::class)
      ->prefix('dashboard')
      ->group(function () {
        Route::get('/', 'index')->name('dashboard');
      });
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('user', UserController::class);
    Route::name('user.')
      ->controller(UserController::class)
      ->prefix('user')
      ->group(function () {
        Route::get('/{user}/activity', 'activity')->name('activity');
        Route::post('/{user}/restore', 'restore')->name('restore')->withTrashed();
        Route::post('/{user}/force_delete', 'forceDelete')->name('force_delete')
          ->withTrashed();
      });
    Route::resource('page', PageController::class);
    Route::name('page.')
      ->controller(PageController::class)
      ->prefix('page')
      ->group(function () {
        Route::post('/{page}/restore', 'restore')->name('restore')->withTrashed();
        Route::post('/{page}/force_delete', 'forceDelete')->name('force_delete')->withTrashed();
      });
    Route::resource('tag', TagController::class);
    Route::name('tag.')
      ->controller(TagController::class)
      ->prefix('tag')
      ->group(function () {
        Route::post('/{tag}/restore', 'restore')->name('restore')->withTrashed();
        Route::post('/{tag}/force_delete', 'forceDelete')->name('force_delete')->withTrashed();
      });
    Route::resource('category', CategoryController::class);
    Route::name('category.')
      ->controller(CategoryController::class)
      ->prefix('category')
      ->group(function () {
        Route::post('/{category}/restore', 'restore')->name('restore')->withTrashed();
        Route::post('/{category}/force_delete', 'forceDelete')->name('force_delete')->withTrashed();
      });
    Route::resource('article', PostController::class);
    Route::name('article.')
      ->controller(PostController::class)
      ->prefix('article')
      ->group(function () {
        Route::post('/{article}/restore', 'restore')->name('restore')->withTrashed();
        Route::post('/{article}/force_delete', 'forceDelete')->name('force_delete')->withTrashed();
      });
    Route::controller(ActivityLogController::class)
      ->prefix('log')
      ->group(function () {
        Route::get('/', 'index')->name('log');
      });
  });

Route::get('download_demo_import_user', function () {
  return response()->download(storage_path('import/' . 'user.csv'));
})
  ->name('demo.user.import.download')
  ->middleware('auth')
  ->withoutMiddleware(LogoutPerfection::class);

Route::get('lang/{locale}', [LocalizationController::class, 'lang']);
Route::fallback(fn () => abort(404));
