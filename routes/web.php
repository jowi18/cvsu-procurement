<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('verify-code', [\App\Http\Controllers\VerifyCode::class, 'index'])->name('verify.code.index');
Route::post('verify-code', [\App\Http\Controllers\VerifyCode::class, 'verifyCode'])->name('verify.code.store');

Auth::routes();
Route::middleware('auth')->group(function () {
     //DASHBOARD ROUTE
    
    Route::middleware('accountSecure')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('sample-data', [App\Http\Controllers\HomeController::class, 'getRequestDepartmentCount'])->name('chart.data');
    //REQUISITION MODEL
        Route::get('requisition', [App\Http\Controllers\RequisitionController::class, 'index'])->name('requisition.index');
        Route::post('insert-purchase-request', [App\Http\Controllers\RequisitionController::class, 'insertPurchaseRequest'])->name('insert.purchase.request');
        Route::get('get-request-list', [App\Http\Controllers\ManagePurchaseRequest::class, 'getRequestList'])->name('get.purchase.request');
        Route::get('manage-purchase-request', [App\Http\Controllers\ManagePurchaseRequest::class, 'index'])->name('manage.purchase.request.index');
        Route::get('view-purchase-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'viewPurchaseRequest'])->name('view.purchase.request');
        Route::post('approve-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'approveRequest'])->name('approve.purchase.request');
        Route::get('forward-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'forwardRequest'])->name('forward.purchase.request');
        Route::post('reject-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'rejectRequest'])->name('reject.purchase.request');
        Route::get('fetch-item', [App\Http\Controllers\ManagePurchaseRequest::class, 'getItemList'])->name('get.item');
        Route::post('update-request/{item_id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'updateRequest'])->name('updating.request');
        Route::get('remove-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'removeRequest'])->name('remove.request');
        Route::post('add-item/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'addNewItem'])->name('add.item');
        Route::get('view-reason/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'viewRejection'])->name('view.reason');
        Route::get('generate-otp/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'generateOtp'])->name('generate.otp');
        Route::post('add-department-item', [App\Http\Controllers\RequisitionController::class, 'addDepartmentItem'])->name('add.item');
        Route::get('follow-up-request/{id}', [App\Http\Controllers\ManagePurchaseRequest::class, 'followUpRequest'])->name('follow.up.purchase.request');


        Route::get('manage-approve-pr', [App\Http\Controllers\ManageApprovePr::class, 'index'])->name('approve.index');
        Route::get('get-approve-pr-list', [App\Http\Controllers\ManageApprovePr::class, 'getRequestList'])->name('approve.list');
        Route::post('add-pr-attachment/{id}', [App\Http\Controllers\ManageApprovePr::class, 'addPrAttachment'])->name('add.attachment');
        Route::get('view-pr-attachment/{id}', [App\Http\Controllers\ManageApprovePr::class, 'viewPrAttachment'])->name('view.attachment');

        Route::get('manage-pmpp', [App\Http\Controllers\PmppController::class, 'index'])->name('index.pmpp');
        Route::post('submit-pmpp', [App\Http\Controllers\PmppController::class, 'addPmpp'])->name('create.pmpp');
        Route::get('get-pmpp-list', [App\Http\Controllers\PmppController::class, 'getPmppList'])->name('get.pmpp.list');
        Route::post('submit-pmpp-item/{id}', [App\Http\Controllers\PmppController::class, 'addPmppItem'])->name('create.pmppItem');
        Route::get('view-pmpp-list/{id}', [App\Http\Controllers\PmppController::class, 'viewPmppitem'])->name('view.pmpp.list');
        Route::get('approved-pmpp/{id}', [App\Http\Controllers\PmppController::class, 'approvedPmpp'])->name('approved.pmpp');
        Route::get('rejected-pmpp/{id}', [App\Http\Controllers\PmppController::class, 'rejectedPmpp'])->name('rejected.pmpp');
        Route::get('forward-pmpp/{id}', [App\Http\Controllers\PmppController::class, 'forwaredPmpp'])->name('forward.pmpp');
        Route::get('reviewed-pmpp/{id}', [App\Http\Controllers\PmppController::class, 'reviewedPmpp'])->name('review.pmpp');
        Route::get('remove-item/{id}', [App\Http\Controllers\PmppController::class, 'removeItem'])->name('remove.item');

        Route::get('pmpp-report/{year}', [App\Http\Controllers\PdfReports::class, 'index'])->name('pdf-report');
        Route::get('purchase-report/{id}', [App\Http\Controllers\PurchaseRequestReport::class, 'index'])->name('purchase-request-report');

        Route::get('manage-item', [App\Http\Controllers\ManageItemController::class, 'index'])->name('index.manage.item');
        Route::post('add-item', [App\Http\Controllers\ManageItemController::class, 'addItem'])->name('add.item');
        Route::get('get-item-list', [App\Http\Controllers\ManageItemController::class, 'getItemList'])->name('get.item.list');
        Route::get('delete-item/{id}', [App\Http\Controllers\ManageItemController::class, 'deleteItem'])->name('delete.item');
        Route::post('add-category', [App\Http\Controllers\ManageItemController::class, 'addCategory'])->name('add.category');
        Route::get('view-item/{id}', [App\Http\Controllers\ManageItemController::class, 'viewItem'])->name('view.item');
        Route::get('update-item/{id}', [App\Http\Controllers\ManageItemController::class, 'updateItem'])->name('update.item');
        Route::get('get-category-list', [App\Http\Controllers\ManageItemController::class, 'getCategoryTable'])->name('get.category');
        Route::get('view-category/{id}', [App\Http\Controllers\ManageItemController::class, 'viewCategory'])->name('view.category');
        Route::post('update-category/{id}', [App\Http\Controllers\ManageItemController::class, 'updateCategory'])->name('update.category');
        Route::get('activate-category/{id}', [App\Http\Controllers\ManageItemController::class, 'activateCategory'])->name('activate.category');
        Route::get('deactivate-category/{id}', [App\Http\Controllers\ManageItemController::class, 'deactivateCategory'])->name('deactivate.category');

        Route::get('manage-user', [App\Http\Controllers\ManageUser::class, 'index'])->name('index.user.list');
        Route::post('add-user', [App\Http\Controllers\ManageUser::class, 'addUser'])->name('add.user');
        Route::get('get-user-list', [App\Http\Controllers\ManageUser::class, 'getUserList'])->name('get.user.list');
        Route::get('deactivate-user/{id}', [App\Http\Controllers\ManageUser::class, 'deactivatedUser'])->name('deactivate.user');
        Route::get('activate-user/{id}', [App\Http\Controllers\ManageUser::class, 'activateUser'])->name('activate.user');
        Route::get('view-user/{id}', [App\Http\Controllers\ManageUser::class, 'viewUser'])->name('view.user');
        Route::post('update-user/{id}', [App\Http\Controllers\ManageUser::class, 'updateUser'])->name('update.user');
        Route::post('add-department', [App\Http\Controllers\ManageUser::class, 'addDepartment'])->name('addDepartment');
        Route::get('get-department-list', [App\Http\Controllers\ManageUser::class, 'getDepartmentTable'])->name('getDepartmentTable');
        Route::get('activate-department/{id}', [App\Http\Controllers\ManageUser::class, 'activateDepartment'])->name('activateDepartment');
        Route::get('deactivate-department/{id}', [App\Http\Controllers\ManageUser::class, 'deactivateDepartment'])->name('deactivateDepartment');
        Route::get('view-department/{id}', [App\Http\Controllers\ManageUser::class, 'viewDepartment'])->name('viewDepartment');
        Route::post('update-department/{id}', [App\Http\Controllers\ManageUser::class, 'updateDepartment'])->name('updateDepartment');

        Route::get('show-notification', [App\Http\Controllers\NotificationController::class, 'showNotification'])->name('notification.show');
        Route::get('read-notification/{id}', [App\Http\Controllers\NotificationController::class, 'readNotification'])->name('notification.read');
        Route::get('count-notification', [App\Http\Controllers\NotificationController::class, 'countNotification'])->name('notification.count');
        Route::get('get-user-data', [App\Http\Controllers\NotificationController::class, 'getUserData'])->name('get.data');

        Route::view('about', 'about')->name('about');

        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
       
        Route::get('manage-logs', [App\Http\Controllers\ManageLogsController::class, 'index'])->name('manage.logs.index');
        Route::get('get-logs-history', [App\Http\Controllers\ManageLogsController::class, 'getLogsHistory'])->name('get.logs');

    });
    
});

