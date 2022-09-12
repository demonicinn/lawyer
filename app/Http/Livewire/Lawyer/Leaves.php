<?php

namespace App\Http\Livewire\Lawyer;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Leave;

class Leaves extends Component
{
    use LivewireAlert;

    public $leaves = [];

    public $date;


    public $leaveId;
    protected $listeners = ['confirmedAction'];

    public function resetFields()
    {
        $this->date = '';

        $this->leaveId = '';
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
        ];
    }

    public function store()
    {
        $this->validate();

        $store = new Leave;
        if ($this->leaveId) {
            $store->id = $this->leaveId;
            $store->exists = true;
        }
        $store->date = $this->date;
        $store->user_id = auth()->user()->id;
        $store->save();

        if (!$this->leaveId) {
            $this->alert('success', 'Leave added');
        } else {
            $this->alert('success', 'Leave updated');
        }

        $this->emit('LeaveFormClose');
        $this->resetFields();
    }


    public function edit($id)
    {
        $this->resetFields();
        $this->leaveId = $id;
        $data = Leave::findOrFail($this->leaveId);

        $this->date = $data->date;
        $this->emit('LeaveFormShow');
    }


    public function delete($id)
    {
        $this->leaveId = $id;

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
        $data = Leave::findOrFail($this->leaveId);

        $data->delete();
        $this->alert('success', 'Leave deleted');
        $this->resetFields();
    }

    public function render()
    {
        $this->leaves = Leave::where('user_id',auth()->user()->id)->get();
        return view('livewire.lawyer.leaves');
    }
}
