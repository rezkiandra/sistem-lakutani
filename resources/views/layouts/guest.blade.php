<!DOCTYPE html>
<html lang="en" data-theme="light">
<shead>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/fonts/icons/icon.svg') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
  <title>@yield('title')</title>

  <style>
    @font-face {
      font-family: 'Poppins';
      src: url('{{ asset('assets/fonts/poppins/Poppins-Regular.ttf') }}') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    body {
      font-family: 'Poppins', sans-serif;
    }

    .bgImage {
      background-image: url('{{ asset('assets/img/bg.png') }}');
      background-position: center;
      background-size: 110%;
    }

    .navImage {
      background: url('{{ asset('assets/img/wood.png') }}');
      background-position: top -10px center;
      background-size: 10%;
    }

    .cardImage {
      background-image: url('{{ asset('assets/img/bg.png') }}');
      background-position: right -60px center;
      background-size: 250%;
    }

    .woodImage {
      background: url('{{ asset('assets/img/wood.png') }}');
      background-position: center;
      background-size: cover;
    }

    .woodCardImage {
      background: url('{{ asset('assets/img/wood.png') }}');
      background-position: top -20px center;
      background-size: cover;
    }

    .greenImage {
      background: url('{{ asset('assets/img/green.png') }}');
      background-position: center;
      background-size: cover;
    }
  </style>
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
