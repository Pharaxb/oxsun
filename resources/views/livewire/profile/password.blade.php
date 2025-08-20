<div>
    <h5 class="card-title">تغییر گذرواژه</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">گذرواژه</label>
                <input type="password" class="form-control" id="password" dir="ltr" autocomplete="new-password" wire:model="password">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">تکرار گذرواژه</label>
                <input type="password" class="form-control" id="password_confirmation" dir="ltr" autocomplete="new-password" wire:model="password_confirmation">
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <button type="button" class="btn btn-primary" wire:click="changePassword">ذخیره</button>
    </div>
</div>
