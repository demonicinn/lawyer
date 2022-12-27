<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use App\Notifications\MailToLawyerForStatus;
use Illuminate\Support\Facades\Notification;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Lawyers extends Component
{
    use LivewireAlert;

    use WithPagination;
    
	
	public $perPage = 10;
    public $sortField='first_name';
    public $sortAsc = true;

    // public $lawyers = [];
    public $lawyerId;
    public $action, $search;
    protected $listeners = ['confirmedAction'];
    protected $paginationTheme = 'bootstrap';

    public function review($id, $action)
    {

        $this->lawyerId = $id;
        $this->action = $action;

		$mess = $this->action == 'accept' ? 'Accept' : 'Declined';
		
        $this->alert('', 'Are you sure to '.$mess.' this lawyer?', [
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
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }



    public function render()
    {
        /*
        $lawyers = User::where('role', 'lawyer')->where(function ($query) {
            return  $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%");
        })->latest('id')->get();
        */
        
        $date = date('Y-m-d');
        $date3Months = Carbon::parse($date)->subtract(3, 'months')->format('Y-m-d');
        
        
        $lawyers = User::with(['lawyerReviews', 'booking', 'details'])->where('role', 'lawyer')->where(function ($query) {
            return  $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%")
                        ->orWhere('email', 'LIKE', "%" . $this->search . "%");
        })
		->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
		->paginate($this->perPage);
        
        //$lawyers = lawyerDescWithRating($lawyersData, $date3Months);
        
        
        
        return view('livewire.admin.lawyers', compact('lawyers', 'date3Months'));
    }
}
