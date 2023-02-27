@extends('layouts.admin')
@section('title', 'Gift Investment')
@section('content')
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
          href="{{ route('make_investment') }}">Merge</a></li>
    </ul>
  </div>
</nav>
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
    <h2 class="uk-card-title">Gift an investment now</h2>
    <form method="POST" action="{{route('process_new_gift')}}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="name" class="uk-form-label">
          {{ __('Select Amount') }}
        </label>
        <div class="uk-form-control">
          <select id="amount" name="amount" value="{{ old('amount') }}" autofocus
            class="uk-select @error('amount') uk-form-danger @enderror" required>
            <option value=''>Select Amount</option>
            <option value="25000">Baby {{number_format(25000)}}</option>
            <option value="50000">Learner {{number_format(50000)}}</option>
            <option value="100000">Starter {{number_format(100000)}}</option>
            <option value="200000">Medium {{number_format(200000)}}</option>
            <option value="250000">Expert {{number_format(250000)}}</option>
            <option value="500000">Investor {{number_format(500000)}}</option>
            <option value="1000000">Super User {{number_format(1000000)}}</option>
          </select>
          @error('amount')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <label for="username" class="uk-form-label">
          {{ __('Username') }}
        </label>
        <div class="uk-form-control">
          <input id="username" value="{{ old('username') }}"
            class="uk-input @error('username') uk-form-danger @enderror" name="username" required>
          @error('username')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-button-primary">
            {{ __('Invest') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
