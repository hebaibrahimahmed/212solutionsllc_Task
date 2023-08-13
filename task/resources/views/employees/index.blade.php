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
                    @if(count($employees) > 0)
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
                                <td><a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning" data-toggle="modal" data-target="#editEmployeeModal{{ $employee->id }}">Edit</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this employee?');" href="{{route('employees.destroy', $employee->id)}}" class="btn btn-danger">Delete</a></td>


                            </tr>
                            @endforeach


                        </table>
                        @else
                        <p>No employees found, please add </p>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCompanyModalLabel">Add Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Company Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control-file" name="logo">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEmployeeModalLabel">Create Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="postedby">Employee Company:</label>
                                <select class="form-select" name="company" aria-label="Default select example">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}"> {{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--  edit model  -->
        @foreach($employees as $employee)
        <div class="modal fade" id="editEmployeeModal{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel{{ $employee->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEmployeeModalLabel{{ $employee->id }}">Edit Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}" enctype="multipart/form-data" id="editEmployeeForm{{ $employee->id }}">
                            @method('post')
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $employee->name }}" id="exampleInputEmail1" aria-describedby="editNameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $employee->email }}" id="exampleInputEmail1" aria-describedby="editEmailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputEmail1" aria-describedby="editPasswordHelp">
                            </div>
                            <div class="mb-3">
                                <label for="postedby">Employee Company:</label>
                                <select class="form-select" name="company" aria-label="Default select example">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ $company->id === $employee->company_id ? 'selected' : '' }}> {{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <button type="submit" class="btn btn-dark">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
@endsection
