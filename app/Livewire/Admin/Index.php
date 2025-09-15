<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $title = '';

    public function updatedTitle()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.index', [
            'admins' => Admin::where('is_ban', false)
                ->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->title.'%')
                        ->orwhere('surname', 'like', '%'.$this->title.'%')
                        ->orwhere('position', 'like', '%'.$this->title.'%')
                        ->orwhere('email', 'like', '%'.$this->title.'%');
                })->paginate(10)
        ]);
    }
}
