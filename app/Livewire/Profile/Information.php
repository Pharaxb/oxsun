<?php

namespace App\Livewire\Profile;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Information extends Component
{
    use WithFileUploads;

    public Admin $admin;
    public $avatarInput;
    public $email;

    public function mount()
    {
        $this->admin = Auth::user();
        $this->email = $this->admin->email;
    }

    public function updatedAvatarInput()
    {
        $this->validate([
            'avatarInput' => 'image|max:2048',
        ]);

        if ($this->avatarInput) {
            if ($this->admin->avatar) {
                Storage::disk('public')->delete($this->admin->avatar);
            }

            $path = $this->avatarInput->store('avatars', 'public');
            $this->admin->avatar = $path;
            $this->admin->save();
        }

        $this->dispatch('Avatar');
        $this->dispatch('toast', 'success', 'عکس پروفایل با موفقیت عوض شد');
    }

    public function deleteAvatar()
    {
        if ($this->admin->avatar) {
            Storage::disk('public')->delete($this->admin->avatar);
        }

        $this->admin->avatar = NULL;
        $this->admin->save();

        $this->dispatch('Avatar');
        $this->dispatch('toast', 'success', 'عکس پروفایل با موفقیت پاک شد');
    }

    public function changeEmail()
    {
        $this->validate([
            'email' => 'required',
        ]);

        if ($this->admin->email != $this->email) {
            $this->admin->email = $this->email;
            $this->admin->save();

            Auth::logout();

            return redirect(route('login'));
        }
    }

    public function render()
    {
        return view('livewire.profile.information');
    }
}
