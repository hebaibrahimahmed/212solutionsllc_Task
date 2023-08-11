@extends('layouts.app')

@section('title')
employee from Database
@endsection

@section('content')
<h1>{{$employee->name}} Info</h1>
<div class="card" style="width: 18rem;">
    <img width="290" height="200" src="{{asset('images/employees/'.$employee->image)}}">
    <div class="card-body">
        <h5 class="card-title">{{$employee->name}}</h5>
        <p class="card-text">{{$employee->email}}</p>
        <p>Created At: {{ \Carbon\Carbon::parse($employee->created_at)->format('Y-m-d')}}</p>
        <a href="{{route('employees.index')}}" class="btn btn-primary">All employees</a>
    </div>
</div>
@endsection
