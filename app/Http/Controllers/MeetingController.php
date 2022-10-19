<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Models\ZoomMeeting;
use App\Traits\ZoomMeetingTrait;

class MeetingController extends Controller
{
    //
    use ZoomMeetingTrait;

   	const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;




    public function show($id)
    {
        $meeting = $this->get($id);

        return view('meetings.index', compact('meeting'));
    }

    public function store($date)
    {
    	//dd($date);
        return $this->create($date);

        //return redirect()->route('meetings.index');
    }

    public function update($meeting, Request $request)
    {
        $this->update($meeting->zoom_meeting_id, $request->all());

        return redirect()->route('meetings.index');
    }

    public function destroy($meeting)
    {
        
        return $this->delete($meeting->zoom_id);

        //return $this->sendSuccess('Meeting deleted successfully.');
    }

}
