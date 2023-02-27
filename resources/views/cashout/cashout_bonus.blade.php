@extends('layouts.app')
@section('title', __('cashout_bonus_page.title'))
@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
  <h2 class="uk-card-title uk-text-bold uk-text-capitalize uk-text-center puple-text">{{__('cashout_bonus_page.title')}}</h2>
    <form method="POST" action="{{route('process_cashout_bonus')}}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="amount" class="uk-form-label">
          {{ __('cashout_bonus_page.amount') }}
        </label>
        <div class="uk-form-control">
          <select id="price" name="price" value="{{ old('price') }}" autofocus
            class="uk-select @error('price') uk-form-danger @enderror" required>
            <option value=''>{{__('cashout_bonus_page.select amount')}}</option>
            @php
            $cashable_times = (Auth()->user()->bonus_amount-(Auth()->user()->bonus_amount % 100000)/ 100000);
            $cashable_amt = Auth()->user()->bonus_amount-(Auth()->user()->bonus_amount % 100000);
            @endphp
            @for ($i = 100000; $i <= $cashable_amt; $i+=100000) <option value='{{$i}}'>${{number_format($i)}}</option>
              @endfor
          </select>
          @error('price')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-button-primary uk-background-primary uk-width-1-1">
            {{ __('cashout_bonus_page.cashout') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
