<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Contract;
use Livewire\WithPagination;

class Contracts extends Component
{
	use LivewireAlert;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // public $contracts = [];

	public $name,$search;
	public $status = '1';

    public $contractId;
    protected $listeners = ['confirmedAction'];

    public function resetFields()
    {
        $this->name = '';
        $this->status = '1';
        $this->contractId = '';
    }

    public function rules()
	{
		return [
			'name' => 'required|max:255',
			'status' => 'required',
		];
	}

    public function store()
    {
        $this->validate();

        $store = new Contract;
        if($this->contractId){
            $store->id = $this->contractId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'Contract added');
        $this->emit('contractFormClose');
        $this->resetFields();
    }


    public function edit($id)
	{
        $this->resetFields();
        $this->contractId = $id;
        $data = Contract::findOrFail($this->contractId);

        $this->name = $data->name;
        $this->status = $data->status;

        $this->emit('contractFormShow');
    }


    public function delete($id)
	{
        $this->contractId = $id;

		$this->alert('', 'Are you sure to Delete?', [
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
        $data = Contract::findOrFail($this->contractId);

        $data->delete();
        $this->alert('success', 'Contract deleted');
        $this->resetFields();
    }


    public function render()
    {
        $contracts = Contract::where(function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->orderBy('name', 'asc')->paginate(10);

        return view('livewire.admin.contracts',compact('contracts'));
    }
}
