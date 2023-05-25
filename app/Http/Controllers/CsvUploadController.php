<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CsvUploadController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Upload/Index', [
            //
        ]);
    }

    public function store(Request $request)
    {

        // return 'Here';
        $file = $request->file('csv_file');

        if ($file->getClientOriginalExtension() !== 'csv') {
            return response()->json(['error' => 'Invalid file format. Only CSV files are allowed.'], 422);
        }

        $path = $file->store('csv_files');

        // print_r('Here');die;
        $handle = fopen(storage_path("app/$path"), 'r');

        if ($handle) {
            DB::beginTransaction();

            try {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Skip the CSV file header row
                    if ($data[0] === 'Date') {
                        continue;
                    }

                    // Remove currency symbol from rate_per_hour
                    $ratePerHour = preg_replace('/[^0-9.]/', '', $data[4]);

                    // Map 'Yes'/'No' to true/false for taxable column
                    $taxable = $data[5] === 'Yes' ? true : false;

                    // Check if paid_at value is provided
                    $paidAt = $data[8] ? $data[8] : null;

                    DB::table('shifts')->insert([
                        'date' => $data[0],
                        'worker' => $data[1],
                        'company' => $data[2],
                        'hours' => $data[3],
                        'rate_per_hour' => $ratePerHour,
                        'taxable' => $taxable,
                        'status' => $data[6],
                        'shift_type' => $data[7],
                        'paid_at' => $paidAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::commit();

                fclose($handle);

                return response()->json(['message' => 'CSV file uploaded and data stored successfully.']);
            } catch (\Exception $e) {
                DB::rollBack();
                fclose($handle);

                Log::error($e->getMessage()); // Log the exception message

                return response()->json(['error' => 'An error occurred while storing the data. Please try again.'], 500);
            }
        } else {
            return response()->json(['error' => 'Failed to open the CSV file. Please try again.'], 500);
        }

    }

}
