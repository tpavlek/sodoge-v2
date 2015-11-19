<html>
  <head>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">  
    <link rel="stylesheet" href="/css/all.css">
    <link rel="icon" href="/img/std/favicon.ico" type="image/x-icon" />
    <title>@yield('title', "") SO DOGE WOOF</title>
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    @yield('additional_head', "")
  </head>
  
  <body>  
    @include('_partials/nav')
    <div id="container">
      <img src="/img/std/nav-shibe.png" class="nav-shibe" />
      <div id="content">
        @yield('content')
      </div>

      <div id="footer">
        <div class="pure-g-r">
          <div class="pure-u-1">
            Wow such coins pls donate<br/>
            DJWx1koXc87Wsp1CSE27ttvVCNrhZPe7pF
          </div>
        </div>
      </div>
    </div>

    <script>
      $('.nav-shibe').click(function() {
          if ($('#nav').is(':visible')) {
            $('#nav').hide('fast');  
          }
          else {
            $('#nav').show('fast');
          }
          });
    </script>
  </body>
</html>
