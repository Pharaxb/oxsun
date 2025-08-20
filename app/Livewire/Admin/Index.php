<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.index', [
            'admins' => Admin::where('is_ban', false)->paginate(10),
        ]);
    }
}
