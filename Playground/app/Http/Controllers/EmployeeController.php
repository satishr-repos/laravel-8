<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $pageData= [
            'total' => Employee::count(),
            'per_page' => 5
            ];

        return view('employee.create', compact('pageData'));
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
    
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    } 

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    } 
    
    public function update(Employee $employee)
    {
        $data = request()->validate([
             'first_name' => 'required',
             'last_name' => 'required',
             'age' => 'integer|min:10|max:100'
            ]);
      
        $employee->update($data);

        // $employee->first_name = $data['first_name'];
        // $employee->last_name = $data['last_name'];
        // $employee->age = $data['age'];
        // $employee->save();

        return redirect('/employees');
    } 

    public function destroy(Employee $employee)
    {
        $employee->delete();
        
        return redirect('/employees');
    } 
}
