<?php

namespace App\Livewire\Navbar;

use App\Models\Admin;
use Livewire\Attributes\On;
use Livewire\Component;

class Avatar extends Component
{
    public Admin $admin;

    public $avatar;

    #[On('Avatar')]
    public function avatar()
    {
        if ($this->admin->avatar) {
            $this->avatar = $this->admin->avatar;
        }
        else {
            $this->avatar = NULL;
        }
    }

    public function render()
    {
        return view('livewire.navbar.avatar');
    }
}
