<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use App\Models\Seo as SeoModel;

class Seo extends Component
{
	
	use LivewireAlert;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
	public $search;
	
    public $page_name, $title, $description, $keywords;

    public $seoId;
    protected $listeners = ['confirmedAction'];


    public function resetFields()
    {
        $this->page_name = '';
        $this->title = '';
        $this->description = '';
        $this->keywords = '';
        $this->seoId = '';
    }

    public function rules()
    {
        if($this->seoId){
			return [
				'page_name' => 'required|unique:seos,page,'.$this->seoId,
				'title' => 'required|max:255',
			];
		}
		
        return [
            'page_name' => 'required|unique:seos,page',
            'title' => 'required|max:255',
        ];
    }

    public function store()
    {
        $this->validate();

        $store = new SeoModel;
        if($this->seoId){
            $store->id = $this->seoId;
            $store->exists = true;
        }
        $store->page = $this->page_name;
        $store->title = $this->title;
        $store->description = $this->description;
        $store->keywords = $this->keywords;
        $store->save();

        $this->alert('success', 'Seo added');
        $this->emit('formClose');
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->seoId = $id;
        $data = SeoModel::findOrFail($this->seoId);

        $this->page_name = $data->page;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->keywords = $data->keywords;

        $this->emit('formShow');
    }

    public function delete($id)
    {
        $this->seoId = $id;

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
        $data = SeoModel::findOrFail($this->seoId);

        $data->delete();
        $this->alert('success', 'Seo deleted');
        $this->resetFields();
    }
	
	
    public function render()
    {
		$data = SeoModel::where(function ($query) {
            return $query->where('page', 'like', '%' . $this->search . '%')
                    ->whereOr('title', 'like', '%' . $this->search . '%')
                    ->whereOr('description', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')->paginate(10);
		
        return view('livewire.admin.seo', ['data'=>$data]);
    }
}
