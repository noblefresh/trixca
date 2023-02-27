<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <link rel="apple-touch-icon" sizes="57x57" href="{{URL::to("/image/misc/apple-icon-57x57.png")}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{URL::to("/image/misc/apple-icon-60x60.png")}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{URL::to("/image/misc/apple-icon-72x72.png")}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{URL::to("/image/misc/apple-icon-76x76.png")}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{URL::to("/image/misc/apple-icon-114x114.png")}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{URL::to("/image/misc/apple-icon-120x120.png")}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{URL::to("/image/misc/apple-icon-144x144.png")}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{URL::to("/image/misc/apple-icon-152x152.png")}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{URL::to("/image/misc/apple-icon-180x180.png")}}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{URL::to("/image/misc/android-icon-192x192.png")}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{URL::to("/image/misc/favicon-32x32.png")}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{URL::to("/image/misc/favicon-96x96.png")}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{URL::to("/image/misc/favicon-16x16.png")}}">
  <link rel="shortcut icon" href="{{URL::to("/image/misc/favicon-96x96.png")}}" type="image/x-icon">
  <link rel="manifest" href="{{URL::to("mix-manifest.json")}}">
  <meta name="msapplication-TileColor" content="#4CAF50">
  <meta name="msapplication-TileImage" content="{{URL::to("/image/misc/ms-icon-144x144.png")}}">
  <meta name="theme-color" content="#4CAF50 ">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="bearer-token" content="{{ csrf_token() }}">

  <title>Rico Investmento @yield('title')</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    @media (max-width: 740px) {
      .landing-text {
        padding-top: 5%;
        color: #4CAF50
      }

      .how-to-image>img {
        height: 100px;
        padding-top: 5%
      }
    }

    .navigation {
      box-shadow: 1px 1px 3px 1px white !important;
      width: 100%;
      background-color: #4CAF50 !important;
    }

    .sidenav {
      background-color: white !important;
    }

    .intro-text {
      padding-top: 5%;
      max-width: 1000px;
      margin: auto;
    }

    .intro-text>h1 {
      color: #4CAF50
    }

    .how-to-image>img {
      height: 10px;
      padding-top: 10%
    }

    .how-bg {
      background-color: black
    }

    .quote {
      padding-top: 5%;
      max-width: 700px;
      margin: 50px
    }

    p {
      font-size: 15px;
    }

    .footer {
      color: black;
      font-style: bold;
    }

    .list {
      padding-top: 5%
    }

    a {
      color: white
    }

    a:hover {
      color: black;
      text-decoration: none
    }

    /*for login page */
    .content {
      max-width: 500px;
      margin: auto;
      padding-top: %;
    }

    /* for user dash board*/
    .content-user {
      max-width: 500px;
      margin: auto;
      padding-top: 2%;
    }

    /*about page*/
    .About {
      padding-top: 10%;
      max-width: 500px;
      margin: auto;
    }
  </style>
  @stack('styles')
  <!-- Scripts -->
  @stack('scripts_top')
  @push('scripts_bottom')
  <script>
    window.default_locale = "{{ config('app.locale') }}";
  window.fallback_locale = "{{ config('app.fallback_locale') }}";
    window.Laravel = @php echo json_encode([
      'csrfToken'=> csrf_token(),
    ]) @endphp;
    @if(!auth()->guest())
      window.Laravel.userId = "{{auth()->user()->id}}";
    @endif
  </script>
</head>

