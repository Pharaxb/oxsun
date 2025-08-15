<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;

class UsersCount extends Component
{
    public $usersCount;

    public function mount()
    {
        $this->usersCount = User::where('is_ban', 0)->get()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.users-count');
    }
}
