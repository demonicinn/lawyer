<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;

class Lawyers extends Component
{
	use LivewireAlert;

    public $lawyers = [];
    public $lawyerId;
    public $action;
    protected $listeners = ['confirmedAction'];

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

        if($this->action == 'accept'){
            $data->details->is_admin_review = '1';
            $data->details->is_verified = 'yes';
            $data->details->save();

            $this->alert('success', 'Profile Accepted');
        }

        if($this->action == 'declined'){
            $data->details->is_admin_review = '2';
            $data->details->review_request = '0';
            $data->details->save();

            $this->alert('success', 'Profile Declined');
        }

        //...send email
    }

    public function render()
    {
        $this->lawyers = User::where('role', 'lawyer')->get();

        return view('livewire.admin.lawyers');
    }
}
