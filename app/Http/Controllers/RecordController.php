<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room911Request;
use App\Models\{Record, Employee};
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Room911Request $request)
    {
        try {
            $employee = Employee::where('employee_id', $request['employee_id'])->first();

            if ($employee) {
                $openRecord = Record::where('employee_id', $employee->id)
                    ->whereNotNull('income')
                    ->whereNull('exit')
                    ->first();

                if ($openRecord) {
                    $exitDateTime = Carbon::createFromFormat('d/m/Y, g:i:s A', $request->exit);
                    $incomeDateTime = Carbon::parse($openRecord->income);
                    $diffHours = $exitDateTime->floatDiffInHours($incomeDateTime);

                    $openRecord->update([
                        "exit" => $exitDateTime,
                        "diff_income_exit_hours" => $diffHours
                    ]);
                    return response()->json(['message' => 'successful exit'], 200);
                } else {
                    $lastCompletedRecord = Record::where('employee_id', $employee->id)
                        ->whereNotNull('income')
                        ->whereNotNull('exit')
                        ->latest('exit')
                        ->first();

                    if (!$lastCompletedRecord || Carbon::parse($lastCompletedRecord->exit)->addMinutes(1) < Carbon::now()) {
                        $incomeDateTime = Carbon::createFromFormat('d/m/Y, g:i:s A', $request->income);
                        Record::create([
                            'employee_id' => $employee->id,
                            'income' => $incomeDateTime,
                        ]);
                    }
                }

                return response()->json(['message' => 'successful check-in'], 200);
            } else {
                $recordData = [
                    'employee_id' => null,
                    'income' => Carbon::createFromFormat('d/m/Y, g:i:s A', $request->income),
                ];

                Record::create($recordData);

                return response()->json([
                    'message' => 'The employee does not exist. Please verify the ID provided',
                    'error' => 'The employee does not exist. Please verify the ID provided'
                ], 422);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }
}
