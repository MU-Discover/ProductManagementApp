<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <title>@yield('title', '')</title>
</head>
 <style>
    body{
        width: 40%;
        /* height: 500px; */
        /* display: flex; */
        left: 0;right: 0;top: 0;bottom: 0;
        margin: auto;
    }
 </style>
<body>
    <div>
        @yield('content')
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

</html>
