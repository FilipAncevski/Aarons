<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Shift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShiftController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Shifts/Index', [

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Shifts/Create', []);;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if the worker exists, otherwise create a new one
        $employee = Employee::firstOrCreate(['full_name' => $request->worker]);

        // Check if the company exists, otherwise create a new one
        $company = Company::firstOrCreate(['name' => $request->company]);

        // Create a new shift
        $shift = new Shift();
        $shift->date = $request->date;
        $shift->worker = $employee->id;
        $shift->company = $company->id;
        $shift->hours = $request->hours;
        $shift->rate_per_hour = $request->rate_per_hour;
        $shift->taxable = $request->taxable;
        $shift->status = $request->status;
        $shift->shift_type = $request->shift_type;
        $shift->paid_at = $request->paid_at;
        $shift->save();

        return redirect(route('shifts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        return Inertia::render('Shifts/Show', []);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift): RedirectResponse
    {
        $requestData = $request->all();

        $worker = Employee::firstOrCreate(['full_name' => $requestData['worker']]);
        $company = Company::firstOrCreate(['name' => $requestData['company']]);

        $data = [
            'date' => $requestData['date'],
            'worker' => $worker->id,
            'company' => $company->id,
            'hours' => $requestData['hours'],
            'rate_per_hour' => $requestData['rate_per_hour'],
            'taxable' => $requestData['taxable'],
            'status' => $requestData['status'],
            'shift_type' => $requestData['shift_type'],
            'paid_at' => $requestData['paid_at'],
        ];

        $shift->update($data);

        return redirect(route('shifts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect(route('shifts.index'));
    }
}
