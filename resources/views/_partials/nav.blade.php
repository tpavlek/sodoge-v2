
@if(!(isset($nav) && $nav))
  <style>
    #nav { display:none; }
  </style>
@endif

<section id="nav">
  <a href="{{ URL::route('generator.show') }}" class="pure-button pure-button-good size-150 nav-button">
    new shibe 4 u
  </a>
  <a href="{{ URL::route('home.index') }}" class="pure-button pure-button-orange size-140 nav-button">
    dogehouse 
  </a>
  <a href="http://reddit.com/r/dogecoin" class="pure-button pure-button-yellow size-70 nav-button">
    wow
  </a>
  <a href="{{ URL::route('stats.top10') }}" class="pure-button pure-button-brown size-120 nav-button">top doges</a>
  @if (Auth::check())
    <a href="{{ URL::route('user.show', Auth::user()->id) }}" class="pure-button colour-purple size-120 nav-button">
      my dogebed
    </a>
    <a href="{{ URL::route('user.logout') }}" class="pure-button pure-button-red size-130 nav-button">
      bye
    </a>
  @else 
    <a href="{{ URL::route('user.register') }}" class="pure-button colour-purple size-120 nav-button">
      i am doge 
    </a>
  @endif
</section>
