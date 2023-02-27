@extends('layouts.app')
@section('title', 'Change wave details')
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
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-bold pink-text text-darken-2">
            Change Bank details
          </h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <form method="POST" action="{{ route('process_momo_update_data') }}">
          @csrf
          <ul class="uk-list uk-margin-remove-top">
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="bank_name" class="uk-form-label">
                  Bank name
                </label>
                <input class="uk-input @error('bank_name') uk-form-danger @enderror" id="bank_name" name="bank_name"
                  type="text" value="{{ old('bank_name')?:Auth::User()->momo_service_name }}" required autofocus>
                @error('bank_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="account_name" class="uk-form-label">
                  Account name
                </label>
                <input class="uk-input @error('account_name') uk-form-danger @enderror" id="account_name"
                  name="account_name" type="text" value="{{ old('account_name')?:Auth::User()->momo_name }}" required
                  autocomplete="given-name" autofocus>
                @error('account_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-form-control">
                <label for="account_number" class="uk-form-label">
                  Account number
                </label>
                <input class="uk-input @error('account_number') uk-form-danger @enderror" id="account_number"
                  name="account_number" type="text" value="{{ old('account_number')?:Auth::User()->momo_number }}"
                  required autofocus>
                @error('account_number')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </li>
            <li class="uk-padding-small uk-margin-remove">
              <div class="uk-margin">
                <div class="uk-form-control">
                  <button type="submit" class="uk-button uk-width-1-1 uk-button-primary">
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
