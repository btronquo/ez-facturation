<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>EZ-Facturation</title>
    <link rel="stylesheet" href="/css/app.css" />
    <style>
      body {
        height: 100%;
        background-image: url("/img/bg.jpg");
          background-position: center top;
          background-size: 100% auto;
        color:antiquewhite;
      }
      a {
        color: #fff;
      }
      a:hover {
        color:crimson;
      }
    </style>
  </head>

  <body class="text-center">
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column" id="app">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">EZ FACTURATION</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link" href="#">Features</a>
            <a class="nav-link" href="#">Contact</a>

            @if (Route::has('login'))
                  @auth
                      <a class="nav-link" href="{{ url('/home') }}">Dashboard</a>
                  @else
                      <a class="nav-link" href="{{ route('login') }}">Login</a>
                  @endauth
          @endif


          </nav>
        </div>
      </header>

    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
