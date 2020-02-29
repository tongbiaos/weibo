<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App AX') - TBS111</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
    @include('layouts._header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        <p>12345</p>
        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>

  </body>
</html>
