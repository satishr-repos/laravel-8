@extends('layouts.layout')

@section('title', 'Add New Employee')

@section('content')

    <div id="app">
        <add-employee> {{ csrf_field() }} </add-employee>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset(mix('js/app.js')) }}" async defer></script>
@endsection
