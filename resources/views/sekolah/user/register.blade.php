@if (session('error'))
    <div style="color:yellow; border: 1px red solid; padding: 10px; text-align: center; background-color: red;">
        {{ session('error') }}
    </div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Form Registrasi User Guru Baru</h2>    

    <form action="/regguru" method="post">
        @csrf
        <label>Nama</label><br>
        <input type="text" name="name" placeholder="Nama" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <button type="submit"">Daftar</button>
    </form>
</body>
</html>