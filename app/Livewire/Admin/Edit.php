<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    use WithFileUploads;

    public Admin $admin;
    public $roles;
    public $avatarInput;
    public $name;
    public $surname;
    public $email;
    public array $selectedRoles = [];
    public $is_ban = false;
    public $ban_reason;

    public function mount()
    {
        $this->roles = Role::all();
        $this->is_ban = $this->admin->is_ban;
        $this->ban_reason = $this->admin->ban_reason;
        $this->name = $this->admin->name;
        $this->surname = $this->admin->surname;
        $this->email = $this->admin->email;
        $this->selectedRoles = $this->admin->roles->pluck('name')->toArray();
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

        $this->dispatch('toast', icon: 'success', title: 'عکس پروفایل با موفقیت عوض شد');
    }

    public function deleteAvatar()
    {
        if ($this->admin->avatar) {
            Storage::disk('public')->delete($this->admin->avatar);
        }

        $this->admin->avatar = NULL;
        $this->admin->save();

        $this->dispatch('toast', icon: 'success', title: 'عکس پروفایل با موفقیت پاک شد');
    }

    public function changeInformation()
    {
        $this->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
        ]);

        $this->admin->update([
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'position' => $this->position,
        ]);
        DB::table('sessions')->where('user_id', $this->admin->id)->delete();

        $this->dispatch('toast', icon: 'success', title: 'اطلاعات پروفایل با موفقیت عوض شد');
    }

    public function changePositions()
    {
        $this->validate([
            'selectedRoles' => 'array',
        ]);
        $this->admin->syncRoles($this->selectedRoles);

        $this->dispatch('toast', icon: 'success', title: 'سطح دسترسی با موفقیت تغییر کرد.');
    }

    public function changeBan()
    {
        if ($this->is_ban) {
            $this->is_ban = false;
            $this->ban_reason;
            $this->admin->update([
                'is_ban' => false,
                'ban_reason' => NULL
            ]);

            $this->dispatch('toast', icon: 'success', title: 'کاربر از مسدودیت خارج شد.');
        }
        else {
            DB::table('sessions')->where('user_id', $this->admin->id)->delete();
            $this->is_ban = true;
            $this->admin->update([
                'is_ban' => true,
                'ban_reason' => $this->ban_reason
            ]);

            $this->dispatch('toast', icon: 'success', title: 'کاربر با موفقیت مسدود شد.');
        }
    }

    public function render()
    {
        return view('livewire.admin.edit');
    }
}
