<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index() {

        $employees = Employee::all();

        $emp = new Employee();
        $columns = $emp->GetTableColumns();
        
        return view('employee', [
            'employees' => $employees,
            'columns' => $columns
        ]);
    }
}
