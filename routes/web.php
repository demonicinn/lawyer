<?php

use Illuminate\Support\Facades\Route;


//...folders
use App\Http\Controllers\Admin;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Lawyer;

use App\Http\Controllers\PagesController;


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

Route::get('/lawyers', [PagesController::class, 'lawyers'])->name('lawyers');
Route::get('/lawyer/{user}', [PagesController::class, 'lawyerShow'])->name('lawyer.show');





//------------------------------------------------------
//------------------------After Login-------------------
//------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

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
