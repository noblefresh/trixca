@extends('layouts.app')
@section('title', __('auth.register'))
@section('content')
    <div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center white">
        <div class="uk-card uk-card-default uk-card-body uk-width-large">
            <h2 class="uk-card-title uk-text-center uk-text-capitalize uk-text-bold">{{__('auth.register')}}</h2>
            <form method="POST" action="{{ route('register') }}" class="uk-form-stacked">
                @csrf
                <div class="uk-margin">
                    <label for="name" class="uk-form-label">
                        {{ __('auth.username') }}
                    </label>
                    <div class="uk-form-control">
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input @error('username') uk-form-danger @enderror" id="username" name="username" type="text"
                               value="{{ old('username') }}" required autocomplete="username" autofocus>
                              </div>
                        @error('username')
                            <span class="uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="email" class="uk-form-label">
                        {{ __('auth.email') }}
                    </label>
                    <div class="uk-form-control">
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: mail"></span>
                        <input class="uk-input @error('email') uk-form-danger @enderror" id="email" name="email" type="email"
                               value="{{ old('email') }}" required autocomplete="email">
                      </div>
                        @error('email')
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
                        <input id="password" type="password"
                               class="uk-input @error('password') uk-form-danger @enderror" name="password" required
                               autocomplete="new-password">
                              </div>
                        @error('password')
                            <span class="uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin">
                    <label for="referer" class="uk-form-label">
                        {{ __('auth.referer') }}
                    </label>
                    <div class="uk-form-control">
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: link"></span>
                        <input id="referer" type="text"
                               class="uk-input @error('referer') uk-form-danger @enderror" name="referer" required
                    value="@if(isset($uri_referer)) {{$uri_referer}} @else {{old('referer')}} @endif" autocomplete="referer">
                      </div>
                        @error('referer')
                            <span class="uk-text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-form-control">
                        <button type="submit" class="uk-button uk-width-1-1 uk-background-primary">
                            {{ __('auth.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
