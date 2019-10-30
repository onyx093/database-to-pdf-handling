<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <title>Username list from the database</title>
</head>
<body>
    <h1>Names list from the database</h1>

<a href="{{ route('generate-pdf') }}">Generate PDF</a>

    <table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email address</th>
                <th scope="col">Time verified</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($user_data as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->email_verified_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>{{ $user_data->links() }}</p>
</body>
</html>