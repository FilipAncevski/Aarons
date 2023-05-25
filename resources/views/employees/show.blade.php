<h1>{{ $employee->full_name }}</h1>
<p>Average Pay per Hour: {{ $averagePayPerHour }}</p>
<p>Average Total Pay: {{ $averageTotalPay }}</p>

<h2>Last Five Completed Payments:</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Hours</th>
            <th>Rate per Hour</th>
            <th>Total Pay</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lastFivePayments as $payment)
            <tr>
                <td>{{ $payment->date }}</td>
                <td>{{ $payment->hours }}</td>
                <td>{{ $payment->rate_per_hour }}</td>
                <td>{{ $payment->total_pay }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
