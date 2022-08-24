<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Categories;

class Categories extends Component
{
    use LivewireAlert;

    public $categories = [];
    public $name;
    public $status = '1';

    public $categoryId;
    protected $listeners = ['confirmedAction'];

    public function resetFields()
    {
        $this->name = '';
        $this->status = '1';
        $this->categoryId = '';
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

        $store = new Categories();
        if ($this->categoryId) {
            $store->id = $this->categoryId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'Category added');
        $this->emit('categoryFormClose');
        $this->resetFields();
    }


    public function edit($id)
    {
        $this->resetFields();
        $this->categoryId = $id;
        $data = Categories::findOrFail($this->categoryId);

        $this->name = $data->name;
        $this->status = $data->status;

        $this->emit('categoryFormShow');
    }


    public function delete($id)
    {
        $this->categoryId = $id;

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
        $data = Categories::findOrFail($this->categoryId);

        $data->delete();
        $this->alert('success', 'Category deleted');
        $this->resetFields();
    }


    public function render()
    {
        $this->categories = Categories::all();
        dd($this->categories);
        return view('livewire.admin.categories');
    }
}
