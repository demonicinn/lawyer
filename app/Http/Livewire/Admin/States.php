<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\State;

class States extends Component
{
    use LivewireAlert;

    public $states = [];

	public $name, $code;
	public $status = '1';

    public $stateId;
    protected $listeners = ['confirmedAction'];

    public function resetFields()
    {
        $this->name = '';
        $this->code = '';
        $this->status = '1';
        $this->stateId = '';
    }

    public function rules()
	{
		return [
			'name' => 'required|max:255',
			'code' => 'required|max:10',
			'status' => 'required',
		];
	}

    public function store()
    {
        $this->validate();

        $store = new State;
        if($this->stateId){
            $store->id = $this->stateId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->code = $this->code;
        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'State added');
        $this->emit('stateFormClose');
        $this->resetFields();
    }


    public function edit($id)
	{
        $this->resetFields();
        $this->stateId = $id;
        $data = State::findOrFail($this->stateId);

        $this->name = $data->name;
        $this->code = $data->code;
        $this->status = $data->status;

        $this->emit('stateFormShow');
    }


    public function delete($id)
	{
        $this->stateId = $id;

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
        $data = State::findOrFail($this->stateId);

        $data->delete();
        $this->alert('success', 'State deleted');
        $this->resetFields();
    }


    public function render()
    {
        $this->states = State::all();
        return view('livewire.admin.states');
    }
}
