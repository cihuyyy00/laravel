<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User @yield('title')</title>
    <style>
          .nav {
                padding: 0;
                display: flex;
                gap: 20px;
                list-style: none;
                font-weight: bold;
                
            }
            a {
                text-decoration: none;
                color: blue;
            }

            a:hover {
                text-decoration: underline;
            }

            button {
                background-color: white;
                font-weight: bold;
                font-size: 16px;
                color: red;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                font-family: 'Times New Roman', Times, serif;
            }
            button:hover {
                text-decoration: underline;
            }
    </style>
</head>
<body>

    <!-- header/navbar -->
    <div class="header">
        <h1>Dashboard User</h1>

    <nav>
        <ul class="nav">
            <li> 
                @auth
                @if(Auth::user()->role === 'user')
                <a href="{{ route('siswa.index') }}">Siswa</a>
                @endif
                @endauth
            </li>

            <li><a href="/admin/home">Home</a></li>
            <li><a href="/admin/profil">Profile</a></li>
            <li><form action={{ route('logout')}} method="post">
            @csrf    
            <button type="submit" onclick="return confirm('Logout kah?')">Logout</button></form></li>
        </ul>
       
        
        
    </nav>
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