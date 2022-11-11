<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use App\Models\User;
use App\Models\Litigation;
use App\Models\Contract;
use Livewire\WithPagination;

class SearchLawyers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //public $lawyers;
    public $categories;

    public $latitude, $longitude;
    public $search_data=[], $search_type;

    public $free_consultation, $contingency_cases, $category, $search, $modal;
    
    public $year_exp_min = '1', $year_exp = '20';
    public $distance_min = '1', $distance = '100';
    public $rate_min = '0', $rate = '500';
    
    public $practice_area='';

    public function mount()
    {
        if (request()->latitude) {
            $this->latitude = request()->latitude;
        }
        if (request()->longitude) {
            $this->longitude = request()->longitude;
        }



        if (request()->litigations) {
            
            $this->search_data = request()->litigations;
            $this->search_type = 'litigations';
            

            $practices = Litigation::whereIn('id', request()->litigations)->get();

            foreach($practices as $practice){
                $this->practice_area = $this->practice_area ? $this->practice_area.', '.$practice->name : $practice->name;
            }
            //dd($this->practice_area);

            session(['search_data' => request()->litigations, 'search_type' => 'litigations']);
        }

        if (request()->contracts) {
            
            $this->search_data = request()->contracts;
            $this->search_type = 'contracts';
            

            $practices = Contract::whereIn('id', request()->litigations)->get();

            foreach($practices as $practice){
                $this->practice_area = $this->practice_area ? $this->practice_area.', '.$practice->name : $practice->name;
            }
            

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
                $search = $this->search;
                $user->where(function ($query) use ($search) {
                    $query->where('id', 'like', '%'.$search.'%');
                    $query->orWhere('first_name', 'like', '%'.$search.'%');
                    $query->orWhere('last_name', 'like', '%'.$search.'%');
                    $query->orWhere('contact_number', 'like', '%'.$search.'%');
                });
            }


            if ($this->search_type=='litigations') {
                //dd('f');
                $user = $user->whereHas('lawyerLitigations', function ($query) {
                    $query->whereIn('litigations_id', $this->search_data);
                });
            }

            if ($this->search_type=='contracts') {
                $user = $user->whereHas('lawyerContracts', function ($query) {
                    $query->whereIn('contracts_id', $this->search_data);
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

                    //if ($this->year_exp < '20') {
                        $query->whereBetween('year_experience', [$this->year_exp_min, $this->year_exp]);
                    //}

                    //if ($this->rate > 0) {
                        $query->where(function($q) {
                            $q->where('hourly_fee', '>=', (int)$this->rate_min);
                            $q->where('hourly_fee', '<=', (int)$this->rate);
                        });
                        
                    //}

                    if ($this->latitude && $this->longitude) {

                        $query->selectRaw('(((acos(sin((' . $this->latitude . '*pi()/180)) * sin((`latitude`*pi()/180))+cos((' . $this->latitude . '*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((' . $this->longitude . '- `longitude`)*pi()/180))))*180/pi())*60*1.1515) AS distance');

                        //if($this->distance > 0){
                            //$query->havingRaw("distance > ?", [$this->distance_min]);
                            //$query->orHavingRaw("distance <= ?", [$this->distance]);
                            
                            //need this
                            //$query->havingRaw("distance <= ?", [$this->distance]);
                        //}
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
                            if($cat && $item){
                                $query->where(function ($que) use ($cat, $item) {
                                    $que->where('category_id', (int)$cat);
                                    $que->where('item_id', (int)$item);
                                });
                            }
                        }
                    }
                });


            $user = $user->whereHas('lawyerReviews', function ($query) {
                    $query->selectRaw('SUM(rating) as rate')
                        ->orderByRaw('rate asc');
                });


            $user = $user->whereHas('lawyerSubscriptionLast', function ($query) {

                    $query->where('to_date', '<=', date('Y-m-d'));
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
