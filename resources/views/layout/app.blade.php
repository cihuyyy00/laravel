<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        nav svg {
            display: none;
            width: 10px;
            height: 10px;
        }
    </style>
</head>
<body style="background: #f4f4f4; font-family: Arial, Helvetica, sans-serif;">

    <!-- header/navbar -->
    <div class="header">
        <h1>Belajar laravel</h1>
        <hr>
    </div>

    <!-- isi konten -->
    <div class="content">
        @yield('content')
    </div>

    <!-- footer -->
    <div class="footer">
        <hr>
        <p>Copyright 2025</p>
    </div>
</body>
</html>