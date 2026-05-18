<!DOCTYPE html>
<html lang="en" data-theme="light">
<shead>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/fonts/icons/icon.svg') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
  <title>@yield('title')</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])

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
		
    .bgImage2 {
      background-image: url('{{ asset('assets/img/bg2.png') }}');
      background-position: center;
      background-size: 110%;
    }

    .navImage {
      background: url('{{ asset('assets/img/wood.png') }}');
      background-position: top center;
      background-size: cover;
			background-repeat: no-repeat;
    }

    .cardImage {
      background-image: url('{{ asset('assets/img/bg2.png') }}');
      background-position: top -80px center;
      background-size: cover;
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

		.btnImage {
			background: url('{{ asset('assets/img/yellow.png') }}');
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
		@include('components.toast')
  </div>

  @stack('js')
</body>

</html>
