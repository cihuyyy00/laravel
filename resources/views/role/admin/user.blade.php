@extends('layout.admin')
@section('header', 'Home')

@section('content')
   
     <h2>Daftar User</h2>

     @php
          // bikin var
          $users = ['User 1', 'User 2', 'User 3', 'User 4', 'User 5'];
     @endphp

     <ul>
          <!-- make foreach biar bisa ditampilin -->
          @foreach ($users as $user)
               <li>{{ $user }}</li>
          @endforeach
     </ul>

@endsection
