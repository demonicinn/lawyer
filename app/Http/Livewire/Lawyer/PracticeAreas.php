<?php

namespace App\Http\Livewire\Lawyer;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Litigation;

use App\Models\LawyerLitigations;
use App\Models\LawyerContracts;

class PracticeAreas extends Component
{
    use LivewireAlert;

    public $currentTab='litigations';
    public $contracts = [];
    public $litigations = [];
    public $user;
    
    public $selectContracts = [];
    public $selectLitigations = [];

    public function mount()
    {
        $this->contracts = Contract::whereStatus('1')->orderBy('name', 'asc')->get();
        $this->litigations = Litigation::whereStatus('1')->orderBy('name', 'asc')->get();
        $this->user = auth()->user();

        //...
        $this->selectLitigations = $this->user->lawyerLitigations()->pluck('litigations_id')->toArray();
        $this->selectContracts = $this->user->lawyerContracts()->pluck('contracts_id')->toArray();
    }

    public function setCurrentTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function store()
    {
        if($this->currentTab == 'litigations'){
            $this->validate([
                'selectLitigations' => 'required|array|min:3'
            ]);
        }

        if($this->currentTab == 'contracts'){
            $this->validate([
                'selectContracts' => 'required|array|min:3'
            ]);
        }


        //....
        if($this->currentTab == 'litigations' && $this->selectLitigations){

            foreach($this->selectLitigations as $id){
                if(@$id){
                    $checkLitigation = LawyerLitigations::where('users_id', $this->user->id)
                                            ->where('litigations_id', $id)->first();

                    $litigation = new LawyerLitigations;
                    if(@$checkLitigation){
                        $litigation->id = $checkLitigation->id;
                        $litigation->exists = true;
                    }
                    $litigation->users_id = $this->user->id;
                    $litigation->litigations_id = $id;
                    $litigation->save();
                }
            }

            //...delete
            $deleteLitigation = LawyerLitigations::where('users_id', $this->user->id)
						->whereNotIn('litigations_id', $this->selectLitigations)
						->get();
                        
            if(count($deleteLitigation)>0){
                foreach($deleteLitigation as $ids){
                    $ids->delete();
                }
            }
        }

        //...
        if($this->currentTab == 'contracts' && $this->selectContracts){
            

            foreach($this->selectContracts as $id){
                if(@$id){
                    $checkContract = LawyerContracts::where('users_id', $this->user->id)
                                            ->where('contracts_id', $id)->first();
                    $contract = new LawyerContracts;
                    if(@$checkContract){
                        $contract->id = $checkContract->id;
                        $contract->exists = true;
                    }
                    $contract->users_id = $this->user->id;
                    $contract->contracts_id = $id;
                    $contract->save();
                }
            }

            //...delete
            $deleteContract = LawyerContracts::where('users_id', $this->user->id)
						->whereNotIn('contracts_id', $this->selectContracts)
						->get();

            if(count($deleteContract)>0){
                foreach($deleteContract as $idsC){
                    $idsC->delete();
                }
            }
        }

        //...
        $this->alert('success', 'Areas of Practice saved');
        $this->emit('practiceFormModalHide');
    }

    public function render()
    {
        return view('livewire.lawyer.practice-areas');
    }
}
