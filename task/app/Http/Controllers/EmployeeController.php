<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Events\UserRegisteredEvent;
use Illuminate\Support\Facades\Mail;



class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $companies = Company::all();
        return view('employees.index', ['employees' => $employees], ['companies' => $companies]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $employee_info = request()->all();
        $image = request()->image;
        $employee = new Employee();
        $employee->name = $employee_info['name'];
        $employee->email = $employee_info['email'];
        $employee->company_id = $employee_info['company'];
        $employee->password = Hash::make($employee_info['password']);

        if ($image) {
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images/employees'), $image_name);
            $employee->image = $image_name;
        }
        $employee->save();

        event(new UserRegisteredEvent($employee));

        return to_route('employees.index');
    }
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return view("employees.show", ['employee' => $employee]);
    }

    public function edit($id)
    {
        $employee = Employee::all();

        $companies = Company::all();

        return view("employees.edit", ['companies' => $companies], compact('id', 'employee'));
    }

    public function update($id)
    {
        $employee = Employee::findOrFail($id);

        $old_image = $employee->image;

        $this->delete_image($old_image);

        $image = request()->file('image');

        if ($image) {
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/employees'), $image_name);
            $employee->image = $image_name;
        }

        $employee->name = request()->input('name');
        $employee->email = request()->input('email');
        $employee->password = bcrypt(request()->input('password'));
        $employee->company_id = request()->input('company');
        $employee->save();

        return redirect()->route('employees.index');
    }


    public function destroy($id)
    {
        try {

            $employee = Employee::findOrFail($id);

            $this->delete_image($employee->image);

            $employee->delete();

            return to_route('employees.index');
        } catch (Exception $e) {

            return $e;
        }
    }
    private  function  delete_image($image)
    {
        if ($image != 'employee.png' and !str_contains($image, '/tmp/')) {

            try {
                unlink(public_path('images/employees/' . $image));
            } catch (Exception $e) {

                echo $e;
            }
        }
    }
}
