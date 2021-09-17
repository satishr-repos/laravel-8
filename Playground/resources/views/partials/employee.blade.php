<section class="section">

    <h2 class="title is-1">Employees List</h2>
    <table class="table">
        <thead>
            @foreach ($columns as $col)
                <th> {{ $col }} </th>
            @endforeach
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
            @foreach ($employees as $emp)
                <tr>
                    <th>{{ $loop->index }}</th>
                    <td>{{ $emp['first_name'] }}</td>
                    <td>{{ $emp['last_name'] }}</td>
                    <td>{{ $emp['age'] }}</td>
                    <td>{{ $emp['created_at'] }}</td>
                    <td>{{ $emp['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>
