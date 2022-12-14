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

Route::get('/time', function () {
    dd(date('Y-m-d h:ma'));
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
        Artisan::call('refund:amount');
        return 'done';
    });
    Route::get('/transfer-amount', function () {
        Artisan::call('transfer:amount');
        return 'done';
    });
    Route::get('/auto-subscription', function () {
        Artisan::call('auto:subscription');
        return 'done';
    });
    Route::get('/auto-charge', function () {
        Artisan::call('auto:charge');
        return 'done';
    });
    Route::get('/lawyer-reviews', function () {
        Artisan::call('lawyer:reviews');
        return 'done';
    });

    //....
    Route::get('/hourly', function () {
        Artisan::call('reminder:1hour');
        Artisan::call('auto:charge');
        Artisan::call('lawyer:reviews');
        return 'done';
    });

    Route::get('/daily', function () {
        Artisan::call('case:3days');
        Artisan::call('reminder:1day');
        Artisan::call('transfer:amount');
        Artisan::call('refund:amount');
        Artisan::call('lawyers:account');
        Artisan::call('rating:6months');
        Artisan::call('auto:subscription');
        return 'done';
    });

});






 

//home
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/home', [PagesController::class, 'home']);

Route::get('/narrow-down-candidates', [PagesController::class, 'narrowDown'])->name('narrow.down');
Route::get('/narrow-down-litigations', [PagesController::class, 'litigations'])->name('narrow.litigations');
Route::get('/narrow-down-contracts', [PagesController::class, 'contracts'])->name('narrow.contracts');

Route::get('/lawyers', [PagesController::class, 'lawyers'])->name('lawyers');
Route::post('/narrow-lawyers-home', [PagesController::class, 'lawyersHome'])->name('lawyers.home');

Route::get('/profile/{slug}/{user}', [PagesController::class, 'lawyerShow'])->name('lawyer.url');
   
Route::get('/p/{user}', [PagesController::class, 'lawyerShow'])->name('lawyer.show');


Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/join-the-team', [PagesController::class, 'joinTeam'])->name('joinTeam');
Route::post('/join-the-team/store', [PagesController::class, 'joinTeamStore'])->name('joinTeamStore');


Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/terms-of-service', [PagesController::class, 'termsService'])->name('termsService');
Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
Route::get('/style-guide', [PagesController::class, 'styleGuide'])->name('styleGuide');

// schedule consultation
Route::get('/schedule/consultation/{id}', [ScheduleConsultationController::class, 'index'])->name('schedule.consultation');

Route::get('/how-to-add-lawyer-link', [PagesController::class, 'lawyerLink'])->name('lawyer.link');



//support

    Route::get('/support', function () {
        $title = array(
            'title' => 'Support',
            'active' => 'support',
        );

        return view('common.support', compact('title'));
    })->name('support');
    Route::post('/support/store', [CommonController::class, 'SupportStore'])->name('support.store');
    
    
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
    Route::post('/cancel/case/{id}', [CommonController::class, 'cancelCase'])->name('cancel.case');


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



    

    


    


    //admin
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {

        //...dashboard
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin');
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/join-team', [Admin\JoinTeamController::class, 'index'])->name('admin.joinTeam');


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
        Route::post('/subscription/offer/{id}', [CommonController::class, 'offerLawyer'])->name('admin.subscription.offer');


        //...users
        Route::get('/user/view/{id}', [CommonController::class, 'viewUserDetails'])->name('admin.user.view');

        Route::get('/transactions', [CommonController::class, 'adminTransactions'])->name('admin.transactions');


		//...seo
        Route::get('/seo', function () {
            $title = array(
                'title' => 'Seo',
                'active' => 'seo',
            );

            return view('admin.seo.index', compact('title'));
        })->name('admin.seo.index');

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

        //...state bar
        Route::get('/state-bar', function () {
            $title = array(
                'title' => 'State Bar Admissions',
                'active' => 'state-bar',
            );
            return view('admin.state_bar.index', compact('title'));
        })->name('admin.state_bar.index');

        //...categories
        Route::get('/federal-court', function () {
            $title = array(
                'title' => 'Federal Court Admissions',
                'active' => 'categories',
            );
            return view('admin.categories.index', compact('title'));
        })->name('admin.categories.index');
    });


    
	Route::post('/card/remove/{id}', [Lawyer\ProfileController::class, 'cardRemove'])->name('lawyer.card.remove');
	Route::post('/card/primary/{id}', [Lawyer\ProfileController::class, 'cardPrimary'])->name('lawyer.card.primary');

            

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


        Route::get('/booking/{booking}/{action}', [Lawyer\ProfileController::class, 'bookingConfirmData'])->name('lawyer.booking.data');
        
        
        //subscription middleware
        Route::group(['middleware' => 'subscription'], function () {

            //...profile
            Route::get('/profile', [Lawyer\ProfileController::class, 'index'])->name('lawyer.profile');
            Route::post('/profile/update', [Lawyer\ProfileController::class, 'update'])->name('lawyer.profile.update');
            Route::post('/profile/bank', [Lawyer\ProfileController::class, 'saveBank'])->name('lawyer.profile.bank');
            Route::post('/profile/bank-connect', [Lawyer\ProfileController::class, 'connectedAccount'])->name('lawyer.bank.connect');


            Route::get('/banking-info-error', [Lawyer\ProfileController::class, 'bankingInfoError'])->name('lawyer.banking.error');
            Route::get('/banking-info', [Lawyer\ProfileController::class, 'bankingInfoSuccess'])->name('lawyer.banking.success');
            Route::get('/banking-info/callback', [Lawyer\ProfileController::class, 'bankingInfoSuccessCallback'])->name('lawyer.banking.success.callback');
            Route::post('/banking-info/store', [Lawyer\ProfileController::class, 'bankingInfoStore'])->name('lawyer.banking.store');
            Route::get('/banking-info/update', [Lawyer\ProfileController::class, 'connectedAccountUpdate'])->name('lawyer.banking.update');


            Route::post('/card/store', [Lawyer\ProfileController::class, 'cardStore'])->name('lawyer.card.store');
           


            Route::post('/profile/submit', [Lawyer\ProfileController::class, 'submit'])->name('lawyer.profile.submit');

            //...profile middleware
            Route::group(['middleware' => 'profileVerified'], function () {

                //...dashboard
                Route::get('/', [Lawyer\DashboardController::class, 'portal'])->name('lawyer');
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
            Route::get('/', [User\DashboardController::class, 'index'])->name('user');
            //Route::get('/', [User\DashboardController::class, 'index'])->name('user.dashboard');


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


            //billing
            Route::prefix('billing')->group(function () {
                Route::controller(User\BillingController::class)->group(function () {
                    Route::get('/', 'index')->name('user.billing.index');
                    Route::get('/create', 'create')->name('user.billing.create');
                    Route::post('/store', 'store')->name('user.billing.store');
                    Route::get('{id}/destroy', 'destroy')->name('user.billing.destroy');
                });
            });
            
        });

        Route::get('thank-you/{id}', [CommonController::class, 'thankYou'])->name('thankYou');

        

    });
});
