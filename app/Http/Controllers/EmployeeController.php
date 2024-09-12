<?php

namespace App\Http\Controllers;

use App\Http\Requests\{EmployeeRequest, EmployeeUpdateRequest, EmployeeUpdateActiveEmployeeRequest, EmployeeImportCsvRequest};
use App\Http\Resources\EmployeeResource;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Excel;
use Mpdf\Mpdf;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = Employee::with(['department', 'history'])->paginate(10);
            return EmployeeResource::collection($employees);
        } catch (\Throwable $th) {
            throw $th;
        }
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
    public function store(EmployeeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $employee = Employee::create($validatedData);
            $employee->load('department');
            return new EmployeeResource($employee);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        try {
            $validatedData = $request->validated();
            $employee->update($validatedData);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update active the specified resource in storage.
     */
    public function updateActiveEmployee(EmployeeUpdateActiveEmployeeRequest $request, Employee $employee)
    {
        try {
            $validatedData = $request->validated();
            $employee->update([
                "active" => $validatedData['active']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->forceDelete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * import csv   
     */

    public function importCsvEmployee(EmployeeImportCsvRequest $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('file'), \Maatwebsite\Excel\Excel::CSV);
            return response()->json(['message' => 'CSV importado con exito'], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * generate pdf history of employee
     */

    public function generateEmployeePdf(Request $request)
    {

        $mpdf = new Mpdf();
        $data = $request->all();

        $html = view('pdf.historyAccessEmployee', compact('data'))->render();

        $mpdf->WriteHTML($html);

        $firstName = $data['first_name'];
        
        return $mpdf->Output("history-access-$firstName.pdf", 'D');
    }
}
