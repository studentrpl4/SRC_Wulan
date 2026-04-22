<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- Vite CSS & JS -->
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
{{--
<link href="{{asset('output.css')}}" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Title -->
<title>@yield('title', 'My Laravel App')</title>

<!-- Placeholder untuk meta tambahan atau CSS/JS khusus halaman -->
@stack('head')