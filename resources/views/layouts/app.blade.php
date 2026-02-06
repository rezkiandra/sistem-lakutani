<!DOCTYPE html>
<html lang="en" data-theme="light">
<shead>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/fonts/icons/icon.svg') }}">
  <title>@yield('title')</title>

  <style>
    @font-face {
      font-family: 'Poppins';
      src: url('{{ asset('assets/fonts/Poppins-Regular.ttf') }}') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
  @stack('css')

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</shead>

<body>
  <div class="mx-auto">
    @include('components.navbar')

    @yield('content')
  </div>

  @stack('js')
</body>

</html>
