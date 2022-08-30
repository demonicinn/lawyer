<?php

namespace App\Http\Livewire\Lawyer;

use Livewire\Component;
use App\Models\Category;
use App\Models\Item;

class Admission extends Component
{
	public $categoriesMulti = [];

    public $admissionArray = [];
    public $itemArray = [];

	public $itemsCollection = [];

    public function mount()
    {
    	$this->categoriesMulti = Category::whereStatus('1')->where('is_multiselect', '1')->get();

        //...
        foreach($this->categoriesMulti as $cat){
            array_push($this->admissionArray, $cat->id);
        }
    }

    public function updatedItemArray(){
        if($this->itemArray){
            $this->itemsCollection = Item::whereIn('id', $this->itemArray)->get();
        }
    }

    /*public function updatedAdmissionArray(){

        dd($this->admissionArray);

            if($this->admissionArray){
                foreach($this->admissionArray as $admission){
                    foreach($admission as $item){
                        array_push($this->itemArray, $item);
                    }
                }

                //dd($this->admissionArray);
                
            }

            
            dd($this->itemArray);

    }*/


    public function storeAdmission(){

        dd($this->admissionArray);

        dd($this->itemsCollection);
    }

    public function render()
    {
    	$this->emit('fireSelect');
        return view('livewire.lawyer.admission');
    }
}
