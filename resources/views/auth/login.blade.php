@extends('layouts.app')
@section('title', __('auth.login'))
@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center white">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
  <h2 class="uk-card-title uk-text-capitalize uk-text-bold uk-text-center pink-text text-darken-2">{{__('auth.login')}}</h2>
    <form method="POST" action="{{ route('login') }}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="email" class="uk-form-label">
          {{ __('auth.email') }}
        </label>
        <div class="uk-form-control">
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: mail"></span>
            <input class="uk-input @error('email') uk-form-danger @enderror" name="email" id="email" type="email"
              value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
          </div>
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <label for="password" class="uk-form-label">
          {{ __('auth.password') }}
        </label>
        <div class="uk-form-control">
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: lock"></span>
            <input id="password" type="password" class="uk-input @error('password') uk-form-danger @enderror"
              name="password" required autocomplete="current-password">
            @error('password')
          </div>
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control uk-text-center">
          <input class="uk-checkbox" type="checkbox" name="remember" id="remember"
            {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">
            {{ __('auth.remember me') }}
          </label>
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-width-1-1 uk-background-primary white-text">
            {{ __('auth.login') }}
          </button>
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control uk-text-center">
          @if (Route::has('password.request'))
          <a class="uk-button uk-button-link uk-margin-left" href="{{ route('password.request') }}">
            {{ __('auth.reset password') }}
          </a>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
