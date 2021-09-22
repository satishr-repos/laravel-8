@extends('layouts.layout')

@section('title', 'Add New Employee')

@section('content')
    <div class="container">
        <form action="/employees/{{$employee->id}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="field">
                <label class="label">First Name</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Text input" name="first_name"
                        value="{{ $employee->first_name }}" />
                </div>
                <p class="help">Enter your given name</p>
                @error('first_name') {{ $message }}     @enderror
            </div>

            <div class="field">
                <label class="label">Last Name</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Text input" name="last_name"
                        value="{{ $employee->last_name }}" />
                </div>
                <p class="help">Enter your surname</p>
                @error('last_name') {{ $message }}     @enderror
            </div>

            <div class="field">
                <label class="label">Age</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Text input" name="age"
                        value="{{ $employee->age }}" />
                </div>
                <p class="help">Enter your age</p>
                @error('age') {{ $message }}     @enderror
            </div>

            <div class="control">
                <button class="button is-primary" type="submit" value="submit">Save Changes</button>
            </div>
        </form>
    </div>

@endsection
