<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JoinTeam;

class JoinTeamController extends Controller
{
    //
    public function index()
    {
        $title = array(
            'title' => 'Join Team',
            'active' => 'joinTeam',
        );

        $data = JoinTeam::orderBy('id', 'desc')->paginate(10);

        return view('admin.joinTeam', compact('title', 'data'));
    }
}
