<?php

use App\Http\Controllers\Api\Account\AccountController as AccountAccountController;
use App\Http\Controllers\Api\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\Api\Dashboard\Admin\DepartmentController as DashboardAdminDepartmentController;
use App\Http\Controllers\Api\Dashboard\Admin\LabelController as DashboardAdminLabelController;
use App\Http\Controllers\Api\Dashboard\Admin\LanguageController as DashboardAdminLanguageController;
use App\Http\Controllers\Api\Dashboard\Admin\PriorityController as DashboardAdminPriorityController;
use App\Http\Controllers\Api\Dashboard\Admin\SettingController as DashboardAdminSettingController;
use App\Http\Controllers\Api\Dashboard\Admin\StatusController as DashboardAdminStatusController;
use App\Http\Controllers\Api\Dashboard\Admin\UserController as DashboardAdminUserController;
use App\Http\Controllers\Api\Dashboard\Admin\UserRoleController as DashboardAdminUserRoleController;
use App\Http\Controllers\Api\Dashboard\CannedReplyController as DashboardCannedReplyController;
use App\Http\Controllers\Api\Dashboard\StatsController as DashboardStatsController;
use App\Http\Controllers\Api\Dashboard\TicketController as DashboardTicketController;
use App\Http\Controllers\Api\File\FileController as FileFileController;
use App\Http\Controllers\Api\Language\LanguageController as LanguageLanguageController;
use App\Http\Controllers\Api\Ticket\TicketController as UserTicketController;

Route::group(['prefix' => 'lang'], static function () {
    Route::get('/', [LanguageLanguageController::class, 'list'])->name('language.list');
    Route::get('/{lang}', [LanguageLanguageController::class, 'get'])->name('language.get');
});

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [AuthAuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthAuthController::class, 'logout'])->name('auth.logout');
    Route::post('register', [AuthAuthController::class, 'register'])->name('auth.register');
    Route::post('recover', [AuthAuthController::class, 'recover'])->name('auth.recover');
    Route::post('reset', [AuthAuthController::class, 'reset'])->name('auth.reset');
    Route::get('user', [AuthAuthController::class, 'user'])->name('auth.user');
    Route::post('check', [AuthAuthController::class, 'check'])->name('auth.check');
});

Route::group(['prefix' => 'account'], static function () {
    Route::post('update', [AccountAccountController::class, 'update'])->name('account.update');
    Route::post('password', [AccountAccountController::class, 'password'])->name('account.password');
});

Route::get('files/download/{uuid}', [FileFileController::class, 'download'])->name('files.download');
Route::apiResource('files', FileFileController::class)->only(['store', 'show']);

Route::get('tickets/statuses', [UserTicketController::class, 'statuses'])->name('tickets.statuses');
Route::get('tickets/departments', [UserTicketController::class, 'departments'])->name('tickets.departments');
Route::post('tickets/attachments', [FileFileController::class, 'uploadAttachment'])->name('tickets.upload-attachment');
Route::post('tickets/{ticket}/reply', [UserTicketController::class, 'reply'])->name('tickets.reply');
Route::apiResource('tickets', UserTicketController::class)->except(['update', 'destroy']);

