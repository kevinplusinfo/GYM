<?php

use Illuminate\Support\Facades\Route;
#Admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\Admin\PlanFeatureController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EcomController;
use App\Http\Controllers\Admin\AdminFlavorController;
use App\Http\Controllers\Admin\AdminFeedbackController;
use App\Http\Controllers\Admin\AdminAppointmentController;

#customer
use App\Http\Controllers\Customer\GalleryController;
use App\Http\Controllers\Customer\IndexController;
use App\Http\Controllers\Customer\BlogController;
use App\Http\Controllers\Customer\PlanController;
use App\Http\Controllers\Customer\PagesController;
use App\Http\Controllers\Customer\ClassController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TrainerController;
use App\Http\Controllers\Customer\FeedbackController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\HealthPlanController;



    Route::view('admin', 'Admin.auth.login')->name('login-view');  
    Route::post('login', [AdminAuthController::class, 'authenticate'])->name('login');

    Route::middleware('checkAdmin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

            Route::prefix('dashbord')->group(function(){
                Route::get('/', [DashbordController::class, 'index'])->name('dashbord');
            });

            Route::prefix('ecom')->group(function() {
                Route::get('/', [EcomController::class, 'index'])->name('ecom.product');
                Route::get('/form', [EcomController::class, 'form'])->name('ecom.product.form');
                Route::get('/orders', [EcomController::class, 'orders'])->name('ecom.orders');
                Route::get('/details', [EcomController::class, 'getOrderDetails'])->name('ecom.getOrderDetails');
                Route::get('/cart', [EcomController::class, 'cartdetail'])->name('ecom.cart');
                Route::get('cart/details', [EcomController::class, 'getCartDetails'])->name('admin.cart.details');
                
                Route::prefix('flavor')->group(function() { 
                    Route::get('/flavors', [AdminFlavorController::class, 'index'])->name('flavors.index');
                    Route::get('/form/{id?}', [AdminFlavorController::class, 'form'])->name('flavors.form');
                    Route::post('/save/{id?}', [AdminFlavorController::class, 'save'])->name('flavors.save');
                    Route::delete('/delete/{id}', [AdminFlavorController::class, 'destroy'])->name('flavors.destroy');
                });

            });
    
            Route::prefix('user')->group(function(){
                Route::get('/', [UserController::class, 'index'])->name('admin.user');
            });

            Route::prefix('gallery')->group(function() {
                Route::get('/', [AdminGalleryController::class, 'gallery'])->name('gallery.gallery');
                Route::get('/form', [AdminGalleryController::class, 'form'])->name('gallery.form');
                Route::post('/uplode', [AdminGalleryController::class, 'uplode'])->name('gallery.uplode');
                Route::post('/uplode/{id?}', [AdminGalleryController::class, 'uplode'])->name('gallery.xyz');
                Route::get('/update/{id}', [AdminGalleryController::class, 'update'])->name('gallery.update');
                Route::get('/delete/{id}', [AdminGalleryController::class, 'delete'])->name('gallery.delete');
            });

            Route::prefix('blog')->group(function(){
                Route::get('/', [AdminBlogController::class, 'blog'])->name('blog.blog');
                Route::get('/form', [AdminBlogController::class, 'form'])->name('blog.form');
                Route::post('/add', [AdminBlogController::class, 'add'])->name('blog.add');
                Route::post('/add/{id?}', [AdminBlogController::class, 'add'])->name('add.uplode');
                Route::get('/update/{id}', [AdminBlogController::class, 'update'])->name('blog.update');
                Route::get('/delete/{id}', [AdminBlogController::class, 'delete'])->name('blog.delete');
            });    

            Route::prefix('plan')->group(function(){
                Route::get('/', [AdminPlanController::class, 'plan'])->name('plan.plan');
                Route::get('/form', [AdminPlanController::class, 'form'])->name('plan.form');
                Route::get('/form/{id}', [AdminPlanController::class, 'form'])->name('plan.update');
                // Route::post('/add', [AdminPlanController::class, 'add'])->name('plan.add');
                Route::post('/add/{id?}', [AdminPlanController::class, 'add'])->name('plan.add');
                Route::get('/delete/{id?}', [AdminPlanController::class, 'delete'])->name('plan.delete');


                Route::prefix('Feature')->group(function () {
                    Route::get('/', [PlanFeatureController::class, 'index'])->name('Feature.plan');
                    Route::post('/add/{id?}', [PlanFeatureController::class, 'add'])->name('Feature.add'); 
                    Route::get('/delete/{id}', [PlanFeatureController::class, 'delete'])->name('Feature.delete');
                });
                
            });

            Route::prefix('class')->group(function(){
                Route::get('/', [AdminClassController::class, 'index'])->name('class.class');
                Route::get('/form', [AdminClassController::class, 'form'])->name('class.form');
                Route::get('/form/{id}', [AdminClassController::class, 'form'])->name('class.update');
                Route::post('/add', [AdminClassController::class, 'add'])->name('class.add');
                Route::post('/add/{id}', [AdminClassController::class, 'add'])->name('class.xyz');
                Route::get('/delete/{id}', [AdminClassController::class, 'delete'])->name('class.delete');
            });

            Route::prefix('product')->group(function(){
                Route::get('/', [EcomController::class, 'index'])->name('product.index');
                Route::get('/form', [EcomController::class, 'form'])->name('product.form');
                Route::get('/form/{id?}', [EcomController::class, 'form'])->name('product.update');
                Route::post('/save/{id?}', [EcomController::class, 'save'])->name('product.save');
                // Route::post('/save/{id}', [EcomController::class, 'save'])->name('product.xyz');
                Route::post('/upload-images', [EcomController::class, 'uploadImages'])->name('product.upload.images');

                Route::get('/delete/{id}', [EcomController::class, 'delete'])->name('product.delete');
                Route::get('/delete-image', [EcomController::class, 'deleteImage'])->name('delete.image');
                
            });
            
            Route::prefix('trainer')->group(function(){
                Route::get('/', [AdminTeamController::class, 'index'])->name('trainer.index');
                Route::get('/form', [AdminTeamController::class, 'form'])->name('trainer.form');
                Route::get('/form/{id}', [AdminTeamController::class, 'form'])->name('trainer.edit');
                Route::post('/store/{id?}', [AdminTeamController::class, 'store'])->name('trainer.store');
                Route::get('/delete/{id}', [AdminTeamController::class, 'delete'])->name('trainer.delete');
            });

            Route::prefix('setting')->group(function(){
                    Route::get('/index', [SettingController::class, 'index'])->name('setting');
                    Route::get('/weblogo', [SettingController::class, 'weblogo'])->name('setting.weblogo');
                    Route::get('/contact', [SettingController::class, 'contact'])->name('setting.contact');
                    Route::get('/favicon', [SettingController::class, 'favicon'])->name('setting.favicon');
                    Route::get('/sociallink', [SettingController::class, 'sociallink'])->name('setting.sociallink');
                    Route::get('/aboutas', [SettingController::class, 'aboutas'])->name('setting.aboutas');

                    Route::post('/storeaboutas', [SettingController::class, 'storeaboutas'])->name('setting.storeaboutas');
                    Route::post('/storesocial', [SettingController::class, 'storesocial'])->name('setting.storesocial');
                    Route::post('/storecontact', [SettingController::class, 'storecontact'])->name('setting.storecontact');
                    Route::post('/save', [SettingController::class, 'storeOrUpdate'])->name('setting.save');
            });

            Route::prefix('feedback')->group(function(){
                Route::get('/', [AdminFeedbackController::class, 'index'])->name('userfeedback');
            });

            Route::prefix('appointment')->group(function(){
                Route::get('/', [AdminAppointmentController::class, 'index'])->name('appointment.index');
            });
        });
    });

    Route::get('/', [IndexController::class, 'index'])->name('index.gallery');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/plan', [PlanController::class, 'index'])->name('plan');
    Route::get('/contact-as', [PagesController::class, 'contact'])->name('contact');
    Route::get('/add-contact', [PagesController::class, 'addcontact'])->name('add.contact');
    Route::get('/class', [ClassController::class, 'class'])->name('class');
    Route::get('/class/{id}', [ClassController::class, 'detail'])->name('class.detail');
    Route::get('/team', [TrainerController::class, 'index'])->name('team');
    Route::get('/about-as', [PagesController::class, 'about'])->name('about');
    Route::get('/services', [PagesController::class, 'services'])->name('services');
    Route::get('/timetable', [PagesController::class, 'timetable'])->name('timetable');


    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');
    });

    // Authentication Routes
    Route::get('clogin', [AuthController::class, 'showLoginForm'])->name('clogin');
    Route::post('clogin', [AuthController::class, 'login'])->name('slogin');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->name('clogout');

    Route::middleware(['checkUser'])->group(function () {
        Route::get('appointment', [AppointmentController::class, 'appointment'])->name('appointment');
        Route::post('store', [AppointmentController::class, 'store'])->name('appointment.store');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::prefix('feedback')->group(function(){
            Route::get('/', [FeedbackController::class, 'index'])->name('feedback');
            Route::post('/store', [FeedbackController::class, 'store'])->name('feedback.store');
        });

        Route::prefix('plan')->group(function () {
            Route::get('/plans', [PlanController::class, 'index'])->name('customer.plans.index');
            Route::get('/checkout/{id}', [PlanController::class, 'checkout'])->name('customer.checkout');
            Route::post('/payment', [PlanController::class, 'createOrder'])->name('customer.payment.create');
            Route::post('/store-order', [PlanController::class, 'store'])->name('customer.payment.store');
            Route::post('/verify-payment', [PlanController::class, 'verifyPayment'])->name('customer.payment.verify'); 
            Route::get('/order/{order_id}', [PlanController::class, 'purchaseplan'])->name('customer.purchase.plan'); 
        });

        Route::prefix('product')->group(function(){
            Route::post('/store/{id?}', [ProductController::class, 'store'])->name('cart.store');
            Route::get('/cart', [ProductController::class, 'cartdetail'])->name('cart.detail');
            Route::post('/remove', [ProductController::class, 'clearCart'])->name('cart.remove');
            Route::get('/checkout', [ProductController::class, 'checkout'])->name('cart.checkout');
            Route::post('/storeorder', [ProductController::class, 'placeOrder'])->name('payment.create');
            Route::post('/verify-payment', [ProductController::class, 'paymentverify'])->name('payment.verifay');
            Route::get('/purchase-product/{order_id?}', [ProductController::class, 'purchaseproduct'])->name('purchase.product');
        });

        Route::prefix('health')->group(function(){
            Route::get('/form', [HealthPlanController::class, 'index'])->name('health.form');
            Route::post('/generate-health-plan', [HealthPlanController::class, 'generatePlan'])->name('generate.health.plan');
            Route::post('/select-health-plan', [HealthPlanController::class, 'selectPlan'])->name('select.health.plan');
            Route::get('/plans/{id}', [HealthPlanController::class, 'show'])->name('plans.show');
            Route::get('/selected-plans', [HealthPlanController::class, 'showSelectedPlans'])->name('show.selected.plan');
            
        });

    });
