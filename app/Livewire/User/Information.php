<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Information extends Component
{
    public User $user;
    public $name;
    public $surname;

    public function mount()
    {
        $this->name = $this->user->name;
        $this->surname = $this->user->surname;
    }

    public function changeInformation()
    {
        $this->validate([
            'name' => 'required',
            'surname' => 'required',
        ]);
    }

    public function render()
    {
        return view('livewire.user.information');
    }
}
