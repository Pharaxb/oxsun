<div>
    <div class="card">
        <div class="card-header justify-content-end" dir="ltr">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass" style="width: 20px;"></i></span>
                <input type="text" class="form-control" placeholder="جستجو بر اساس عنوان، کاربر..." dir="rtl" wire:model.live.debounce.300="title">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>کاربر</th>
                        <th>دیده شده از تیراژ</th>
                        <th>هزینه هر آگهی</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        <tr>
                            <td>{{ $ad->title }}</td>
                            <td>
                                @if($ad->user_id != null)
                                    @if($ad->user->name != null and $ad->user->surname != null)
                                        {{ $ad->user->name.' '.$ad->user->surname }}
                                    @else
                                        {{ to_farsi_number($ad->user->mobile) }}
                                    @endif
                                @else
                                    اکسان
                                @endif
                            </td>
                            <td>{{ to_farsi_number(number_format($ad->viewed).' از '.number_format($ad->circulation)) }}</td>
                            <td>{{ to_farsi_number(number_format($ad->cost)) }}</td>
                            <td>{{ $ad->status->name }}</td>
                            <td>{{ to_farsi_number(\verta($ad->start_date)->format('Y-m-d').' - '.\verta($ad->end_date)->format('Y-m-d')) }}</td>
                            <td class="text-center">
                                <a href="{{ route('ads.edit', ['ad' => $ad->id]) }}" class="btn btn-sm btn-outline-secondary me-1" title="ویرایش"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $ads->links() }}
        </div>
    </div>
</div>