<body>
  <div>
    <div id="side_nav" uk-offcanvas="mode: push; overlay: true">
      <div class="uk-offcanvas-bar white">
        <ul class="uk-nav uk-nav-default">
          <li class="uk-active uk-text-center">
            <a class=" uk-margin-small-top uk-margin-small-bottom" href="index.html">
              <span
                class="uk-label green lighten-4 uk-padding uk-padding-remove-vertical uk-text-bolder green-text uk-border-rounded"
                style="font-size: 40px;">Rico</span></a></li>
          @guest
          <li>
            <a class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="/">{{ __('app.home') }}</a>
          </li>
          @if (Route::has('login'))
          <li>
            <a class="uk-button uk-border-pill uk-background-primary white-text uk-width-1-1 uk-margin-small-bottom"
              href="{{ route('login') }}">{{ __('app.login') }}</a>
          </li>
          @endif
          @if (Route::has('register'))
          <li>
            <a class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="{{ route('register') }}">{{ __('app.register') }}</a>
          </li>
          @endif
          <li>
            <a class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="/">{{ __('app.about') }}</a>
          </li>
          @else
          @if (Auth::User()->role=='admin')
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('admin_dashboard') }}
              ">{{ __('Admin') }}</a></li>
          @endif
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('user_dashboard') }}
              ">{{ __('app.overview') }}</a></li>
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('make_investment') }}
              ">{{ __('app.invest') }}</a>
          </li>
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('list_investments') }}
              ">{{ __('app.investment') }}</a></li>
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
                {{ route('list_cashouts') }}
                ">{{ __('app.cashout') }}</a></li>
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('view_profile') }}
              ">{{ __('app.profile') }}</a></li>
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('refered_users',['referer_id'=> Auth::User()->id,'level'=>1,'ref_name'=>'Your']) }}
              ">{{ __('app.referals') }}</a>
          </li>
          @if(Auth()->user()->bonus_amount >= 100000)
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('cashout_bonus') }}
              ">{{ __('app.cashout bonus') }}</a>
          </li>
          @endif
          @if (Auth::User()->role=='admin')
          <li><a
              class="uk-button uk-border-pill uk-background-primary white-text uk-text-emphasis uk-width-1-1 uk-margin-small-bottom"
              href="
              {{ route('list_post') }}
              ">{{ __('post') }}</a></li>
          @endif
          <li>
            <a title="logout" class="uk-button uk-border-pill red lighten-1 white-text" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
              {{__("app.logout")}} <span class="mdi mdi-18px mdi-lock"></span>
            </a>
            <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
          @endguest
        </ul>
      </div>
    </div>
    @auth
    <div id="side_notif" uk-offcanvas="mode: push; overlay: true;">
      <div class="uk-offcanvas-bar grey uk-padding-remove">
        <ul id="notificationsMenu" class="uk-list uk-list-divider" style="padding: 5px !important">
          <li>
            <p>{{__("app.no notification")}}</p>
          </li>
        </ul>
      </div>
    </div>
    @endauth
    <div class="uk-dark  navigation">
      <nav class="uk-navbar-container uk-box-shadow-small uk-navbar-transparent ">
        <div class="uk-container">
          <div class="uk-navbar" data-uk-navbar>
            <div class="uk-navbar-left">
              <a class="uk-navbar-item uk-logo uk-padding-remove uk-margin-small-left  uk-margin-remove-bottom"
                href="/">
                <span class="uk-label green lighten-4 uk-text-bolder green-text uk-border-rounded"
                  style="font-size: 30px;">Rico</span>

              </a>
            </div>
            <div class="uk-navbar-right uk-margin-small-right@s">
              <ul class="uk-navbar-nav ">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="uk-visible@s ">
                  <div class="uk-animation-toggle" tabindex="0">
                    <div class="uk-padding-small">
                      <a href="{{ route('login') }}"
                        class="uk-animation-shake uk-button uk-button-large uk-border-pill green accent-3"
                        style="opacity: 0.8; box-shadow: 0px 0px 3px 0px black;
                                      color:white;max-height: 50px !important; min-height: 50px !important; height:50px;">
                        {{__("app.login")}}</a>
                    </div>

                </li>
                @endif
                @if (Route::has('register'))
                <li class="uk-visible@s ">
                  <div class="uk-animation-toggle" tabindex="0">
                    <div class="uk-padding-small ">
                      <a href="{{ route('register') }}"
                        class="uk-animation-shake uk-button uk-button-large uk-border-pill green darken-3" style="opacity: 0.8; box-shadow: 0px 0px 3px 0px black;
                                  color:white;max-height: 50px !important; min-height: 50px !important; height:50px;">
                        {{__("app.register")}}</a>
                    </div>

                </li>
                @endif
                @endguest
                @auth
                <li>
                  <button id="notifications" class="uk-navbar-toggle uk-button uk-button-text white-text" type="button"
                    uk-toggle="target: #side_notif">
                    <span class="mdi mdi-36px mdi-bell-circle"></span>
                  </button>
                </li>
                @endauth
                {{-- locale toggle --}}
                {{-- <li>
                  <button class="uk-navbar-toggle uk-button uk-button-text white-text" type="button">
                    <i class="mdi mdi-36px mdi-translate"></i>
                  </button>
                  <div uk-dropdown="pos: bottom-center;mode:click;" class="uk-padding-small uk-margin-remove-top">
                    <ul class="uk-nav uk-dropdown-nav">
                      <li><a href="{{route('setLang',['lang'=>"en"])}}">English</a></li>
                      <li><a href="{{route('setLang',['lang'=>"pt"])}}">Portuguese</a></li>
                      <li><a href="{{route('setLang',['lang'=>"fr"])}}">French</a></li>
                    </ul>
                  </div>
                </li> --}}
                <li>
                  <button class="uk-navbar-toggle uk-button uk-button-text white-text" type="button"
                    uk-toggle="target: #side_nav"><i class="mdi mdi-36px mdi-menu-open"></i></button>
                </li>
              </ul>
            </div>
          </div>
        </div>
        </li>
        </ul>
    </div>
  </div>
  </div>
  </nav>
  </div>

  <main>
    @if ($message = Session::get('success'))
    <div class="uk-alert-success uk-margin-remove-bottom" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>{{$message}}</p>
    </div>
    @endif
    @if($message = Session::get('error'))
    <div class="red lighten-3 uk-margin-remove-bottom" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>{{$message}}</p>
    </div>
    @endif
    @yield('content')
  </main>

  </div>
  <script src="{{mix('/js/manifest.js')}}" defer></script>
  <script src="{{mix('/js/vendor.js')}}" defer></script>
  <script src="{{mix('/js/app.js')}}" defer></script>
  @auth
  <script src="{{ asset('js/enable-push.js') }}"></script>
  @endauth
  @stack('scripts_bottom')
 <!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/615ecb79157d100a41ab3c06/1fhd4llvc';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
</body>

</html>
