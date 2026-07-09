@extends('layout.admin')

@section('content')

<h1>Admin Dashboard</h1>
<p>Halo {{ Auth::user()->name }}, kamu login sebagai <strong style="color: red;">{{ Auth::user()->role }}</strong></p>

<ul>
    <li>Username : {{ Auth::user()->name }}</li>
    <li>Email : {{ Auth::user()->email }}</li>
</ul>
@endsection