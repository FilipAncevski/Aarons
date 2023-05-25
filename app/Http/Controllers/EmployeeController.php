<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::latest()->take(5)->get(),
        ]);
    }

    public function show(Employee $employee)
    {
        $averagePayPerHour = $employee->avg('rate_per_hour');

        $totalPay = 0;
        $recordCount = 0;

        foreach ($employee->get() as $record) {
            $totalPay += ($record->hours * $record->rate_per_hour);
            $recordCount++;
        }

        $averageTotalPay = ($recordCount > 0) ? ($totalPay / $recordCount) : 0;

        $lastFivePayments = $employee->where('status', 'Complete')->orderBy('paid_at', 'desc')->take(5)->get();

        return view('employees.show', compact('employee', 'averagePayPerHour', 'averageTotalPay', 'lastFivePayments'));
    }



}
