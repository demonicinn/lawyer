<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Subscription;
use Livewire\WithPagination;
use App\Models\AdminSetting;

class Subscriptions extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // public $subscriptions = [];

    public $name,$search, $type, $price;
    public $status = '1';

    public $subscriptionId;
    protected $listeners = ['confirmedAction'];

    public $trial_days;

    public function mount()
    {
	    $trial_days_setting = AdminSetting::where('type', 'trial_days')->first();
	    if ( !is_null( $trial_days_setting ) ){
		    $this->trial_days = $trial_days_setting->value;
	    }

    }

    public function resetFields()
    {
        $this->name = '';
        $this->type = '';
        $this->price = '';
        $this->status = '1';
        $this->subscriptionId = '';
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'type' => 'required',
            'price' => 'nullable|numeric',
            'status' => 'required',
        ];
    }

    public function store()
    {
        $this->validate();

        $store = new Subscription;
        if ($this->subscriptionId) {
            $store->id = $this->subscriptionId;
            $store->exists = true;
        }
        $store->name = $this->name;
        $store->type = $this->type;

        if (@$this->price) {
            $store->price = $this->price;
        }

        $store->status = $this->status;
        $store->save();

        $this->alert('success', 'Subscription added');
        $this->emit('subscriptionFormClose');
        $this->resetFields();
    }


    public function edit($id)
    {
        $this->resetFields();
        $this->subscriptionId = $id;
        $data = Subscription::findOrFail($this->subscriptionId);

        $this->name = $data->name;
        $this->type = $data->type;
        $this->price = $data->price;
        $this->status = $data->status;

        $this->emit('subscriptionFormShow');
    }


    public function delete($id)
    {
        $this->subscriptionId = $id;

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
        $data = Subscription::findOrFail($this->subscriptionId);

        $data->delete();
        $this->alert('success', 'Subscription deleted');
        $this->resetFields();
    }

    public function updateTrialDays()
    {
	    $this->validate(['trial_days' => 'required|numeric']);
	    $trial_days_setting = AdminSetting::updateOrCreate(
		    ['type' => 'trial_days' ],
		    ['value' => $this->trial_days ],
	    );
	    $this->alert('success', 'Trial Days Updated');
    }


    public function render()
    {
        $subscriptions = Subscription::where(function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })->latest('id')->paginate(10);
        return view('livewire.admin.subscriptions', compact('subscriptions'));
    }
}
