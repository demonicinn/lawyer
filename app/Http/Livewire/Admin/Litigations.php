<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Litigation;
use Livewire\WithPagination;


class Litigations extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // public $litigations = [];

    public $name, $search;
    public $status = '1';

    public $litigationId;
    protected $listeners = ['confirmedAction'];

    public function resetFields()
    {
        $this->name = '';
        $this->status = '1';
        $this->litigationId = '';
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

        $store = new Litigation;
        if ($this->litigationId) {
            $store->id = $this->litigationId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'Litigation added');
        $this->emit('litigationFormClose');
        $this->resetFields();
    }


    public function edit($id)
    {
        $this->resetFields();
        $this->litigationId = $id;
        $data = Litigation::findOrFail($this->litigationId);

        $this->name = $data->name;
        $this->status = $data->status;

        $this->emit('litigationFormShow');
    }


    public function delete($id)
    {
        $this->litigationId = $id;

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
        $data = Litigation::findOrFail($this->litigationId);

        $data->delete();
        $this->alert('success', 'Litigation deleted');
        $this->resetFields();
    }


    public function render()
    {
        $litigations = Litigation::where(function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->latest('id')->paginate(10);

        return view('livewire.admin.litigations', compact('litigations'));
    }
}
