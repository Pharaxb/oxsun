<div>
    <div class="card">
        <div class="card-header justify-content-end" dir="ltr">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass" style="width: 20px;"></i></span>
                <input type="text" class="form-control" placeholder="جستجو بر اساس نام، ایمیل..." dir="rtl">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead>
                    <tr>
                        <th>آواتار</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل</th>
                        <th>سطح دسترسی</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>
                                @if($admin->avatar != Null)
                                    <img src="{{ Storage::url($admin->avatar) }}" class="rounded-circle small-avatar" alt="Avatar">
                                @else
                                    <img src="{{ asset('assets/images/default_user.jpeg') }}" class="rounded-circle small-avatar" alt="Avatar">
                                @endif
                            </td>
                            <td>{{ $admin->name.' '.$admin->surname }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @foreach($admin->roles as $role)
                                    <span class="badge"  style="background-color: {{ $role->color }}; color: {{ getContrastingTextColor($role->color) }}">{{ $role->label }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admins.edit', ['admin' => $admin->id]) }}" class="btn btn-sm btn-outline-secondary me-1" title="ویرایش"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-sm btn-outline-danger" title="حذف"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $admins->links() }}
        </div>
    </div>
</div>
