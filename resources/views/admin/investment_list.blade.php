@extends('layouts.app')
@section('title', 'Admin Dashboard | List of Open Investment')
@section('content')
<div id="admin">
  <div>
    <nav class="uk-navbar-container" uk-navbar>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
          <li>
            <a
              class="uk-button uk-button-small"
              style="height:3.5em !important;min-height:3.5em !important;"
              href="/admin/dashboard"
              >Home</a
            >
          </li>
        </ul>
      </div>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          <li>
            <a
              class="uk-button uk-button-small"
              style="height:3.5em !important;min-height:3.5em !important;"
              href="/user/investment/create"
              >Invest</a
            >
          </li>
        </ul>
      </div>
    </nav>
  <Investment-List></Investment-List>
  </div>
</div>
@endsection

