<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin @yield('title')</title>
        <style>
            body {
                background-color: black;
                text-align: center;
                color: white;
            }

            .nav {
                justify-content: center;
                display: flex;
                gap: 20px;
                list-style: none;
                background: #3333335a;
                font-weight: bold;
            }

            h1 {
                font-size: 50px;
                font-weight: bold;
                background: linear-gradient(90deg, #82c8ee, #00a6ff);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            a {
                text-decoration: none;
                color: rgb(214, 214, 223);
            }

            a:hover {
                color: aqua;
                font-size: 18px;
                transition: 0.3s;
            }
        </style>
    </head>
    <body>
        <!-- header/navbar -->
        <div class="header">
            <nav>
                <ul class="nav">
                    <li>
                        @auth @if(Auth::user()->role === 'admin')
                        <a href="/dashboard">Dashboard</a>
                        @endif @endauth
                    </li>

                    <li><a href="/admin/dasbor">Home</a></li>
                    <li><a href="/admin/users">User</a></li>
                    <li><a href="/dasbor">Sekolah</a></li>
                </ul>
            </nav>
        </div>

        <!-- isi konten -->
        <div class="content">@yield('content')</div>

        <!-- footer -->
        <div class="footer">
            <hr />
            <p>Copyright 2025</p>
        </div>
    </body>
</html>
