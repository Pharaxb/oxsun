<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.user.index', [
            'users' => User::where('is_ban', false)->orderBy('id', 'desc')->paginate(10),
        ]);
    }
}
