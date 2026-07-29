<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ZamekSymulator')</title>
</head>
<body>

    <nav style="border-bottom: 2px solid black; padding: 10px;">
        @auth
            <a>Profil Gracza</a>
            <a>Wioska</a>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button>Wyloguj</button>
            </form>
        @else
        <p>Zaloguj się aby zobaczyć swoje informacje!</p>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
