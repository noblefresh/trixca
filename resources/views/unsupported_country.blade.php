<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{__('unsupported_country.title')}}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <style>
    html,
    body {
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
    }

    .code {
      font-size: 8rem;
      font-weight: 600;
      padding: 20px;
    }

    .link {
      font-size: 1rem;
      text-align: center;
      text-transform: uppercase;
      text-decoration: none;
      padding: 0.5em;
      border: #636b6f 1px solid;
      background-color: transparent;
      color: #636b6f;
      margin: 1em;
    }

    .link:hover {
      background-color: #636b6f;
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="code">
        <div class="text-black ">
          {{__('unsupported_country.sorry')}}
        </div>
      </div>
      <div class="title">
        {{__('unsupported_country.message',['country'=>GeoIP::getCountry())}}.
      </div>
    </div>
  </div>
</body>

</html>
