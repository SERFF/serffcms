<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nano Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{ asset('themes/nano/css/flatly.min.css') }}" media="screen">
</head>
<body>

</body>
@include('partials.menu')
@yield('content')
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>