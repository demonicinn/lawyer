<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use Livewire\WithPagination;


class Users extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $users;

    public function render()
    {
        $this->users = User::where('role', 'user')->get();
        return view('livewire.admin.users');
    }
}
