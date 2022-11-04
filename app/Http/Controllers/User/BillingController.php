<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\UserCard;

class BillingController extends Controller
{
    //
    use LivewireAlert;
    
    public function index()
    {
        $title = array(
            'title' => 'Billing Information',
            'active' => 'billing',
        );

        $user = auth()->user();
        $cards = UserCard::where('user_id', $user->id)->get();

        return view('user.billing.index', compact('title', 'cards'));
    }

    public function create()
    {
        $title = array(
            'title' => 'Billing Information',
            'active' => 'billing',
        );

        return view('user.billing.create', compact('title'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'card_name' => 'required',
            'expire_month' => 'required',
            'expire_year' => 'required',
            'card_number' => 'required',
        ]);

        $user = auth()->user();

        $store = new UserCard;

        $store->user_id = $user->id;
        $store->card_name = $request->card_name;
        $store->expire_month = $request->expire_month;
        $store->expire_year = $request->expire_year;
        $store->card_number = $request->card_number;
        $store->save();

      
        $this->flash('success', 'New Card Added successfully');
        return redirect()->route('user.billing.index');
    }


    public function destroy(Request $request)
    {
        $store = UserCard::findOrFail($request->id);
        $store->delete();
      
        $this->flash('success', 'Card Deleted successfully');
        return redirect()->route('user.billing.index');
    }



}