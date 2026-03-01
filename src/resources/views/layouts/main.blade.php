<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc @hasSection('title') - @yield('title') @endif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">
    @stack('styles')
</head>

<body class="antialiased text-gray-800">

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.flash-messages')

    @stack('scripts')

    @include('layouts.footer')

</body>
</html>