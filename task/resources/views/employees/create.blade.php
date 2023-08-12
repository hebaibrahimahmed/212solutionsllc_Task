@extends('layouts.app')
@section('title')
Create employee
@endsection

<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@section('body')
please submit your data
@endsection


@section('content')

<div class="container" >

<form method="POST" action="/employees/store" enctype="multipart/form-data">
    @method('post')
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" name="name"  id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email"  id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">password</label>
        <input type="password" class="form-control" name="password"  id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>

    <div class="mb-3">
        <label for="postedby">emp company:</label>
        <select class="form-select" name="company" aria-label="Default select example">
                <option selected disabled>Open this select menu</option>
                @foreach($companies as  $company)
                    <option value="{{$company->id}}"> {{$company->name}}</option>
                @endforeach
            </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
        </div>
    <button type="submit" class="btn btn-dark">Submit</button>
</form>
@endsection
