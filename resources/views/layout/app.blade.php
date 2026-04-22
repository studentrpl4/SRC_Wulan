<!DOCTYPE html>
<html lang="en">

<head>
    @include('head.head')

    <title>@yield('title', 'Mobile Page')</title>
</head>

<body class=" min-h-screen flex items-center justify-center ">

    <div class="w-full max-w-md">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
