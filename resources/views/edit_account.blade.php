@extends('layouts.app')
@section('title', __('edit_account_page.change account details'))
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">{{__('edit_account_page.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button red-text uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('view_profile') }}">{{__('edit_account_page.cancel')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-grid-match uk-grid-small uk-flex-center" uk-grid>
  <div class="uk-width-1-2@xl uk-width-1-2@l  uk-width-5-6@m uk-width-1-1@s">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-bold  pink-text text-darken-2">
            {{__('edit_account_page.change account details')}}
          </h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <form method="POST" action="{{ route('process_profile_update_data') }}">
          @csrf
          <ul class="uk-list uk-margin-remove-top">
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="first_name" class="uk-form-label">
                  {{__('edit_account_page.first name')}}
                </label>
                <input class="uk-input @error('first_name') uk-form-danger @enderror" id="first_name" name="first_name"
                  type="text" value="{{ old('first_name')?:Auth::User()->first_name }}" required
                  autocomplete="given-name" autofocus>
                @error('first_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="last_name" class="uk-form-label">
                  {{__('edit_account_page.last name')}}
                </label>
                <input class="uk-input @error('last_name') uk-form-danger @enderror" id="last_name" name="last_name"
                  type="text" value="{{ old('last_name')?:Auth::User()->last_name }}" required
                  autocomplete="family-name">
                @error('last_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="username" class="uk-form-label">
                  {{__('edit_account_page.username')}}
                </label>
                <input class="uk-input @error('username') uk-form-danger @enderror" id="username" name="username"
                  type="text" value="{{ old('username')?:Auth::User()->username }}" required autocomplete="username">
                @error('username')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="email" class="uk-form-label">
                  {{__('edit_account_page.email')}}
                </label>
                <input class="uk-input @error('email') uk-form-danger @enderror" id="email" name="email" type="email"
                  value="{{ old('email')?:Auth::User()->email }}" required autocomplete="email">
                @error('email')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="phone" class="uk-form-label">
                  {{__('edit_account_page.phone')}}
                </label>
                <input class="uk-input @error('phone') uk-form-danger @enderror" id="phone" name="phone" type="phone"
                  value="{{ old('phone')?:Auth::User()->phone }}" required>
                @error('phone')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-margin">
                <div class="uk-form-control">
                  <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                    {{ __('edit_account_page.update') }}
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
