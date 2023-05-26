<?php

namespace App\Http\Controllers;

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
        // dd('tuka');
        return Inertia::render('Shifts/Create', []);
        // return view('home');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // return response()->json($request);
        $shift = new Shift();

        $shift->date = $request->date;
        $shift->worker = $request->worker;
        $shift->company = $request->company;
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
        $data = $request->validate([
            'date' => 'required',
            'worker' => 'required',
            'company' => 'required',
            'hours' => 'required|numeric',
            'rate_per_hour' => 'required|numeric',
            'taxable' => 'required|boolean',
            'status' => 'required',
            'shift_type' => 'required',
            'paid_at' => 'nullable|date',
        ]);

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
