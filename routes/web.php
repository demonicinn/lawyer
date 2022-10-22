<?php

use Illuminate\Support\Facades\Route;


//...folders
use App\Http\Controllers\Admin;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Lawyer;
use App\Http\Controllers\User;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ScheduleConsultationController;
use App\Http\Controllers\ZoomController;





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


//cronjobs
Route::group(['prefix' => 'cron'], function () {
    Route::get('/3days', function () {
        Artisan::call('case:3days');
        return 'done';
    });
    Route::get('/reminder1day', function () {
        Artisan::call('reminder:1day');
        return 'done';
    });
    Route::get('/reminder1hour', function () {
        Artisan::call('reminder:1hour');
        return 'done';
    });
    Route::get('/rating6months', function () {
        Artisan::call('rating:6months');
        return 'done';
    });
    Route::get('/lawyer-stripe', function () {
        Artisan::call('lawyers:account');
        return 'done';
    });
    Route::get('/refund-amount', function () {
        Artisan::call('refund.amount');
        return 'done';
    });
    Route::get('/transfer-amount', function () {
        Artisan::call('transfer.amount');
        return 'done';
    });

    //....
    Route::get('/hourly', function () {
        Artisan::call('reminder:1hour');
        return 'done';
    });

    Route::get('/daily', function () {
        Artisan::call('case:3days');
        Artisan::call('reminder:1day');
        Artisan::call('transfer.amount');
        Artisan::call('refund.amount');
        Artisan::call('lawyers:account');
        Artisan::call('rating:6months');
        return 'done';
    });

});








//home
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/home', [PagesController::class, 'home']);

Route::get('/narrow-down-candidates', [PagesController::class, 'narrowDown'])->name('narrow.down');
Route::get('/narrow-down-litigations', [PagesController::class, 'litigations'])->name('narrow.litigations');
Route::get('/narrow-down-contracts', [PagesController::class, 'contracts'])->name('narrow.contracts');

Route::get('/narrow-lawyers', [PagesController::class, 'lawyers'])->name('lawyers');
Route::get('/narrow-lawyers/{user}', [PagesController::class, 'lawyerShow'])->name('lawyer.show');
Route::get('/about', [PagesController::class, 'about'])->name('about');




// schedule consultation
Route::get('/schedule/consultation/{id}', [ScheduleConsultationController::class, 'index'])->name('schedule.consultation');



//------------------------------------------------------
//------------------------After Login-------------------
//------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    //..common consultations


    //..reschedule boooking
    Route::get('/reschedule/booking/{id}', [CommonController::class, 'reschedule'])->name('reschedule.booking');

    //..upcoming
    Route::get('upcoming', [CommonController::class, 'consultations'])->name('consultations.upcoming');
    Route::post('upcoming/{id}/cancel', [CommonController::class, 'consultationsCancel'])->name('consultations.upcoming.cancel');

    Route::post('/reshedule/{id}', [CommonController::class, 'resheduleConsultations'])->name('reshedule.consultation');
    //..complete
    Route::get('complete', [CommonController::class, 'completeConsultations'])->name('consultations.complete');

    Route::post('/add/note/{id}', [CommonController::class, 'addNote'])->name('add.note');
    Route::post('/edit/note/{id}', [CommonController::class, 'editNote'])->name('edit.note');


    Route::post('/accept/case/{id}', [CommonController::class, 'acceptCase'])->name('accept.case');
    Route::post('/decline/case/{id}', [CommonController::class, 'declineCase'])->name('decline.case');


    //..accepted
    Route::get('accepted', [CommonController::class, 'acceptedConsultations'])->name('consultations.accepted');


    //feed
    //meeting
    Route::get('/meeting/start', [ZoomController::class, 'meet'])->name('zoom.meet');
    Route::get('/meeting/{id}', [ZoomController::class, 'index'])->name('zoom');
    Route::get('/meeting/{id}/leave', [ZoomController::class, 'leave'])->name('zoom.leave');


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

        Route::post('/laywer/status/{id}', [CommonController::class, 'deActiveLawyer'])->name('admin.deactive.lawyer');

        Route::post('/accept/lawyer/{id}', [CommonController::class, 'acceptLawyer'])->name('admin.accept.lawyer');

        Route::post('/declined/lawyer/{id}', [CommonController::class, 'declinedLawyer'])->name('admin.declined.lawyer');


        //...users
        Route::get('/user/view/{id}', [CommonController::class, 'viewUserDetails'])->name('admin.user.view');

        Route::get('/transactions', [CommonController::class, 'adminTransactions'])->name('admin.transactions');

        //...lawyers
        Route::get('/lawyers', function () {
            $title = array(
                'title' => 'Lawyers',
                'active' => 'lawyers',
            );

            return view('admin.lawyers.index', compact('title'));
        })->name('admin.lawyers.index');

        //...clients

        Route::get('/users', function () {
            $title = array(
                'title' => 'Clients',
                'active' => 'clients',
            );
            return view('admin.users.index', compact('title'));
        })->name('admin.users.index');



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
            Route::post('/profile/bank', [Lawyer\ProfileController::class, 'saveBank'])->name('lawyer.profile.bank');
            Route::post('/profile/bank-connect', [Lawyer\ProfileController::class, 'connectedAccount'])->name('lawyer.bank.connect');


            Route::get('/banking-info-error', [Lawyer\ProfileController::class, 'bankingInfoError'])->name('lawyer.banking.error');
            Route::get('/banking-info', [Lawyer\ProfileController::class, 'bankingInfoSuccess'])->name('lawyer.banking.success');
            Route::post('/banking-info/store', [Lawyer\ProfileController::class, 'bankingInfoStore'])->name('lawyer.banking.store');


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


    //client

    // i replace client to user bz page crashed when user direactly login to web. @gurpreet sir
    Route::group(['middleware' => ['role:user']], function () {

        Route::group(['prefix' => 'user'], function () {
            //...dashboard
            Route::get('/', [User\DashboardController::class, 'index'])->name('user.dashboard');


            //...profile
            Route::get('/profile', [User\ProfileController::class, 'index'])->name('user.profile');
            Route::post('/profile/update', [User\ProfileController::class, 'update'])->name('user.profile.update');
            Route::post('/profile/submit', [User\ProfileController::class, 'submit'])->name('user.profile.submit');

            //...saved lawyer
            Route::get('/saved/lawyer', [User\DashboardController::class, 'savedLawyer'])->name('user.saved.lawyer');
            Route::get('/save/lawyer/{id}', [PagesController::class, 'saveLaywer'])->name('user.save.lawyer');
            Route::get('/lawyer/{id}/remove', [PagesController::class, 'removeLaywer'])->name('user.lawyer.remove');


            Route::get('review/{id}', [User\ReviewController::class, 'index'])->name('review.lawyer');
            Route::post('review/{id}/store', [User\ReviewController::class, 'store'])->name('review.store');

        });

        Route::get('thank-you/{id}', [CommonController::class, 'thankYou'])->name('thankYou');

        

    });
});
