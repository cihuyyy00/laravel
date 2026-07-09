@extends('layout.user')

@section('content')

<p>Halo {{ Auth::user()->name }}, kamu login sebagai <strong>{{ Auth::user()->role }}</strong></p>

<ul>
<li>Username : {{ Auth::user()->name }}</li>
<li>Email    : {{ Auth::user()->email }}</li>
</ul>

@endsection