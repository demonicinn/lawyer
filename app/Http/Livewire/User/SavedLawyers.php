<?php

namespace App\Http\Livewire\User;

use App\Models\Contract;
use App\Models\LawyerContracts;
use App\Models\LawyerLitigations;
use App\Models\Litigation;
use App\Models\SavedLawyer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SavedLawyers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $authUser, $search, $practices, $practiceArea, $areaId;


    public function clear()
    {
        $this->practiceArea = null;
        $this->search = null;
    }

    public function render()
    {
        $this->authUser = auth()->user();

        $ligitions = Litigation::where('status', '1')->get();
        $contracts = Contract::where('status', '1')->get();

        $user = SavedLawyer::with('lawyer', 'lawyerInfo')->where('user_id', $this->authUser->id);

        if (!empty($this->search)) {
            $search = $this->search;
            $user->whereHas('lawyer', function ($query) use ($search) {
                $query->where('contact_number', 'LIKE', "%" . $search . "%");
                $query->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
            });
        }

        $user = $user->paginate(10);
        $lawyers = $user;

        if ($this->practiceArea == 'Litigations') {
            $this->practices =  $ligitions;
            if ($this->areaId) {

                $lawyerId = LawyerLitigations::where('litigations_id', $this->areaId)->select('users_id')->get();
                if (count($lawyerId) > 0) {
                    $lawyers = SavedLawyer::with('lawyer')->whereIn('lawyer_id',  $lawyerId)->paginate(10);
                }
            }
        } elseif ($this->practiceArea == 'Contracts') {
            $this->practices =  $contracts;
            if ($this->areaId) {
                $lawyerId = LawyerContracts::where('contracts_id', $this->areaId)->select('users_id')->get();
                if (count($lawyerId) > 0) {
                    $lawyers = SavedLawyer::with('lawyer')->whereIn('lawyer_id',  $lawyerId)->paginate(10);
                }
            }
        } else {
            $this->practices = null;
        }
        return view('livewire.user.saved-lawyers', compact('lawyers', 'ligitions', 'contracts'));
    }
}
