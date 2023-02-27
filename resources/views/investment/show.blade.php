@extends('layouts.app')
@section('title', __('investment.title1'))
@push('scripts_bottom')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
  function view_pop(param) {
      let pop_url = param;
      Swal.fire({
        showCloseButton: true,
        confirmButtonText: "Ok",
        title: "Viewing POP",
        html: `<img data-src='//localhost:8000/image/pop/${pop_url}' width='400' height='200' alt='pop placeholder' style='height:50vh;object-fit:cover;' class='uk-width-1-1 uk-border-rounded' uk-img>`,
        onDestroy: () => {
          pop_url = null;
        }
      });
    }
</script>
@endpush
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('admin_dashboard') }}">{{__('investment_show.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{route('list_investments')}}">{{__('investment_show.back')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-grid-match uk-grid-small uk-flex-center" uk-grid>
  <div class="uk-width-1-2@xl uk-width-1-2@l  uk-width-3-4@m uk-width-1-1@s">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">@if(Auth::User()->role == 'admin') {{__('investment_show.title1')}} @else
            {{__('investment_show.title2')}} @endif</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <div
          class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match uk-child-width-1-3"
          uk-grid>
          <div>
            <div class="uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h5 class="uk-margin-remove-bottom">{{__('investment_show.amount')}}:</h5>
                <p class="uk-text-meta uk-margin-remove-top">{{$investment->total_amount}}</p>
              </div>
            </div>
          </div>
          <div>
            <div class="uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h5 class="uk-margin-remove-bottom">{{__('investment_show.created')}}:</h5>
                <p class="uk-text-meta uk-margin-remove-top">
                  {{ Carbon::parse("{$investment->created_at}")->diffForHumans() }}
                </p>
              </div>
            </div>
          </div>
          <div>
            <div class="uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h5 class="uk-margin-remove-bottom">{{__('investment_show.status')}}:</h5>
                <p class="uk-text-meta uk-margin-remove-top">
                  @switch($investment->status)
                  @case('created')
                  <span class="blue-text mdi mdi-18px mdi-pencil-plus"></span>
                  @break
                  @case('pending')
                  <span class="orange-text mdi mdi-18px mdi-circle-outline"></span>
                  @break
                  @case('failed')
                  <span class="red-text mdi mdi-18px mdi-close"></span>
                  @break
                  @case('merge')
                  <span class="blue-text mdi mdi-18px mdi-alarm-snooze"></span>
                  @break
                  @case('completed')
                  <span class="green-text mdi mdi-18px mdi-check-all"></span>
                  @break
                  @endswitch
                </p>
              </div>
            </div>
          </div>
        </div>
        <hr class="uk-margin-small">
        <ul class="uk-list uk-list-divider uk-text-center">
          <li>
            <div class="uk-grid-collapse uk-grid-divider uk-text-center uk-grid-match uk-child-width-1-3" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.sent')}} {{__('investment_show.amount')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">{{$investment->sent_amount}}</p>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.sending')}} {{__('investment_show.amount')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">{{$investment->sending_amount}}</p>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.remainder')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">{{$investment->total_amount - ($investment->sending_amount + $investment->sent_amount)}}</p>
                  </div>
                </div>
              </div>
            </div>
          </li>
          @if(Auth()->user()->is_admin())
          <li>
            <div class="uk-grid-collapse uk-grid-divider uk-text-center uk-grid-match uk-child-width-1-3" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.name')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">
                      {{$investment->user->last_name.' '.$investment->user->first_name}}</p>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.username')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">
                      {{$investment->user->username}}
                    </p>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.joined')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">
                      {{ Carbon::parse("{$investment->user->created_at}")->diffForHumans() }}</p>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="uk-grid-collapse uk-grid-divider uk-text-center uk-grid-match uk-child-width-1-2" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.phone')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">{{$investment->user->phone}}</p>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom">{{__('investment_show.email')}}:</h5>
                    <p class="uk-text-meta uk-margin-remove-top">
                      {{$investment->user->email}}
                    </p>
                  </div>
                </div>
              </div>
          </li>
          @endif
        </ul>
        <hr class="uk-margin-small">
      </div>
    </div>
  </div>
  <div class="uk-width-1-2@xl uk-width-1-2@l  uk-width-3-4@m uk-width-1-1@s">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">{{__('investment_show.transactions')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-small uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">{{__('investment_show.amount')}}</th>
              <th class="uk-text-right">{{__('investment_show.sender')}}</th>
              <th class="uk-text-right">{{__('investment_show.receiver')}}</th>
              <th class="uk-text-right">{{__('investment_show.pop')}}</th>
              <th class="uk-text-right">{{__('investment_show.time')}}</th>
              <th class="uk-text-right">{{__('investment_show.status')}}</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            @foreach ($investment_transactions as $transaction)
            <tr id="transaction_{{$transaction->id}}}">
              <td>{{ $loop->iteration }}</td>
              <td class="uk-text-right">{{ number_format($transaction->amount) }}</td>
              <td class="uk-text-right">{{ $transaction->sender == Auth()->user()->username? {{__('investment_show.you')}}: $transaction->sender  }}</td>
              <td class="uk-text-right">{{ $transaction->reciever == Auth()->user()->username? {{__('investment_show.you')}}: $transaction->reciever }}</td>
              <td class="uk-text-right">
                @if($transaction->pop_url == null)
                <span class="uk-label">NaN</span>
                @else
                <span onclick="view_pop('{{$transaction->pop_url}}')" style="cursor: pointer;" class="uk-label">{{__('investment_show.view')}}
                  {{__('investment_show.pop')}}</span>
                @endif
              </td>
              <td class="uk-text-right">
                {{ $transaction->time_diff }}
              </td>
              <td class="uk-text-right">
                @if ($transaction->status =="created")
                <span class="blue-text mdi mdi-18px mdi-pencil-plus"></span>
                @elseif($transaction->status =="failed")
                <span class="red-text mdi mdi-18px mdi-close"></span>
                @elseif($transaction->status =="completed")
                <span class="green-text mdi mdi-18px mdi-check-all"></span>
                @endif
              </td>
              @endforeach
          </tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
