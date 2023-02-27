@extends('layouts.app')
@section('title', __('investment_create_page.title'))
@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
    <h2 class="uk-card-title uk-text-bold">{{__('investment_create_page.title')}}</h2>
    <form method="POST" action="{{route('process_new_investment')}}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <div class="uk-form-control">
          <select id="amount" name="amount" value="{{ old('amount') }}" autofocus
            class="uk-select @error('amount') uk-form-danger @enderror" required>
            <option value=''>{{__('investment_create_page.select amount')}}</option>
            @foreach ([5000,10000, 20000, 30000, 50000,100000] as $amt)
            <option value='{{$amt}}'>{{number_format($amt)}}</option>
            @endforeach --}}
          </select>
          @error('amount')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-width-1-1 uk-button-primary">
            {{ __('investment_create_page.invest') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
