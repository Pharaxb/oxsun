<div>
    <h5 class="card-title">لوکیشن‌ها</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead>
            <tr>
                <th>لوکیشن</th>
                <th>منطقه</th>
                <th>تاریخ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locations as $location)
                <tr class="small">
                    <td><a href="https://maps.google.com/maps?q={{ $location->latitude.','.$location->longitude }}" target="_blank" dir="ltr">{{ $location->latitude.', '.$location->longitude }}</a></td>
                    <td>{{ $location->province->name.'، '.$location->city->name }}@if($location->district){{ '، '.$location->district->name }}@endif</td>
                    <td>{{ to_farsi_number(\Hekmatinasser\Verta\Verta::instance($location->created_at)->format('d F Y - H:i:s')) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    {{ $locations->links(data: ['scrollTo' => false]) }}
</div>
