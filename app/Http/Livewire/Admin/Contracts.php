<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Contract;

class Contracts extends Component
{
	use LivewireAlert;

    public $contracts = [];

	public $name;
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

		$this->alert('warning', 'Are you sure', [
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
        $this->contracts = Contract::all();

        return view('livewire.admin.contracts');
    }
}
