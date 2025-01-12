<?php

use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade as PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login/staff',                                 [App\Http\Controllers\Staff\StaffController::class, 'login']);
Route::get('/test-pdf', function () {
    $pdf = PDF::loadHTML('<h1>Hello World</h1>');
    return $pdf->download('test.pdf');
});

//--------------------------------------Admin------------------------------------------

//AdminController
Route::get('/login/admin',                                 [App\Http\Controllers\Admin\AdminController::class, 'loginForm'])->name('login/admin');
Route::post('/login/admin',                                [App\Http\Controllers\Admin\AdminController::class, 'login']);
Route::post('/logout/admin',                               [App\Http\Controllers\Admin\AdminController::class, 'logout']);


Route::middleware('admin')->group(function () {
//AdminController
Route::get('/admin/dashboard',                             [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);

//UserManagementController
Route::get('/admin/userManagement/userList',               [App\Http\Controllers\Admin\UserManagementController::class, 'userList']);
Route::get('/admin/userManagement/user_update/{id}',       [App\Http\Controllers\Admin\UserManagementController::class, 'user_update']);
Route::get('/admin/userManagement/user_delete/{id}',       [App\Http\Controllers\Admin\UserManagementController::class, 'user_delete']);
Route::post('/admin/userManagement/updateUserDetails',     [App\Http\Controllers\Admin\UserManagementController::class, 'updateUserDetails']);

//CategoryManagementController
Route::get('/admin/categoryManagement/categoryList',       [App\Http\Controllers\Admin\CategoryManagementController::class, 'categoryList']);
Route::get('/admin/categoryManagement/addCategory',        [App\Http\Controllers\Admin\CategoryManagementController::class, 'addCategory']);
Route::post('/admin/categoryManagement/storeCategory',     [App\Http\Controllers\Admin\CategoryManagementController::class, 'storeCategory']);
Route::get('/admin/deleteCategory/{id}',                   [App\Http\Controllers\Admin\CategoryManagementController::class, 'deleteCategory']);

//Staff_Management
Route::get('/admin/staffManagement/addStaff',              [App\Http\Controllers\Admin\StaffManagementController::class, 'addStaff']);
Route::post('/admin/staffManagement/storeStaff',           [App\Http\Controllers\Admin\StaffManagementController::class, 'storeStaff']);
Route::get('/admin/staffManagement/staffList',             [App\Http\Controllers\Admin\StaffManagementController::class, 'staffList']);
Route::get('/admin/deleteStaff/{id}',                      [App\Http\Controllers\Admin\StaffManagementController::class, 'deleteStaff']);
Route::get('/admin/staffManagement/updateStaff/{id}',      [App\Http\Controllers\Admin\StaffManagementController::class, 'updateStaff']);
Route::post('/admin/staffManagement/updateStaffDetails',   [App\Http\Controllers\Admin\StaffManagementController::class, 'updateStaffDetails']);


});






//--------------------------------------Customer--------------------------------------------


Route::get('/',                                            [App\Http\Controllers\Customer\CustomerController::class, 'welcome'])->name('/');

//CustomerController
Route::post('/customer/register',                           [App\Http\Controllers\Customer\CustomerController::class, 'register']);
Route::post('/login/customer',                              [App\Http\Controllers\Customer\CustomerController::class, 'login']);
Route::post('/logout/customer',                             [App\Http\Controllers\Customer\CustomerController::class, 'logout']);
Route::get('/about',                                        [App\Http\Controllers\Customer\CustomerController::class, 'about']);
Route::get('/contact',                                      [App\Http\Controllers\Customer\CustomerController::class, 'contact']);


//ItemController
Route::get('/product/{id}',                                 [App\Http\Controllers\Customer\ItemController::class, 'productPage'])->name('product.show');
Route::post('/product/{id}/inquiry',                        [App\Http\Controllers\Customer\ItemController::class, 'inquiryStore'])->name('product.inquiry.store');
Route::post('/product/{item_ID}/{seller_ID}/review', [App\Http\Controllers\Customer\ItemController::class, 'storeReview'])->name('product.review.store');

Route::get('/shop/{category_slug}',                     [App\Http\Controllers\Customer\ItemController::class, 'showCategory']);
Route::get('/live-search',                     [App\Http\Controllers\Customer\ItemController::class, 'liveSearch'])->name('live.search');


Route::middleware('customer')->group(function () {
//SellerController
Route::get('/seller/registration',                          [App\Http\Controllers\Customer\SellerController::class, 'sellerRegistration']);
Route::get('/seller/registrationAgreed',                    [App\Http\Controllers\Customer\SellerController::class, 'registrationAgreed']);
Route::get('/seller/reports/mostDemandReport',              [App\Http\Controllers\Customer\SellerController::class, 'mostDemandReport']);
Route::get('/seller/reports/leastDemandReport',             [App\Http\Controllers\Customer\SellerController::class, 'leastDemandReport']);
Route::get('/seller/reports/incomeReport',                  [App\Http\Controllers\Customer\SellerController::class, 'incomeReport'])->name('seller.incomeReport');


//ItemController
Route::post('/addToCart',                                   [App\Http\Controllers\Customer\ItemController::class, 'addToCart']);
Route::get('/viewCart',                                     [App\Http\Controllers\Customer\ItemController::class, 'viewCart']);
Route::get('/deleteCartItems/{id}',                         [App\Http\Controllers\Customer\ItemController::class, 'deleteCartItems']);
Route::post('/updateCartSize',                              [App\Http\Controllers\Customer\ItemController::class, 'updateCartSize']);
Route::post('/updateQuantity',                              [App\Http\Controllers\Customer\ItemController::class, 'updateQuantity']);
Route::post('/checkout',                                    [App\Http\Controllers\Customer\ItemController::class, 'checkout']);
Route::post('/pay',                                         [App\Http\Controllers\Customer\ItemController::class, 'pay']);
Route::post('/addToWishlist',                               [App\Http\Controllers\Customer\ItemController::class, 'addToWishlist']);
Route::get('/wishList',                                     [App\Http\Controllers\Customer\ItemController::class, 'viewWishList']);
Route::get('/removeWishlistItems/{id}',                     [App\Http\Controllers\Customer\ItemController::class, 'removeWishlistItems']);



//CustomerController
Route::get('/userDashboard',                                [App\Http\Controllers\Customer\CustomerController::class, 'userDashboard']);
Route::get('/orderList',                                    [App\Http\Controllers\Customer\CustomerController::class, 'orderList']);
 
});

Route::middleware('seller')->group(function () {
//SellerController
Route::get('/seller/dashboard',                             [App\Http\Controllers\Customer\SellerController::class, 'dashboard']);
Route::get('/seller/itemManagement/itemList',               [App\Http\Controllers\Customer\SellerController::class, 'itemList']);
Route::get('/seller/itemManagement/addItem',                [App\Http\Controllers\Customer\SellerController::class, 'addItem']);
Route::post('/seller/itemManagement/storeItem',             [App\Http\Controllers\Customer\SellerController::class, 'storeItem']);
Route::get('/seller/itemManagement/getSubCategories',       [App\Http\Controllers\Customer\SellerController::class, 'getSubCategories']);
Route::get('/seller/deleteItem/{id}',                       [App\Http\Controllers\Customer\SellerController::class, 'deleteItem']);
Route::get('/seller/categoryManagement/orderList',          [App\Http\Controllers\Customer\SellerController::class, 'orderList']);
Route::get('/seller/itemManagement/updateItem/{id}',        [App\Http\Controllers\Customer\SellerController::class, 'updateItem']);
Route::post('/seller/itemManagement/updateItemDetails',     [App\Http\Controllers\Customer\SellerController::class, 'updateItemDetails']);
Route::get('/seller/itemManagement/inquiries',              [App\Http\Controllers\Customer\SellerController::class, 'inquiries']);
Route::post('/seller/itemManagement/saveReply',             [App\Http\Controllers\Customer\SellerController::class, 'saveReply'])->name('saveReply');
Route::get('/seller/itemManagement/reviews',                [App\Http\Controllers\Customer\SellerController::class, 'reviews']);


});


