<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <div id="tablediv">
        <h1>{{ $data['body'] }}</h1>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $data['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data['email'] }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>{{ $data['password'] }}</td>
            </tr>
        </table>
    </div>
    
    <a href="{{ $data['url'] }}">Click here to Login in your Account</a>
    <p>Thank you</p>
</body>