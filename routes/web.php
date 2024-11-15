<?php
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;

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

  // Clear application cache:
  Route::get('/notification', function() {
    Artisan::call('make:notification alerts --markdown=alerts');
    Artisan::call('migrate');
    return 'Artisan command generated.';
});


// Clear application cache:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function() {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
     Artisan::call('config:cache');
     return 'Config cache has been cleared';
}); 

// Clear view cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});
// Home page
Route::get('/', [CustomerReviewController::class, 'homepage'])->name('frontend.index');

Route::get('/privacy/policy', [AdminController::class, 'privacyPolicy'])->name('privacy.policy');

Route::post('/', [CustomerReviewController::class, 'submit'])->name('customer_review');
// Menu page
Route::get('/menu', [MenuController::class, 'menu'])->name('frontend.menu');

Route::get('/menu/category/{category?}', [MenuController::class, 'showCategorymenu'])->name('frontend.menu.category');

Route::get('/check-stock', [MenuController::class, 'checkStock'])->name('check.stock');

// Route for submitting the registarion form
Route::get('/register.php', [RegistrationController::class, 'registration'])->name('signup');

Route::post('/register.php', [RegistrationController::class, 'adminRegistration'])->name('register.submit');

// verify the token
Route::get('verify/{token}', [RegistrationController::class, 'verify']);

// Route for displaying the login form
Route::get('/auth-login.php', [RegistrationController::class, 'showLoginForm'])->name('login');

// Route for submitting the login form
Route::post('/auth-login', [RegistrationController::class, 'authenticate'])->name('login.submit');

// Forget password
Route::get('/respassCode', [RegistrationController::class, 'user_reset_password'])->name('userpassword');

Route::post('/respassCode', [RegistrationController::class, 'forget_password'])->name('forget_password');

// reset password confirmation after email

Route::get('reset/{token}', [RegistrationController::class, 'resetmail']);

Route::post('reset/{token}', [RegistrationController::class, 'postreset']);

