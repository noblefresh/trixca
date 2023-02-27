@extends('layouts.app')
@section('title', 'Admin Dashboard | Gifted Investments')
@section('content')
@push('scripts_bottom')
<script>
  function confirm_action(e,t){
  e.preventDefault();
  e.target.blur();
  var self_link = t.getAttribute('href')
  var self_action = t.getAttribute('title')
  UIkit.modal.confirm(`Do you want to ${self_action}!`).then(function () {
      e.isDefaultPrevented = function(){ return false; }
    // retrigger with the exactly same event data
    location.href = self_link
  }, function () {
  });
  }
</script>
@endpush
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('admin_dashboard') }}">Home</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('gift_investment') }}">Gift</a></li>
    </ul>
  </div>
</nav>
<div class="uk-child-width-1-1">
  <div>
    <div class="uk-card uk-card-default uk-wi">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">People You Gifted Investments</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">Amount</th>
              <th class="uk-text-right">User</th>
              <th class="uk-text-right">Created</th>
              <th class="uk-text-right">Status</th>
              <th class="uk-text-right">Country</th>
              <th class="uk-text-right">Action</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            @foreach ($investments as $investment)
            @if($investment->user != null)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td class="uk-text-right">${{$investment->total_amount}}</td>
              <td class="uk-text-right">{{$investment->user->username}}</td>
              <td class="uk-text-right">
                {{ Carbon::parse(Carbon::create("{$investment->created_at}")->toDateTimeString())->diffForHumans() }}
              </td>
              <td class="uk-text-right">
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
                @case('countdown')
                <span class="grey-text mdi mdi-18px mdi-timelapse"></span>
                @break
                @case('awaiting_roi')
                <span class="blue-text mdi mdi-18px mdi-alarm-snooze"></span>
                @break
                @case('recieved')
                <span class="green-text mdi mdi-18px mdi-check-all"></span>
                @break
                @endswitch
              </td>
              <td class="uk-text-right">{{$investment->user->country}}</td>
              <td class="uk-text-right@m uk-text-left@s">
                <div class="uk-button-group">
                    <a onclick="confirm_action(event, this)" text class="uk-button uk-button-small uk-button-danger"
                      href="{{route('mark_investment', ['id'=>$investment->id, 'status'=> 'deleted'])}}"
                      key="del_failed_investment_btn_{{$investment->user->id}}"
                      title="delete investment" id="del_failed_investment_btn_{{$investment->user->id}}" uk-icon="icon: trash">
                    </a>
                    <a onclick="confirm_action(event, this)" text class="uk-button uk-button-small  blue white-text" href="{{route('investment_detail', ['id'=>$investment->id])}}"
                      title="view investment" key="view_btn_{{$investment->id}}" id="view_btn_{{$investment->id}}" uk-icon="icon: list">
                    </a>
                    <a onclick="confirm_action(event, this)" text class="uk-button uk-button-small uk-button-danger mdi mdi-24px mdi-account-cancel" href="{{route('delete_user',['id'=>$investment->user->id])}}"
                      key="ban_user_btn_{{$investment->user->id}}" title="ban investor" id="ban_user_btn_{{$investment->user->id}}">
                    </a>
                </div>
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
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
