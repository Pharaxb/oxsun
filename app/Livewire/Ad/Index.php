<?php

namespace App\Livewire\Ad;

use App\Models\Ad;
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
        return view('livewire.ad.index', [
            'ads' => Ad::where(function ($query) {
                    $query->where('title', 'like', '%'.$this->title.'%');
                })->orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
