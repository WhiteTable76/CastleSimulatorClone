@extends('layouts.app')

@section('title', 'Strona główna')

@section('content')

    @guest
        <div style="border: 3px solid black;">
            <h2>Register</h2>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="login">
                <input name="player_name" type="text" placeholder="player name">
                <input name="email" type="text" placeholder="email">
                <input name="password" type="password" placeholder="password">
                <button>Register</button>
            </form>
        </div>

        <div style="border: 3px solid black;">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input name="loginname" type="text" placeholder="login">
                <input name="loginpassword" type="password" placeholder="password">
                <button>Login</button>
            </form>
        </div>
    @endguest

@endsection
