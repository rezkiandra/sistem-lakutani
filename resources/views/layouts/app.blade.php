<!DOCTYPE html>
<html lang="en" data-theme="light">
<shead>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/fonts/icons/icon.svg') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
  <title>@yield('title')</title>
  @stack('css')

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</shead>

<body class="bgImage">
  <div class="mx-auto">
    @include('components.navbar')
    @yield('content')
  </div>

  @stack('js')
</body>

</html>
