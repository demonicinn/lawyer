<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\User;

class SearchLawyers extends Component
{
    public $lawyers, $categories;
    public $free_consultation, $contingency_cases, $year_exp;


    public function searchFilter()
    {
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

        //search filter

        // if ($this->free_consultation == true) {
        //     $user = $user->whereHas('details', function ($query) {
        //         $query->where('is_consultation_fee', 'yes');
        //     });
        // }

        // if ($this->contingency_cases == true) {

        //     $user = $user->whereHas('details', function ($query) {
        //         $query->where('contingency_cases', 'yes');
        //     });
        // }

        // if ($this->year_exp) {
        //     $from='1';
        //     $to=$this->year_exp;

        //     // dd( $from,$to);
        //     $user = $user->whereHas('details', function ($query) {
        //         $query->whereBetween('year_experience', ['1', $this->year_exp]);
        //     });
        // }


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
