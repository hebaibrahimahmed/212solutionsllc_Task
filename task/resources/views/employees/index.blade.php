@extends('layouts.app')
@section('title')
all employees
@endsection

<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@section('body')
all employees
@endsection


@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <a class="btn btn-warning" href="{{ route('employees.create') }}">Create Employee</a>
                    <br> <br>
                        <table class="table table-striped table-bordered border-2 text-center">
                            <tr>
                                <th>ID</th>
                                <th>name</th>
                                <th>Email</th>
                                <th>company_id</th>
                                <th>Image</th>
                                <th>Show</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->email}}</td>
                                <td>
                                    <select name="employees[]" class="form-control">
                                        @foreach ($employee->company->employees as $companyEmployee)
                                        <option value="{{ $companyEmployee->id }}" {{ $companyEmployee->id === $employee->id ? ' selected' : '' }}>
                                            {{ $companyEmployee->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><img width="100" height="100" src="{{asset('images/employees/'.$employee->image)}}"></td>
                                <td><a href="{{route('employees.show',$employee->id)}}" class="btn btn-info">Show</a></td>
                                <td><a href="{{route('employees.edit', $employee->id)}}" class="btn btn-warning">Edit</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this employee?');" href="{{route('employees.destroy', $employee->id)}}" class="btn btn-danger">Delete</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
@endsection
