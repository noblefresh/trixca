@extends('layouts.admin')
@section('title', 'Create Transaction')
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
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('gift_cashout') }}">Gift</a></li>
    </ul>
  </div>
</nav>
<div id="admin">
<Create-Transaction></Create-Transaction>
</div>
@endsection
