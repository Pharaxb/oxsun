<?php

namespace App\Livewire\Navbar;

use App\Models\Admin;
use Livewire\Attributes\On;
use Livewire\Component;

class Fullname extends Component
{
    public Admin $admin;

    #[On('Fullname')]
    public function fullname()
    {
        $this->fullname = $this->admin->name.' '.$this->admin->surname;
    }

    public function render()
    {
        return view('livewire.navbar.fullname');
    }
}
