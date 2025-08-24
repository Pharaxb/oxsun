<div>
    <div class="card mb-3">
        <div class="card-body p-4">
            <h5 class="card-title">ویرایش اطلاعات</h5>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="avatar-container position-relative mx-auto d-block" style="width: 150px; height: 150px;">
                        <label for="avatarUpload" class="avatar-upload-container position-relative d-block">
                            @if($admin->avatar != Null)
                                <img src="{{ Storage::url($admin->avatar) }}" id="avatarPreview" class="img-thumbnail rounded-circle" alt="Avatar">
                            @else
                                <img src="{{ asset('assets/images/default_user.jpeg') }}" id="avatarPreview" class="img-thumbnail rounded-circle" alt="Avatar">
                            @endif
                            <div class="avatar-overlay">
                                <i class="fas fa-camera"></i>
                                <span class="d-block mt-1">تغییر</span>
                            </div>
                        </label>
                        <input type="file" id="avatarUpload" class="d-none" accept="image/*" wire:model="avatarInput">
                        <button type="button" id="deleteAvatarBtn" class="btn btn-danger btn-sm rounded-circle avatar-delete-btn" wire:click="deleteAvatar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">نام</label>
                            <input type="text" class="form-control" id="name" value="{{ $admin->name }}" wire:model="name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="surname" class="form-label">نام خانوادگی</label>
                            <input type="text" class="form-control" id="surname" value="{{ $admin->surname }}" wire:model="surname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">ایمیل</label>
                            <input type="email" class="form-control" id="email" dir="ltr" value="{{ $admin->email }}" wire:model="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">موقعیت شغلی</label>
                            <input type="text" class="form-control" id="position" value="{{ $admin->position }}" wire:model="position">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary" wire:click="changeInformation">ذخیره</button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body p-4">
            <h5 class="card-title">سطح دسترسی</h5>
            <div class="row">
                <div class="col-md">
                    <div class="mb-3">
                        <div class="position-tags-container border rounded p-3">
                            @foreach($roles as $role)
                                <div class="form-check position-tag" style="--position-color: {{ $role->color }}; --text-color: {{ getContrastingTextColor($role->color) }};">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->name }}" id="role{{ $role->id }}" wire:model="selectedRoles" @if(in_array($role->name, $selectedRoles)) checked @endif>
                                    <label class="form-check-label" for="role{{ $role->id }}">{{ $role->label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary" wire:click="changePositions">ذخیره</button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body p-4">
            <h5 class="card-title">مسدود سازی</h5>
            <div class="row">
                <div class="mb-3">
                    @if($is_ban == false)
                        <label for="ban_reason" class="form-label">علت مسدود سازی</label>
                        <input type="text" class="form-control" id="ban_reason" value="{{ $admin->ban_reason }}" placeholder="خروج از اکسان..." wire:model="ban_reason">
                    @else
                        علت: {{ $admin->ban_reason }}
                    @endif</div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-danger" wire:click="changeBan">@if($is_ban == false) مسدود کردن @else خروج از مسدود سازی @endif</button>
            </div>
        </div>
    </div>
</div>
