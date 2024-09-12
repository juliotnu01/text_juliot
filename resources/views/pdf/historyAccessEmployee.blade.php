<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>History Access Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>History Access Employee: {{ $data['first_name'] }} {{ $data['last_name'] }}</h1>
    <p>Department: {{ $data['department']['name'] }}</p>
    <table>
        <thead>
            <tr>
                <th>Income</th>
                <th>Exit</th>
                <th>Diff. Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['history'] as $record)
                <tr>
                    <td>{{ $record['income'] }}</td>
                    <td>{{ $record['exit'] }}</td>
                    <td>{{ $record['diff_income_exit_hours'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
