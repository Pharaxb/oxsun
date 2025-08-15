<?php

namespace App\Livewire\Dashboard;

use App\Models\Ad;
use Livewire\Component;

class AdsCount extends Component
{
    public $adsCount;

    public function mount()
    {
        $this->adsCount = Ad::whereColumn('viewed', '<', 'circulation')->where('is_verify', true)->get()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.ads-count');
    }
}
