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
                        <th>نام و نام خانوادگی</th>
                        <th>موبایل</th>
                        <th>اعتبار</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td
                                @if($user->gender == 'male')
                                    style="color: cornflowerblue"
                                @elseif($user->gender == 'female')
                                    style="color: hotpink"
                                @endif
                            >
                            {{ $user->name.' '.$user->surname }}
                            </td>
                            <td>
                                @if($user->operator != NULL)
                                    <span class="badge" style="background-color: {{ $user->operator->color }}; color: {{ getContrastingTextColor($user->operator->color) }}">{{ $user->operator->brand }}</span>
                                @endif
                                {{ $user->mobile }}
                                @if($user->mobile_verified_at != NULL)
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                @endif
                            </td>
                            <td>{{ to_farsi_number(number_format($user->credit)) }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-outline-secondary me-1" title="ویرایش"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $users->links() }}
        </div>
    </div>
</div>
