<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'UTS Pem Web')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-white">
    {{-- navbar mulai disini --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="{{ route('home') }}">UTS Pem Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}"
                            href="{{ route('tentang') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('uts') ? 'active' : '' }}"
                            href="{{ route('uts') }}">iqbal dan davi</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link disabled" aria-disabled="true">24010110190 / 24010110214</span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- navbar selesai disini --}}

    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    {{-- footer mulai disini --}}
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tentang') }}" class="nav-link px-2 text-body-secondary">Features</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">Pricing</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-body-secondary">FAQs</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tentang') }}" class="nav-link px-2 text-body-secondary">About</a>
                </li>
            </ul>
            <p class="text-center text-body-secondary small mb-0">
                © 2025 Dibuat Sejujurjurnya Oleh Team iqbal dan davi Tanpa Mencotek dari Tim Lain
            </p>
        </footer>
    </div>
    {{-- footer selesai disini --}}

    @stack('scripts')
</body>

</html>
