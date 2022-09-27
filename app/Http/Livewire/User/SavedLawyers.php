<?php

namespace App\Http\Livewire\User;

use App\Models\Contract;
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

    public function render()
    {
        $this->authUser = auth()->user();

        $ligitions = Litigation::where('status', '1')->get();
        $contracts = Contract::where('status', '1')->get();

        $user = SavedLawyer::with('lawyer')->where('user_id', $this->authUser->id);
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
                dd($this->areaId);
            }
        } elseif ($this->practiceArea == 'Contracts') {
            $this->practices =  $contracts;
            if ($this->areaId) {
                dd($this->areaId);
            }
        } else {
            $this->practices = null;
        }
        

        return view('livewire.user.saved-lawyers', compact('lawyers', 'ligitions', 'contracts'));
    }
}
