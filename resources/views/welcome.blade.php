@extends('layouts.app')

@section('content')
<div class="uk-position-relative uk-visible-toggle uk-light" uk-slideshow="min-height: 500; max-height: 800"
  tabindex="-1" uk-slideshow="animation: fade" autoplay="true">

  <ul class="uk-slideshow-items">
    <li>
      <img src="image/misc/HEAD-image9.png" alt="" uk-cover>
      <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
        <h3 class="uk-margin-remove">{{__('welcome.did you know')}}</h3>
        <p class="uk-margin-remove">{{__('welcome.You can make money from home')}}</p>
      </div>
    </li>
    <li>
      <img src="image/misc/pic1.png" alt="" uk-cover>
      <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center uk-transition-slide-bottom">
        <h3 class="uk-margin-remove">{{__('welcome.investment is the key')}}</h3>
        <p class="uk-margin-remove">{{__('welcome.making investment')}}</p>
      </div>
    </li>
  </ul>

  <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
    uk-slideshow-item="previous"></a>
  <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
    uk-slideshow-item="next"></a>

</div>
<div class="uk-container ">
  <div uk-grid style="margin-top: 5%;">
    <div class="uk-width-1-2@m  uk-width-1-1@s">
      <img src="image/misc/unnamed.png" style="height: auto;" />
    </div>
    <div class="uk-width-1-2@m uk-width-1-1@s">
      <h2 class=" uk-h2 uk-text-bold green-text">{{__('welcome.making investment')}}</h2>
      <p style="font-weight: bold;">
        {{__('welcome.intro-text-1')}}
      </p>
    </div>
  </div>
</div>
<div class="uk-container uk-margin-bottom">
  <div uk-grid style="margin-top: 5%;">
    <div class="uk-width-1-2@m uk-width-1-1@s">
      <h2 class=" uk-h2 uk-text-bold green-text">{{__('welcome.how it works')}}</h2>
      <div>
        <p style="font-weight: bold;">
          1. {{__('welcome.register')}}
        </p>
        <p>{{__('welcome.step1')}}</p>
      </div>
      <div>
        <p style="font-weight: bold;">
          2. {{__('welcome.invest')}}
        </p>
        <p>{{__('welcome.step2')}}</p>
      </div>
      <div>
        <p style="font-weight: bold;">
          3. {{__('welcome.wait')}}
        </p>
        <p>{{__('welcome.step3')}}</p>
      </div>
      <div>
        <p style="font-weight: bold;">
          4. {{__('welcome.receive')}}
        </p>
        <p>{{__('welcome.step4')}}</p>
      </div>
    </div>
    <div class="uk-width-1-2@m  uk-width-1-1@s">
      <img src="image/misc/how.png" style="height: auto;" />
    </div>
  </div>
  <h2 class=" uk-h2 uk-text-bold green-text">{{__('welcome.why you should invest')}}</h2>
  <p style="font-weight: bold;">
    “{{__('welcome.intro-text-2')}}”
  </p>
  <a href="{{route('login')}}" class="uk-button uk-button-default uk-button-large green white-text">{{__('welcome.get started')}}</a>
</div>

<!--=====footer=====-->
<footer>
  <div class="footer green darken-1">
    <div class="uk-container uk-text-center list">
      <p class="uk-padding-small">
        {{__('welcome.footer-about')}}
        </li>
    </div>

    <div class="disclaimer">
      <div class="uk-container uk-padding-small">
        <p class="uk-text-center uk-text-large uk-margin-remove-bottom">
          <a href="mailto:help@ricoinvestmento.com ">help@ricoinvestmento.com</a>
          <br/> Whatsapp: <a href="https://wa.link/nj1gi6">+221708997308</a>
        </p>
        <p class="uk-text-center uk-text-bold uk-margin-small-top">
          &copy;
          {{now()->format('Y')}}
          ricoinvestmento.com, All rights reserved.
        </p>
      </div>
    </div>
  </div>
</footer>

@endsection
