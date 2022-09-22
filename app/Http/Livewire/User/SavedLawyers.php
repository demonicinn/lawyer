<?php

namespace App\Http\Livewire\User;

use App\Models\SavedLawyer;
use Livewire\Component;


class SavedLawyers extends Component
{

    public $lawyers, $authUser;

    public function mount()
    {
        $this->authUser = auth()->user();
        $this->lawyers = SavedLawyer::where('user_id', $this->authUser->id)->get();
        dd($this->lawyers);
    }

   
    public function render()
    {
        return view('livewire.user.saved-lawyers');
    }
}