// middle ware group for admin panel
Route::middleware(['auth_admin', 'lowstock', 'checkSessionId'])->group(function () {
    //,'admin_auth'
    Route::get('/admin-dashboard', [LoginController::class, 'adminDashboard'])->name('dashboard');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // for reviews page
    Route::get('/customer-reviews', [CustomerReviewController::class, 'user_reviews'])->name('reviews');

    // for product page
    Route::get('/products', [ProductController::class, 'products'])->name('products');

    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories']);

    Route::post('/products', [ProductController::class, 'addproducts'])->name('addproducts');

    // Stock page
    Route::get('/in-stock', [ProductController::class, 'instock'])->name('instock');

    Route::get('edit-products/{uuid}', [ProductController::class, 'edit'])->name('editproducts');

    Route::post('update-products', [ProductController::class, 'updateproduct'])->name('products.update');
     
    Route::get('soft/product/delete/{uuid}', [ProductController::class, 'deleteproduct'])->name('productsoft.delete');
    // hide product
    Route::get('product/delete/{uuid}', [ProductController::class, 'hideproduct'])->name('hide.delete');

    Route::get('/hide-products', [ProductController::class, 'unhideproducts'])->name('unhideproducts');

    Route::get('/unhide/{uuid}', [ProductController::class, 'unhide'])->name('unhide.delete');


    Route::get('/out-of-stock', [ProductController::class, 'outstock'])->name('outstock');

    // for reset passowrd
    Route::get('/reset-password', [UserController::class, 'resetPassword'])->name('reset');

    Route::post('/reset-password', [UserController::class, 'change_Password'])->name('reset.password');

    //   for order page
    Route::get('/user-order.php', [UserController::class, 'userorder'])->name('order');

    Route::get('/user-order/{id}', [UserController::class, 'updateOrder'])->name('completeorder');

    Route::get('/user-order-cancel/{id}', [UserController::class, 'user_order_cancel'])->name('ordercancel');

    Route::get('/check-newreviews', [CustomerReviewController::class, 'checkNewReviews']);

    Route::get('/check-neworders', [CustomerReviewController::class, 'checkNewOrders']);

    //    For Complete order 
    Route::get('/completed-order', [UserController::class, 'completedOrder'])->name('completedorder');

    //    For Cancelled order 
    Route::get('/Cancel-order', [UserController::class, 'CancelOrder'])->name('Cancelorder');

    // for user
    Route::get('/new/user', [UserController::class, 'user_profile'])->name('user.profile');

    Route::get('/disable/user/{id}', [AdminController::class, 'disableUser'])->name('disable.user');

    Route::get('/enable/user/{id}', [AdminController::class, 'enableUser'])->name('enable.user');

    Route::get('/monthly-earnings', [AdminController::class, 'calculateMonthlyEarnings'])->name('monthly-earnings');

    Route::get('/daily-orders-and-earnings', [AdminController::class, 'getDailyOrdersAndEarnings']);
    
    Route::get('/admin', [AdminController::class, 'admin_detail'])->name('admindetail');

    Route::get('/admin', [AdminController::class, 'admin_detail'])->name('admindetail');

    // catgeory
    Route::get('/category', [CategoryController::class, 'show_category'])->name('showcategory');

    Route::post('/add/category', [CategoryController::class, 'add_new_category'])->name('addnewcategory');

    // Route::get('/category', [CategoryController::class, 'show_category'])->name('showcategory');

    Route::get('/add/category', [CategoryController::class, 'add_category'])->name('addcategory');
    //   edit main category
    Route::get('/category/{id}', [CategoryController::class, 'edit_category'])->name('editcategory');
    //   update main category data
    Route::post('/category/{id}/update', [CategoryController::class, 'update_main_category'])->name('editmaincategory');

    // delete category
    Route::get('/category/{id}/delete', [CategoryController::class, 'delete_main_category'])->name('deletemaincategory');



    //    sub category
    Route::get('/sub/category', [CategoryController::class, 'show_sub_category'])->name('showsubcategory');

    //  show sub category
    Route::get('/new/sub/category', [CategoryController::class, 'add_sub_category'])->name('addsubcategory');
    //  add new category
    Route::post('/new/sub/category', [CategoryController::class, 'add_new_sub_category'])->name('addnewsubcategory');

    // update subcategory
    Route::get('/sub/category/{id}', [CategoryController::class, 'edit_sub_category'])->name('editsubcategory');

    Route::post('/sub/category/{id}/update', [CategoryController::class, 'update_sub_category'])->name('editsubcategory.update');
    //    delete sub category
    Route::get('/sub/category/{id}/delete', [CategoryController::class, 'delete_sub_category'])->name('deletesubcategory');
    // Payemnt method
    Route::get('/payment/method/', [PaymentMethodController::class, 'show_payment_method'])->name('showpayment.method');

    Route::get('add/payment/method/', [PaymentMethodController::class, 'new_payment_method'])->name('newpayment.method');

    Route::post('add/payment/method/', [PaymentMethodController::class, 'add_payment_method'])->name('addpayment.method');

    Route::get('edit/payment/{id}', [PaymentMethodController::class, 'edit_payment_method'])->name('editpayment.method');

    Route::post('edit/payment/{id}/update', [PaymentMethodController::class, 'update_payment_method'])->name('updatepayment.method');

    Route::get('edit/payment/{id}/delete', [PaymentMethodController::class, 'delete_payment_method'])->name('deletepayment.method');

    // for user profile to edit it
    Route::get('/authenticated/user' , [AdminController::class, 'Show_Authenticated_User'])->name('Authenticated.user');

    Route::get('edit/authenticated/user/{id}' , [AdminController::class, 'edit_Authenticated_User'])->name('editAuthenticated.user');

    Route::post('update/authenticated/user' , [AdminController::class, 'update_Authenticated_User'])->name('updateAuthenticated.user');
});



Route::middleware(['auth_user', 'checkSessionId', 'check.user.status'])->group(function () {

    Route::get('/user-profile', [UserController::class, 'userprofile'])->name('userprofile');

    Route::get('/edit/user-profile/{user_id}', [UserController::class, 'edit_user_profile'])->name('change.userprofile');

    Route::post('/update/user-profile', [UserController::class, 'update_user_Profile'])->name('update.userprofile');

    Route::get('/user/order/{uuid}', [UserController::class, 'confirmationorder'])->name('confirmationorder');

    Route::post('/user/order', [UserController::class, 'confirmorder'])->name('confirm.order');

    Route::get('/order/history', [UserController::class, 'orderhistory'])->name('orderhistory');

    Route::get('/get-payment-methods-and-details', [PaymentMethodController::class, 'getPaymentMethodsAndDetails']);

    // Route::get('/check-order-status',[UserController::class, 'checkOrderStatus'])->name('check-order-status');

    Route::get('/user/logout', [LoginController::class, 'userlogout'])->name('user.logout');
});
