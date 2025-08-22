<div>
    @if($admin->avatar != Null)
        <img src="{{ Storage::url($admin->avatar) }}" class="rounded-circle small-avatar" alt="Avatar" loading="lazy" />
    @else
        <img src="{{ asset('assets/images/default_user.jpeg') }}" class="rounded-circle small-avatar" alt="Avatar" loading="lazy" />
    @endif
</div>
