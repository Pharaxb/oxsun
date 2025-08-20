<div>
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
            <div class="mb-3">
                <label for="name" class="form-label">نام و نام خانوادگی</label>
                <input type="text" class="form-control" id="name" value="{{ $admin->name.' '.$admin->surname }}" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" class="form-control" id="email" dir="ltr" value="{{ $admin->email }}" wire:model="email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button type="button" class="btn btn-primary" wire:click="changeEmail">ذخیره</button>
    </div>
</div>
