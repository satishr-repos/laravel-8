<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index() 
    {
        // $employees = Employee::all();
        $employees = Employee::paginate(5);

        $emp = new Employee();
        $columns = $emp->GetTableColumns();
        
        return view('employee.index', compact('employees', 'columns'));
    }

    public function create() 
    {
        return view('employee.create');
    }

    public function store() 
    {
        $data = request()->validate([
             'first_name' => 'required',
             'last_name' => 'required',
             'age' => 'integer|min:10|max:100'
            ]);
       
        Employee::create($data);
            
        return redirect('/employees');
    }
}
