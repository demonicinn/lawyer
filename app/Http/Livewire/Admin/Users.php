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
    protected $paginationTheme = 'bootstrap';

    public $search = '';

   

    public function render()
    {
        $users = User::where('role', 'user')->paginate(10);
        return view('livewire.admin.users', compact('users'));
        
    }
}
