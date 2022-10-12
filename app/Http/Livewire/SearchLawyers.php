<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class SearchLawyers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //public $lawyers;
    public $categories;

    public $latitude, $longitude;

    public $free_consultation, $contingency_cases, $year_exp = '20', $category, $distance = '0', $rate = '0', $search, $modal;

    public function mount()
    {
        if (request()->latitude) {
            $this->latitude = request()->latitude;
        }
        if (request()->longitude) {
            $this->longitude = request()->longitude;
        }



        if (request()->litigations) {
            session(['search_data' => request()->litigations, 'search_type' => 'litigations']);
        }

        if (request()->contracts) {
            session(['search_data' => request()->contracts, 'search_type' => 'contracts']);
        }

    }

    public function searchFilter()
    {


        $user = User::where('role', 'lawyer')
                    ->where('status', '1');

            // ->with('lawyerCategory', function ($query) {
            //     $query->with('items', 'categories');
            // })->with('lawyerInfo', function ($query) {
            //     $query->with('categories', 'items');
            // });


            //search filter
            if ($this->search) {
                $user->where(function ($query) {
                    $query->where('id', $this->search);
                    $query->orWhere('first_name', $this->search);
                    $query->orWhere('last_name', $this->search);
                    $query->orWhere('contact_number', $this->search);
                });
            }


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

            $user = $user->whereHas('details', function ($query) {
                    $query->where('is_verified', 'yes');

                    if ($this->free_consultation == true) {
                        $query->where('is_consultation_fee', 'no');
                    }

                    if ($this->contingency_cases == true) {
                        $query->where('contingency_cases', 'yes');
                    }

                    if ($this->year_exp < '20') {
                        $query->whereBetween('year_experience', ['1', $this->year_exp]);
                    }

                    if ($this->rate > 0) {
                        $query->where('hourly_fee', '<=', (int)$this->rate);
                    }

                    if ($this->distance && $this->latitude && $this->longitude) {

                        $query->selectRaw('(((acos(sin((' . $this->latitude . '*pi()/180)) * sin((`latitude`*pi()/180))+cos((' . $this->latitude . '*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((' . $this->longitude . '- `longitude`)*pi()/180))))*180/pi())*60*1.1515) AS distance');

                        if($this->distance > 0){
                            $query->havingRaw("distance <= ?", [$this->distance]);
                        }
                    }


                    if ($this->search) {
                        $query->where(function ($que) {
                            $que->orWhere('city', $this->search);
                            $que->orWhere('zip_code', $this->search);
                            $que->orWhere('address', $this->search);
                        });
                    }
                });

            $user = $user->whereHas('lawyerInfo', function ($query) {
                    if ($this->category) {
                        foreach ($this->category as $cat => $item) {
                            $query->where(function ($que) use ($cat, $item) {
                                $que->where('category_id', (int)$cat);
                                $que->where('item_id', (int)$item);
                            });
                        }
                    }
                });


            $user = $user->whereHas('lawyerReviews', function ($query) {
                    // $query->orderByRaw('SUM(rating) DESC');
                    

                    $query->selectRaw('SUM(rating) as rate')
                        ->orderByRaw('rate asc');
                });





        //$user = $user->latest()->get();
        $user = $user->paginate(9);
        // dd($user);
        //$this->lawyers = $user;

        return $user;
    }


    public function modalData($userId){
        $this->modal = user::findOrFail($userId);
        $this->emit('courtModalShow');
        
    }


    public function render()
    {
        $lawyers = $this->searchFilter();

        $this->categories = Category::where('is_search', '1')->withCount('items')->with('items')->get();


        return view('livewire.search-lawyers', ['lawyers'=>$lawyers]);
    }


}
