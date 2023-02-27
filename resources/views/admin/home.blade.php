@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@push('scripts_top')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endpush
@section('content')

<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">Home</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      @if(Auth()->user()->is_admin())
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
        href="{{ route('create_transaction') }}">Merge</a></li>
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('gift_cashout') }}">Gift</a></li>
      @else
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
        href="{{ route('make_investment') }}">Invest</a></li>
      @endif
    </ul>
  </div>
</nav>
<div class="uk-child-width-1-1">
  <div>
    <div class="uk-card uk-card-default uk-wi">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">Take a Pick</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-small">
        {{-- <div class="uk-width-1-1">
            <div class="uk-card uk-card-default ">
              <div class="uk-card-body uk-padding-remove">
                {!! $chart->container() !!}
              </div>
            </div>
          </div> --}}
        <div class="uk-grid-small uk-grid-match uk-flex-center uk-child-width-1-1 uk-child-width-1-2@s uk-flex-center"
          uk-grid>
          @foreach ($summary as $item)
          <div>
            <div class="uk-card uk-card-default uk-border-rounded">
              <div class="uk-card-header uk-padding-small {{$item['color']}} accent-2 uk-border-rounded">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-auto"><i
                class="mdi mdi-24px {{$item['icon']}} white-text"></i>
                  </div>
                  <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom white-text">{{$item['title']}}</h3>
                    <p class="uk-text-meta uk-margin-remove-top white-text">{{$item['count']}}</time>
                    </p>
                  </div>
                  <div class="uk-width-auto"><a href="{{$item['route']?route($item['route']):'#'}}" class="uk-btn uk-padding-small uk-border-circle white "><i
                    class="mdi mdi-24px mdi-link-variant {{$item['color']}}-text text-accent-2"></i></a>
                      </div>
                </div>
              </div>
            <div class="uk-card uk-card-body"></div>
          </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
{{-- {!! $chart->script() !!} --}}
@endsection
