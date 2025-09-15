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
    public $name;
    public $surname;
    public $email;

    public function mount()
    {
        $this->admin = Auth::user();
        $this->name = $this->admin->name;
        $this->surname = $this->admin->surname;
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
        $this->dispatch('toast', icon: 'success', title: 'عکس پروفایل با موفقیت عوض شد');
    }

    public function deleteAvatar()
    {
        if ($this->admin->avatar) {
            Storage::disk('public')->delete($this->admin->avatar);
        }

        $this->admin->avatar = NULL;
        $this->admin->save();

        $this->dispatch('Avatar');
        $this->dispatch('toast', icon: 'success', title: 'عکس پروفایل با موفقیت پاک شد');
    }

    public function changeEmail()
    {
        $this->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
        ]);

        $currentEmail = $this->admin->email;

        $this->admin->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
        ]);

        if ($currentEmail != $this->email) {
            Auth::logout();
            return redirect(route('login'));
        }
        else {
            $this->dispatch('Fullname');
            $this->dispatch('toast', icon: 'success', title: 'اطلاعات پروفایل با موفقیت عوض شد');
        }
    }

    public function render()
    {
        return view('livewire.profile.information');
    }
}
