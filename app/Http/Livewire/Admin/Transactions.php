<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Payment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class Transactions extends Component
{
    use LivewireAlert;

    use WithPagination;
    
    public $from_date;
    public $to_date;
	
	public $search;
	public $perPage = 10;
    public $sortField='created_at';
    public $sortAsc = true;


    protected $paginationTheme = 'bootstrap';

    
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
        $transactions = Payment::with('user')
                    ->whereHas('user', function ($query) {
                        if($this->sortAsc == 'first_name'){
                            $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%")
                                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                        }
                        else {
                            return $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%");
                        }
                    });
                    
                    if($this->sortAsc != 'first_name'){
            		    $transactions = $transactions->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
                    }
                    
                    if($this->from_date && $this->to_date){
                        $transactions = $transactions->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }
                    elseif($this->from_date && !$this->to_date){
                        $transactions = $transactions->whereDate('created_at', '>=', $this->from_date);
                    }
                    elseif(!$this->from_date && $this->to_date){
                        $transactions = $transactions->whereDate('created_at', '<=', $this->to_date);
                    }
                    
            		$transactions = $transactions->paginate($this->perPage);
        
        
        
        return view('livewire.admin.transactions', compact('transactions'));
    }
}
