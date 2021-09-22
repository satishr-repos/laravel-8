@extends('layouts.layout')

@section('title', 'Employee Details')

@section('content')
    <div class="container">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">{{ $employee->first_name }} {{ $employee->last_name }}</p>
            </header>
            <div class="card-content">
                <div class="content">
                    <p>Age: {{ $employee->age }}</p>
                    <p>Created At: {{ $employee->created_at }}</p>
                    <p>Updated At: {{ $employee->updated_at }}</p>
                </div>
            </div>
        </div>

        <div class="buttons mt-1">
            <a href="/employees/{{$employee->id}}/edit" class="button is-link">Edit</a>
            <form action="/employees/{{$employee->id}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger">Delete</button>
            </form>
        </div>
    </div>
@endsection