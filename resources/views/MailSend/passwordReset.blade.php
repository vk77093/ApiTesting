<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
    <style>
        .btnclass{
            color: red;
            border: solid 2px greenyellow;
            size: 40px;
        }
    </style>
</head>
<body>
    <h2>THat Mail is Send  from password Reset</h2>
    <p>Please find the reset Link below</p>
    <br>
<a href="http://localhost:3000/reset/{{$data}}" target="_blank"><button type="button" class="btnclass">Reset Password</button></a>
    <h3>Code is {{$data}}</h3>
</body>
</html>
