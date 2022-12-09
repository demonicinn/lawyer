<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use App\Notifications\MailToLawyerForStatus;
use Illuminate\Support\Facades\Notification;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class Lawyers extends Component
{
    use LivewireAlert;

    use WithPagination;

    // public $lawyers = [];
    public $lawyerId;
    public $action, $search;
    protected $listeners = ['confirmedAction'];
    protected $paginationTheme = 'bootstrap';

    public function review($id, $action)
    {

        $this->lawyerId = $id;
        $this->action = $action;

        $this->alert('warning', 'Are you sure', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'confirmedAction',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }

    public function confirmedAction()
    {
        $data = User::findOrFail($this->lawyerId);

        if ($this->action == 'accept') {
            $data->details->is_admin_review = '1';
            $data->details->is_verified = 'yes';
            $data->details->save();

            $this->alert('success', 'Profile Accepted');
        }

        if ($this->action == 'declined') {
            $data->details->is_admin_review = '2';
            $data->details->review_request = '0';
            $data->details->save();

            $this->alert('success', 'Profile Declined');
        }

        //...send email

        Notification::route('mail', $data->email)->notify(new MailToLawyerForStatus($data, $this->action));
    }

    public function deactivate($lawyerId)
    {
        $lawyer = User::findOrFail( $lawyerId );
        $lawyer->status = '0';
        $lawyer->save();

        $this->alert('success', 'Lawyer Deactivated');
    }
    public function activate($lawyerId)
    {
        $lawyer = User::findOrFail( $lawyerId );
        $lawyer->status = '1';
        $lawyer->save();

        $this->alert('success', 'Lawyer Activated');
    }


    public function render()
    {
        $lawyers = User::where('role', 'lawyer')->where(function ($query) {
            return  $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%");
        })->latest('id')->get();

        
        return view('livewire.admin.lawyers', compact('lawyers'));
    }
}
