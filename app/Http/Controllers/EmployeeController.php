<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Shift;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        $employees = Employee::all();

        return Inertia::render('Employees/Index', [
            'employees' => $employees,
        ]);
    }

    public function show(Employee $employee)
    {
        // Calculate average pay per hour
        $averagePayPerHour = Shift::where('worker', $employee->id)
            ->whereNotNull('worker')
            ->avg('rate_per_hour');

        // Calculate total pay
        $totalPay = Shift::where('worker', $employee->id)
            ->whereNotNull('worker')
            ->sum(\DB::raw('rate_per_hour * hours'));

        // Get the number of shifts worked
        $numberOfShifts = Shift::where('worker', $employee->id)
            ->whereNotNull('worker')
            ->count();

        // Calculate average total pay
        $averageTotalPay = $totalPay / $numberOfShifts;

        // Append calculated values to the employee object
        $employee->average_pay_per_hour = number_format($averagePayPerHour, 3);
        $employee->average_total_pay = number_format($averageTotalPay,3);

        $lastFiveCompletedPayments = Shift::where('worker', $employee->id)
            ->where('status', 'Complete')
            ->whereNotNull('paid_at')
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        // Send the modified employee object to the front end
        return Inertia::render('Employees/Show', [
            'employee' => $employee,
            'shifts' => $lastFiveCompletedPayments
        ]);
    }




}
