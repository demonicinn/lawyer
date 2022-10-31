<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\StateBar as StateBarModel;
use Livewire\WithPagination;

class StateBar extends Component
{
    use LivewireAlert;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $search;
    public $status = '1';

    public $stateId;
    protected $listeners = ['confirmedAction'];


    public function resetFields()
    {
        $this->name = '';
        $this->status = '1';
        $this->stateId = '';
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

        $store = new StateBarModel;
        if($this->stateId){
            $store->id = $this->stateId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'State bar added');
        $this->emit('stateFormClose');
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->stateId = $id;
        $data = StateBarModel::findOrFail($this->stateId);

        $this->name = $data->name;
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
        $data = StateBarModel::findOrFail($this->stateId);

        $data->delete();
        $this->alert('success', 'State bar deleted');
        $this->resetFields();
    }


    public function render()
    {
        $states = StateBarModel::where(function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->latest('id')->paginate(10);

        return view('livewire.admin.state-bar', ['states'=>$states]);
    }
}
