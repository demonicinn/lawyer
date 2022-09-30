<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Category;
use App\Models\Item;
use Livewire\WithPagination;

class Categories extends Component
{

    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';



    public $items = [];

    public $category_name;
    public $item_name,$search;

    public $item_status = '1';
    public $cat_status = '1';

    public $cat_search = '1';

    public $is_multiselect = '0';

    public $categoryId;
    public $itemId;



    protected $listeners = ['confirmedActionForCategory', 'confirmedActionForItem'];

    public function resetCategoryFields()
    {
        $this->category_name = '';
        $this->cat_status = '1';
        $this->cat_search = '1';
        $this->categoryId = '';
        $this->is_multiselect = '0';
    }


    public function store()
    {
        // dd("store category");
        $this->validate([
            'category_name' => 'required|max:255',
            'cat_status' => 'required',
        ]);

        $store = new Category();
        if ($this->categoryId) {
            $store->id = $this->categoryId;
            $store->exists = true;
        }
        $store->name = $this->category_name;
        $store->status = $this->cat_status;
        $store->is_search = $this->cat_search;
        $store->is_multiselect = $this->is_multiselect;
        $store->save();

        $this->alert('success', 'Category added');
        $this->emit('categoryFormClose');
        $this->resetCategoryFields();
    }


    public function edit($id)
    {
        $this->resetCategoryFields();
        $this->categoryId = $id;
        $data = Category::findOrFail($this->categoryId);

        $this->category_name = $data->name;
        $this->cat_status = $data->status;
        $this->cat_search = $data->is_search;
        $this->is_multiselect = $data->is_multiselect;

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
            'onConfirmed' => 'confirmedActionForCategory',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }

    public function confirmedActionForCategory()
    {
        $data = Category::findOrFail($this->categoryId);

        $data->delete();
        $this->alert('success', 'Category deleted');
        $this->resetCategoryFields();
    }


    //for item crud

    public function resetItemFields()
    {
        $this->item_name = '';
        $this->item_status = '1';
        $this->itemId = '';
    }


    public function addItemTypes($id)
    {
        $this->categoryId = $id;
    }

    public function storeItem()
    {


        $this->validate([
            'item_name' => 'required|max:255',
            'item_status' => 'required',
        ]);

       
        $store = new Item();
        if ($this->itemId) {
            $store->id = $this->itemId;
            $store->exists = true;
        }
        $store->category_id = $this->categoryId;
        $store->name = $this->item_name;
        $store->status = $this->item_status;
        $store->save();

        $this->alert('success', 'Item added');
        $this->emit('itemFormClose');
        $this->resetItemFields();
    }


    public function editItem($id)
    {
        $this->resetItemFields();
        $this->itemId = $id;
        $data = Item::findOrFail($this->itemId);
        $this->item_name = $data->name;
        $this->item_status = $data->status;
        $this->categoryId = $data->category_id;

        $this->emit('itemFormShow');
    }


    public function deleteItem($id)
    {
        $this->itemId = $id;

        $this->alert('warning', 'Are you sure', [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'onConfirmed' => 'confirmedActionForItem',
            'allowOutsideClick' => false,
            'timer' => null
        ]);
    }

    public function confirmedActionForItem()
    {

        $data = Item::findOrFail($this->itemId);

        $data->delete();
        $this->alert('success', 'Item deleted');
        $this->resetItemFields();
    }

    public function render()
    {
        $categories = Category::with('items')->where(function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->with('items', function ($query) {
            $query->latest('id');
        })->paginate(10);

        return view('livewire.admin.categories', compact('categories'));
    }
}
