<?php

use Illuminate\Support\Facades\Route;


//...folders
use App\Http\Controllers\Admin;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Lawyer;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ScheduleConsultationController;



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



//flush cache
Route::get('/cache-clear', function () {
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return "Migrate";
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "storage:link";
});



//home
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/narrow-down-candidates', [PagesController::class, 'narrowDown'])->name('narrow.down');
Route::get('/narrow-down-litigations', [PagesController::class, 'litigations'])->name('narrow.litigations');
Route::get('/narrow-down-contracts', [PagesController::class, 'contracts'])->name('narrow.contracts');

Route::get('/narrow-lawyers', [PagesController::class, 'lawyers'])->name('lawyers');
Route::get('/narrow-lawyers/{user}', [PagesController::class, 'lawyerShow'])->name('lawyer.show');


// schedule consultation
Route::get('/schedule/consultation/{id}', [ScheduleConsultationController::class, 'index'])->name('schedule.consultation');



//------------------------------------------------------
//------------------------After Login-------------------
//------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    //feed
    Route::get('/feed', function () {
        $title = array(
            'title' => 'Feed',
            'active' => 'feed',
        );
        return view('common.zoom', compact('title'));
    })->name('change.feed');



    //change password
    Route::get('/change/password', function () {
        $title = array(
            'title' => 'Change Password',
            'active' => 'change.password',
        );
        return view('common.change-password', compact('title'));
    })->name('change.password');

    Route::post('/update/password', [CommonController::class, 'updatePasssword'])->name('update.password');



    //support

    Route::get('/support', function () {
        $title = array(
            'title' => 'Support',
            'active' => 'support',
        );

        return view('common.support', compact('title'));
    })->name('support');

    Route::post('/support/store', [CommonController::class, 'SupportStore'])->name('support.store');


    //admin
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {

        //...dashboard
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin');
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');


        //...profile 
        Route::get('/profile', [Admin\ProfileControlller::class, 'index'])->name('admin.profile');
        Route::post('/profile/update', [Admin\ProfileControlller::class, 'update'])->name('admin.profile.update');



        //...common view details

        Route::get('/laywer/view/{id}', [CommonController::class, 'viewlawyerDetails'])->name('admin.laywer.view');




        //...update lawyer status

        Route::post('/laywer/block/{id}', [CommonController::class, 'blockLawyer'])->name('admin.block.lawyer');

        Route::post('/laywer/deactive/{id}', [CommonController::class, 'deActiveLawyer'])->name('admin.deactive.lawyer');

        Route::post('/accept/lawyer/{id}', [CommonController::class, 'acceptLawyer'])->name('admin.accept.lawyer');

        Route::post('/declined/lawyer/{id}', [CommonController::class, 'declinedLawyer'])->name('admin.declined.lawyer');



        //...lawyers
        Route::get('/lawyers', function () {
            $title = array(
                'title' => 'Lawyers',
                'active' => 'lawyers',
            );
            return view('admin.lawyers.index', compact('title'));
        })->name('admin.lawyers.index');

        //...Litigations
        Route::get('/litigations', function () {
            $title = array(
                'title' => 'Litigations',
                'active' => 'litigations',
            );
            return view('admin.litigations.index', compact('title'));
        })->name('admin.litigations.index');

        //...contracts
        Route::get('/contracts', function () {
            $title = array(
                'title' => 'Contracts',
                'active' => 'contracts',
            );
            return view('admin.contracts.index', compact('title'));
        })->name('admin.contracts.index');

        //...states
        Route::get('/states', function () {
            $title = array(
                'title' => 'States',
                'active' => 'states',
            );
            return view('admin.states.index', compact('title'));
        })->name('admin.states.index');

        //...subscription
        Route::get('/subscriptions', function () {
            $title = array(
                'title' => 'Subscriptions',
                'active' => 'subscriptions',
            );
            return view('admin.subscriptions.index', compact('title'));
        })->name('admin.subscriptions.index');

        //...categories
        Route::get('/categories', function () {
            $title = array(
                'title' => 'Categories',
                'active' => 'categories',
            );
            return view('admin.categories.index', compact('title'));
        })->name('admin.categories.index');
    });


    //lawyer
    Route::group(['prefix' => 'lawyer', 'middleware' => ['role:lawyer']], function () {

        //...subscription
        Route::get('/subscription', function () {
            $title = array(
                'title' => 'Billing',
                'active' => 'billing',
            );
            return view('lawyer.subscription.index', compact('title'));
        })->name('lawyer.subscription');



        //...leaves

        Route::get('/leave', function () {
            $title = array(
                'title' => 'Leaves',
                'active' => 'leaves',
            );
            return view('lawyer.leave.index', compact('title'));
        })->name('lawyer.leave');

        //subscription middleware
        Route::group(['middleware' => 'subscription'], function () {

            //...profile
            Route::get('/profile', [Lawyer\ProfileController::class, 'index'])->name('lawyer.profile');
            Route::post('/profile/update', [Lawyer\ProfileController::class, 'update'])->name('lawyer.profile.update');
            Route::post('/profile/submit', [Lawyer\ProfileController::class, 'submit'])->name('lawyer.profile.submit');

            //...profile middleware
            Route::group(['middleware' => 'profileVerified'], function () {

                //...dashboard
                Route::get('/', [Lawyer\DashboardController::class, 'index'])->name('lawyer');
                Route::get('/dashboard', [Lawyer\DashboardController::class, 'index'])->name('lawyer.dashboard');

                //...
            });
        });
    });
});
