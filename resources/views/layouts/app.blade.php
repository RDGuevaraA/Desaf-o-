<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Bosco English Academy - @yield('title')</title>
    <link rel="icon" href="{{ asset('storage/pngegg (1).png') }}" type="image/png">
    @vite('resources/css/app.css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <header class="bg-white text-gray-600 shadow-md">
        <div class="container mx-auto h-[125px] px-5 flex justify-between items-center">
            <a class="flex items-center space-x-2 h-[100%]" href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.home') : route('tutor.home')) : url('/') }}">
                <img src="{{ asset('storage/englishAcademy.png') }}" alt="Logo" class="h-[90%]">
            </a>
            <div class="flex items-center space-x-4">
                @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-7 py-3 rounded-lg text-sm font-medium transition duration-200">
                        Cerrar sesión
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </header>

    <main class="container mx-auto px-5 py-6">
        @yield('content')
    </main>

    <!--<footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Academia Management. Todos los derechos reservados.</p>
        </div>
    </footer>-->
</body>
</html>