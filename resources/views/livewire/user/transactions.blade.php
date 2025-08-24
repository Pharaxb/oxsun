<div>
    <h5 class="card-title">تراکنش‌ها</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead>
            <tr>
                <th>شرح</th>
                <th>مبلغ</th>
                <th>تاریخ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ to_farsi_number(\Hekmatinasser\Verta\Verta::instance($transaction->created_at)->format('d F Y - H:i:s')) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    {{ $transactions->links() }}
</div>
