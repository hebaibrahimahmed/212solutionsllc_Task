<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $employees = Employee::all();

        return $employees;
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
        $employee->password = $employee_info['password'];

        if ($image) {
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images/employees'), $image_name);
            $employee->image = $image_name;
        }

        $employee->save();

        return response()->json([
            'data' => [
                'employee' => $employee,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return  response()->json(['employee' => $employee]);
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
    public function update(Employee $employee,Request $request)
    {
        $old_image= $employee->image;
        $employee->update($request->all());

        if($request->image){

            if($old_image!='employee.png'){

                try{

                    unlink(public_path('images/employees/'.$old_image));

                } catch (Exception $e){
                }
            }

            $image_name = time().'.'.$request->image->extension();

            $request->image->move(public_path('/images/employees'), $image_name);

            $employee->image=  $image_name;

            $employee->save();
        }

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $this->delete_image($employee->image);
            $employee->delete();
            return Employee::all();
        } catch (Exception $e) {

            return $e;
        }
    }

    // delete the image

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
