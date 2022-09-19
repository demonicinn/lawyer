<?php

namespace App\Http\Livewire\Lawyer;

use App\Models\Booking;
use App\Models\Note;
use App\Notifications\RescheduleMailTOUser;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Consultations extends Component
{

    use LivewireAlert;

    public $upcomingConsultations, $completeConsultations, $cases, $authUser, $note, $BookingId;


    public function getNoteId($id)
    {
        $this->BookingId = $id;
        $this->emit('noteFormShow');
    }


    public function addNote()
    {
        $this->validate([
            'note' => 'required',
        ]);
        $saveNote = new Note;
        $saveNote->note = $this->note;
        $saveNote->booking_id = $this->BookingId;
        $saveNote->save();
        $this->alert('success', 'Note added successfully');
        $this->note = '';
        $this->emit('noteFormClose');
    }



    public function cancelBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)->with('user')->first();

        $userInfo = $booking->user;
        $booking->reschedule = '1';
        $booking->update();
        if ($booking) {
            //send reschedule mail to user
            Notification::route('mail', $userInfo->email)->notify(new RescheduleMailTOUser($booking, $userInfo));
            $this->alert('success', 'Reschedule done successfully');
        }



        $this->mount();
    }

    public function mount()
    {
        $this->authUser = auth()->user();
        $this->upcomingConsultations = Booking::where('lawyer_id', $this->authUser->id)
            ->where('booking_Date', '>=', date('Y-m-d'))
            ->where('reschedule', '0')
            ->with('user')->latest('id')->get();
        //  dd( $this->upcomingConsultations);
        $this->completeConsultations = Booking::where('lawyer_id', $this->authUser->id)->where('is_call', 'completed')->with('user','notes')->latest('id')->get();
//    dd( $this->completeConsultations );
    }

    public function render()
    {
        return view('livewire.lawyer.consultations');
    }
}
