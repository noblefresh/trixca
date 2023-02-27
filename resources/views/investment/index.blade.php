@extends('layouts.app')
@section('title', __("investment_page.title"))
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">{{__('investment_page.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('make_investment') }}">{{__('investment_page.invest')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-child-width-1-1">
  <div>
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">{{__('investment_page.title')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">{{__('investment_page.amount')}}</th>
              <th class="uk-text-right">{{__('investment_page.sent')}}</th>
              <th class="uk-text-right">{{__('investment_page.sending')}}</th>
              <th class="uk-text-right">{{__('investment_page.rest')}}</th>
              <th class="uk-text-right">{{__('investment_page.time')}}</th>
              <th class="uk-text-right">{{__('investment_page.status')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($investments as $investment)
            <tr>
              <td><a class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$loop->iteration}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$investment->total_amount}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$investment->sent_amount?:0}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$investment->sending_amount?:0}}</a>
              </td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$investment->total_amount - (($investment->sent_amount?:0) + ($investment->sending_amount?:0))}}</a>
              </td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">
                  {{ Carbon::parse(Carbon::create("{$investment->created_at}")->toDateTimeString())->diffForHumans() }}
                </a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">
                  @switch($investment->status)
                  @case('created')
                  <span class="blue-text mdi mdi-18px mdi-pencil-plus"></span>
                  @break
                  @case('pending')
                  <span class="orange-text mdi mdi-18px mdi-circle-outline"></span>
                  @break
                  @case('failed')
                  <span class="red-text mdi mdi-18px mdi-close"></span>
                  @break
                  @case('confirmed')
                  <span class="green-text mdi mdi-18px mdi-check"></span>
                  @break
                  @case('merge')
                  <span class="grey-text mdi mdi-18px mdi-timelapse"></span>
                  @break
                  @case('awaiting_roi')
                  <span class="blue-text mdi mdi-18px mdi-alarm-snooze"></span>
                  @break
                  @case('closed')
                  <span class="green-text mdi mdi-18px mdi-check-all"></span>
                  @break
                  @endswitch
                </a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @if ($investments->hasPages())
      <div class="uk-text-center uk-card-footer">
        {!! $investments->links() !!}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
