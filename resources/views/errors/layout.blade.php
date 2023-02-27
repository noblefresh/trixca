<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 1.5rem;
                padding: 20px;
                color: #ff8a80;
            }
            .code {
                font-size: 8rem;
                font-weight: 600;
                padding: 20px;
                color: #ff8a80;
            }
            .link{
              font-size: 1rem;
              text-align: center;
              text-transform: uppercase;
              text-decoration: none;
              padding: 0.5em;
              border: #ff8a80 1px solid;
              background-color: transparent;
              color: #ff8a80;
              margin: 1em;
            }
            .link:hover{
              background-color: #ff8a80;
              color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
              <div class="code">
                <div class="text-black ">
                  @yield('code', __('Oh no'))
              </div>
              </div>
                <div class="title">
                    @yield('message')
                </div>
                <div>
                  <a class="link" href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                        {{ __('Go Home') }}
                </a>
                </div>
            </div>
        </div>
    </body>
</html>
