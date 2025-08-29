<?php

namespace App\Livewire\User;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    public User $user;

    public function render()
    {
        return view('livewire.user.transactions', [
            'transactions' => Transaction::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->paginate(10, pageName: 'transactions-page'),
        ]);
    }
}
