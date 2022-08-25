<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\User;

class SearchLawyers extends Component
{
    public $lawyers,$categories;
    

    public function searchFilter()
    {

        //  dd($this->lawyers);

        $user = User::where('status', '1')
            ->whereHas('details', function ($query) {
                $query->where('is_verified', 'yes');
            });
        if (request()->litigations) {
            $user = $user->whereHas('lawyerLitigations', function ($query) {
                $query->whereIn('litigations_id', request()->litigations);
            });
        }
        if (request()->contracts) {
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

        $this->categories = Category::where('is_search', '=', '1')->withCount('items')->with('items')->get();

       
        return view('livewire.search-lawyers');
    }
}
