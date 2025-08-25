<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\UserLocation;
use Livewire\Component;
use Livewire\WithPagination;

class Locations extends Component
{
    use WithPagination;

    public User $user;

    public function render()
    {
        return view('livewire.user.locations', [
            'locations' => UserLocation::where('user_id', $this->user->id)->with('province')->orderBy('created_at', 'desc')->paginate(5, pageName: 'locations-page'),
        ]);
    }
}
