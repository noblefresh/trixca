@extends('layouts.app')
@section('title', __('auth.reset password'))
@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
    @if (session('status'))
    <div class="uk-alert-success" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>{{session('status')}}</p>
    </div>
    @endif
    <h2 class="uk-card-title">{{__('auth.reset password')}}</h2>
    <form method="POST" action="{{ route('password.email') }}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="email" class="uk-form-label">
          {{ __('auth.email') }}
        </label>
        <div class="uk-form-control">
          <input class="uk-input @error('email') uk-form-danger @enderror" name="email" id="email" type="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>
          @error('email')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-width-1-1 uk-background-primary white-text">
            {{ __('auth.send reset link') }}
          </button>

        </div>
      </div>
    </form>
  </div>
</div>
@endsection
