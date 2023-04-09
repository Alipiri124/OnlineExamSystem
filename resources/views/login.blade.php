@extends('layout/layout-common')

@section('space-work')

    <h1>Login</h1>
    @if($errors->any())
       @foreach($errors->all() as $error)
       <p style="color:red;">{{$error}}</p>
       @endforeach
    @endif

     @if(Session::has('error'))
     <p style="color:red;">{{Session::get('error')}}</p>
     @endif

      

<form action="{{route('userLogin')}}" method="POST">
 @csrf
 <input type="email" name="email" placeholder="Enter email">
 <br><br>
 <input type="password" name="password" placeholder="Enter password">
 <br><br>
 <input type="submit" value="Login">
</form>

<a href="/forget-password">Forgot Password</a>
@if(Session::has('success'))
     <p style="color:green;">{{Session::get('success')}}</p>
@endif 
@endsection
