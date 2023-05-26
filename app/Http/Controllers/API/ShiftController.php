<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::paginate(15);
        $employees = Employee::all();
        $companies = Company::all();

        foreach ($shifts as $shift) {
            $worker = $employees->firstWhere('id', $shift->worker);
            $shift->worker = $worker ? $worker->full_name : null;

            $company = $companies->firstWhere('id', $shift->company);
            $shift->company = $company ? $company->name : null;
        }

        return response()->json($shifts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