Route::group(['prefix' => 'dashboard'], static function () {

    Route::group(['prefix' => 'stats'], static function () {
        Route::get('count', [DashboardStatsController::class, 'count'])->name('dashboard.stats-count');
        Route::get('registered-users', [DashboardStatsController::class, 'registeredUsers'])->name('dashboard.stats.registered-users');
        Route::get('opened-tickets', [DashboardStatsController::class, 'openedTickets'])->name('dashboard.stats.opened-tickets');
    });

    Route::get('tickets/filters', [DashboardTicketController::class, 'filters'])->name('dashboard.tickets.filters');
    Route::get('tickets/canned-replies', [DashboardTicketController::class, 'cannedReplies'])->name('dashboard.tickets.canned-replies');
    Route::post('tickets/quick-actions', [DashboardTicketController::class, 'quickActions'])->name('dashboard.tickets.quick-actions');
    Route::post('tickets/attachments', [DashboardTicketController::class, 'uploadAttachment'])->name('dashboard.tickets.upload-attachment');
    Route::post('tickets/{ticket}/remove-label', [DashboardTicketController::class, 'removeLabel'])->name('dashboard.tickets.remove-label');
    Route::post('tickets/{ticket}/quick-actions', [DashboardTicketController::class, 'ticketQuickActions'])->name('dashboard.tickets.ticket-quick-actions');
    Route::post('tickets/{ticket}/reply', [DashboardTicketController::class, 'reply'])->name('dashboard.tickets.reply');
    Route::apiResource('tickets', DashboardTicketController::class, ['as' => 'dashboard'])->except(['update']);

    // Route::apiResource('canned-replies', DashboardCannedReplyController::class);
    Route::get('canned-replies', [DashboardCannedReplyController::class, 'index'])->name('canned-replies.index');
    Route::post('canned-replies', [DashboardCannedReplyController::class, 'store'])->name('canned-replies.store');
    Route::get('canned-replies/{canned_reply}', [DashboardCannedReplyController::class, 'show'])->name('canned-replies.show');
    Route::post('canned-replies/{canned_reply}', [DashboardCannedReplyController::class, 'update'])->name('canned-replies.update');
    Route::delete('canned-replies/{canned_reply}', [DashboardCannedReplyController::class, 'destroy'])->name('canned-replies.destroy');

    Route::group(['prefix' => 'admin'], static function () {

        Route::get('departments/users', [DashboardAdminDepartmentController::class, 'users'])->name('dashboard.departments.users');
        // Route::apiResource('departments', DashboardAdminDepartmentController::class);
        Route::get('departments', [DashboardAdminDepartmentController::class, 'index'])->name('dashboard.departments.index');
        Route::post('departments', [DashboardAdminDepartmentController::class, 'store'])->name('dashboard.departments.store');
        Route::get('departments/{departement}', [DashboardAdminDepartmentController::class, 'show'])->name('dashboard.departments.show');
        Route::post('departments/{departement}', [DashboardAdminDepartmentController::class, 'update'])->name('dashboard.departments.update');
        Route::delete('departments/{departement}', [DashboardAdminDepartmentController::class, 'destroy'])->name('dashboard.departments.destroy');

        // Route::apiResource('labels', DashboardAdminLabelController::class);
        Route::get('labels', [DashboardAdminLabelController::class, 'index'])->name('labels.index');
        Route::post('labels', [DashboardAdminLabelController::class, 'store'])->name('labels.store');
        Route::get('labels/{label}', [DashboardAdminLabelController::class, 'show'])->name('labels.show');
        Route::post('labels/{label}', [DashboardAdminLabelController::class, 'update'])->name('labels.update');
        Route::delete('labels/{label}', [DashboardAdminLabelController::class, 'destroy'])->name('labels.destroy');

        // Route::apiResource('statuses', DashboardAdminStatusController::class)->except(['store', 'delete']);
        Route::get('statuses', [DashboardAdminStatusController::class, 'index'])->name('statuses.index');
        Route::get('statuses/{status}', [DashboardAdminStatusController::class, 'show'])->name('statuses.show');
        Route::post('statuses/{status}', [DashboardAdminStatusController::class, 'update'])->name('statuses.update');
        Route::delete('statuses/{status}', [DashboardAdminStatusController::class, 'destroy'])->name('statuses.destroy');

        // Route::apiResource('priorities', DashboardAdminPriorityController::class)->except(['store', 'delete']);
        Route::get('priorities', [DashboardAdminPriorityController::class, 'index'])->name('priorities.index');
        Route::get('priorities/{priority}', [DashboardAdminPriorityController::class, 'show'])->name('priorities.show');
        Route::post('priorities/{priority}', [DashboardAdminPriorityController::class, 'update'])->name('priorities.update');
        Route::delete('priorities/{priority}', [DashboardAdminPriorityController::class, 'destroy'])->name('priorities.destroy');

        Route::get('users/user-roles', [DashboardAdminUserController::class, 'userRoles'])->name('users.user-roles');
        // Route::apiResource('users', DashboardAdminUserController::class);
        Route::get('users', [DashboardAdminUserController::class, 'index'])->name('users.index');
        Route::post('users', [DashboardAdminUserController::class, 'store'])->name('users.store');
        Route::get('users/{user}', [DashboardAdminUserController::class, 'show'])->name('users.show');
        Route::post('users/{user}', [DashboardAdminUserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [DashboardAdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('user-roles/permissions', [DashboardAdminUserRoleController::class, 'permissions'])->name('user-roles.permissions');
        // Route::apiResource('user-roles', DashboardAdminUserRoleController::class);
        Route::get('user-roles', [DashboardAdminUserRoleController::class, 'index'])->name('user-roles.index');
        Route::post('user-roles', [DashboardAdminUserRoleController::class, 'store'])->name('user-roles.store');
        Route::get('user-roles/{user_role}', [DashboardAdminUserRoleController::class, 'show'])->name('user-roles.show');
        Route::post('user-roles/{user_role}', [DashboardAdminUserRoleController::class, 'update'])->name('user-roles.update');
        Route::delete('user-roles/{user_role}', [DashboardAdminUserRoleController::class, 'destroy'])->name('user-roles.destroy');

        Route::get('settings/user-roles', [DashboardAdminSettingController::class, 'userRoles'])->name('settings.user-roles');
        Route::get('settings/languages', [DashboardAdminSettingController::class, 'languages'])->name('settings.languages');
        Route::get('settings/general', [DashboardAdminSettingController::class, 'getGeneral'])->name('settings.get.general');
        Route::post('settings/general', [DashboardAdminSettingController::class, 'setGeneral'])->name('settings.set.general');
        Route::get('settings/seo', [DashboardAdminSettingController::class, 'getSeo'])->name('settings.get.seo');
        Route::post('settings/seo', [DashboardAdminSettingController::class, 'setSeo'])->name('settings.set.seo');
        Route::get('settings/appearance', [DashboardAdminSettingController::class, 'getAppearance'])->name('settings.get.appearance');
        Route::post('settings/appearance', [DashboardAdminSettingController::class, 'setAppearance'])->name('settings.set.appearance');
        Route::get('settings/localization', [DashboardAdminSettingController::class, 'getLocalization'])->name('settings.get.localization');
        Route::post('settings/localization', [DashboardAdminSettingController::class, 'setLocalization'])->name('settings.set.localization');
        Route::get('settings/authentication', [DashboardAdminSettingController::class, 'getAuthentication'])->name('settings.get.authentication');
        Route::post('settings/authentication', [DashboardAdminSettingController::class, 'setAuthentication'])->name('settings.set.authentication');
        Route::get('settings/outgoing-mail', [DashboardAdminSettingController::class, 'getOutgoingMail'])->name('settings.get.outgoingMail');
        Route::post('settings/outgoing-mail', [DashboardAdminSettingController::class, 'setOutgoingMail'])->name('settings.set.outgoingMail');
        Route::get('settings/logging', [DashboardAdminSettingController::class, 'getLogging'])->name('settings.get.logging');
        Route::post('settings/logging', [DashboardAdminSettingController::class, 'setLogging'])->name('settings.set.logging');
        Route::get('settings/captcha', [DashboardAdminSettingController::class, 'getCaptcha'])->name('settings.get.captcha');
        Route::post('settings/captcha', [DashboardAdminSettingController::class, 'setCaptcha'])->name('settings.set.captcha');

        Route::post('languages/sync', [DashboardAdminLanguageController::class, 'sync'])->name('languages.sync');
        // Route::apiResource('languages', DashboardAdminLanguageController::class);
        Route::get('languages', [DashboardAdminLanguageController::class, 'index'])->name('languages.index');
        Route::post('languages', [DashboardAdminLanguageController::class, 'store'])->name('languages.store');
        Route::get('languages/{language}', [DashboardAdminLanguageController::class, 'show'])->name('languages.show');
        Route::post('languages/{language}', [DashboardAdminLanguageController::class, 'update'])->name('languages.update');
        Route::delete('languages/{language}', [DashboardAdminLanguageController::class, 'destroy'])->name('languages.destroy');
    });
});
