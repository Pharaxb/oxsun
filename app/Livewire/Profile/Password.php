<?php

namespace App\Livewire\Profile;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public Admin $admin;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function changePassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($this->password, $this->admin->password)) {
            $newPassword = Hash::make($this->password);
            $this->admin->password = $newPassword;
            $this->admin->save();

            Auth::logout();

            return redirect(route('login'));
        }
        else {
            $this->dispatch('toast', icon: 'error', title: 'گذرواژه جدید با گذرواژه فعلی یکی است.');
        }
    }

    public function render()
    {
        return view('livewire.profile.password');
    }
}
