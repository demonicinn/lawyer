<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class SearchLawyers extends Component
{
    public $lawyers;

    public function searchFilter(){

        $user = User::where('status', '1')
            ->whereHas('details', function ($query) {
                $query->where('is_verified', 'yes');
            });
            if(request()->litigations){
                $user = $user->whereHas('lawyerLitigations', function ($query) {
                    $query->whereIn('litigations_id', request()->litigations);
                });
            }
            if(request()->contracts){
                $user = $user->whereHas('lawyerContracts', function ($query) {
                    $query->whereIn('contracts_id', request()->contracts);
                });
            }

            $user = $user->get();

            $this->lawyers = $user;
    }

    public function render()
    {
        $this->searchFilter();

        return view('livewire.search-lawyers');
    }
}
