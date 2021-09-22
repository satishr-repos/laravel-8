@extends('layouts.layout')

@section('title', 'Employees Page')

@section('content')

    <section class="section">

        <h2 class="title is-1">Employees List</h2>
        <table class="table">
            <thead>
                @foreach ($columns as $col)
                    <th> {{ $col }} </th>
                @endforeach
                <th> Operation </th>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($employees as $index => $emp)
                    <tr>
                        <th>{{ $index + $employees->firstItem() }}</th>
                        <td>{{ $emp['first_name'] }}</td>
                        <td>{{ $emp['last_name'] }}</td>
                        <td>{{ $emp['age'] }}</td>
                        <td>{{ $emp['created_at'] }}</td>
                        <td>{{ $emp['updated_at'] }}</td>
                        <td><a href="/employees/{{ $emp->id }}" class="button is-link is-small is-light">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $employees->links() !!}

        <a href="/employees/create" class="button">Add Employee</a>

    </section>

@endsection
