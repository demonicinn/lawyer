<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class Users extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public function render()
    {
        $users = User::where('role', 'user')->where(function ($query) {
            return  $query->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $this->search . "%");
        })->latest('id')->paginate(10);
        return view('livewire.admin.users', compact('users'));
    }
}
