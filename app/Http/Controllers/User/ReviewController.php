<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\User;

class ReviewController extends Controller
{
    //
    use LivewireAlert;
    
    public function index(Request $request)
    {
        $title = array(
            'title' => 'Rate your consultation',
            'active' => 'review',
        );

        $lawyer = User::findOrFail(decrypt($request->id));

        return view('user.review.index', compact('title', 'lawyer'));
    }



}
