@extends('layouts.app')
@section('title', __('cashout_page.title'))
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">{{__('cashout_page.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('make_investment') }}">{{__('cashout_page.invest')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-child-width-1-1">
  <div>
    <div class="uk-card uk-card-default uk-wi">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">{{__('cashout_page.cashouts')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">{{__('cashout_page.amount')}}</th>
              <th class="uk-text-right">{{__('cashout_page.received')}}</th>
              <th class="uk-text-right">{{__('cashout_page.receiving')}}</th>
              <th class="uk-text-right">{{__('cashout_page.rest')}}</th>
              <th class="uk-text-right">{{__('cashout_page.time')}}</th>
              <th class="uk-text-right">{{__('cashout_page.status')}}</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            @foreach ($cashouts as $cashout)
            <tr>
              <td><a class="uk-link-text" href="{{route('show_cashout',['id'=>$cashout->id])}}">{{$loop->iteration}}</a>
              </td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">{{$cashout->total_amount}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">{{$cashout->recieved_amount?:0}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">{{$cashout->recieving_amount?:0}}</a>
              </td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">{{($cashout->total_amount - ($cashout->recieved_amount?:0 + $cashout->recieving_amount?:0))}}</a>
              </td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">
                  {{ Carbon::parse(Carbon::create("{$cashout->created_at}")->toDateTimeString())->diffForHumans() }}
                </a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_cashout',['id'=>$cashout->id])}}">
                  @switch($cashout->status)
                  @case('open')
                  <span class="blue-text mdi mdi-18px mdi-pencil-plus"></span>
                  @break
                  @case('locked')
                  <span class="grey-text mdi mdi-18px mdi-timelapse"></span>
                  @break
                  @case('failed')
                  <span class="red-text mdi mdi-18px mdi-close"></span>
                  @break
                  @case('closed')
                  <span class="green-text mdi mdi-18px mdi-check-all"></span>
                  @break
                  @endswitch
                </a></td>
            </tr>
            @endforeach
          </tbody>
          </tbody>
        </table>
      </div>
      @if ($cashouts->hasPages())
      <div class="uk-text-center uk-card-footer">
        {!! $cashouts->links() !!}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
