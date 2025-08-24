<div>
    <h5 class="card-title">ویرایش اطلاعات</h5>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name" class="form-label">نام</label>
                <input type="text" class="form-control" id="name" wire:model="name">
            </div>
            <div class="col-md-4 mb-3">
                <label for="surname" class="form-label">نام خانوادگی</label>
                <input type="text" class="form-control" id="surname" wire:model="surname">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="mobile" class="form-label">موبایل</label>
                <input type="text" class="form-control" id="mobile" dir="ltr" value="{{ $user->mobile }}@if($user->operator != NULL) {{ ' ('.$user->operator->brand.')' }} @endif" disabled>
                <div class="form-text">
                    تائید شده: {{ to_farsi_number(\Hekmatinasser\Verta\Verta::instance($user->mobile_verified_at)->format('d F Y - H:i:s')) }}
                </div>
                @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="gender" class="form-label">جنسیت</label>
                @php
                if ($user->gender == 'male') {
                    $gender = 'مرد';
                }
                elseif($user->gender = 'female') {
                    $gender = 'زن';
                }
                else {
                    $gender = 'نامعلوم';
                }
                @endphp
                <input type="text" class="form-control" id="gender" value="{{ $gender }}" disabled wire:model="gender">
            </div>
            <div class="col-md-4 mb-3">
                <label for="birthday" class="form-label">تاریخ تولد</label>
                <input type="text" class="form-control" id="birthday" value="{{ to_farsi_number(\Hekmatinasser\Verta\Verta::instance($user->birthday)->format('d F Y')) }}" disabled wire:model="birthday">
            </div>
        </div>
    <div class="text-center mt-4">
        <button type="button" class="btn btn-primary" wire:click="changeInformation">ذخیره</button>
    </div>
</div>
