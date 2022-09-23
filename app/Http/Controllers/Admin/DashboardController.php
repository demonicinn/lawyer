<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Admin\Categories;
use App\Http\Livewire\Admin\Contracts;
use App\Models\Booking;
use App\Models\Litigation;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Contract;
use App\Models\Category;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $title = array(
            'title' => 'Dashboard',
            'active' => 'dashboard',
        );
        $upcomingConsul=Booking::where('is_call', 'pending')->where('reschedule', '0')->count();
        $completedConsul=Booking::where('is_call', 'completed')->where('is_accepted', '0')->count();
        $acceptedConsul=Booking::where('is_call', 'completed')->where('is_accepted', '1')->count();
   
        $user = auth()->user();
        $lawyers = User::where('role', 'lawyer')->count();
        $clients = User::where('role', 'user')->count();
        $subscriptions = Subscription::count();
        $litigations = Litigation::count();
        $contracts = Contract::count();
        $states = State::count();
        $categories = Category::count();

        return view('admin.dashboard.index', compact('user', 'title','clients', 'lawyers', 'subscriptions', 'litigations', 'contracts', 'states', 'categories','upcomingConsul','completedConsul','acceptedConsul'));
    }
}
