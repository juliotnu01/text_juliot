<?php

namespace Database\Seeders;

use App\Models\{Department, Employee};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        Employee::factory()
            ->count(10)
            ->make()
            ->each(function ($employee) use ($departments) {
                $employee->department_id = $departments->random()->id;
                $employee->save();
            });
    }
}
