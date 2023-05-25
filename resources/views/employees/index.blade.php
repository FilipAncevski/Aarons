<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <!-- Add other columns as needed -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->full_name }}</td>
                <!-- Add other columns as needed -->
                <td>
                    {{-- <a href="{{ route('employees.show', $employee->id) }}">View</a> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
